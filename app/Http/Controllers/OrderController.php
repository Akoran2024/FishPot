<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Muestra un listado de los recursos para la API.
     */
    public function apiIndex()
    {
        $orders = Order::with(['user', 'items.product'])->latest()->get();
        return response()->json($orders);
    }

    /**
     * Muestra un listado de los pedidos del usuario autenticado.
     */
    public function userOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product'])
            ->latest()
            ->get();
        return response()->json($orders);
    }

    /**
     * Muestra un listado del recurso.
     */
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        // Se obtienen los productos para la selección en la vista
        $products = Product::all(); 
        return view('admin.orders.create', compact('products'));
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(OrderStoreRequest $request)
    {
        DB::transaction(function () use ($request) {
            // Se eliminan los detalles simulados de la tarjeta antes de crear el pedido
            $validatedData = $request->validated();
            unset($validatedData['card_holder']);
            unset($validatedData['card_number']);
            unset($validatedData['card_expiry']);
            unset($validatedData['card_cvc']);

            $order = Order::create($validatedData + [
                'user_id' => Auth::id(),
                'status' => 'pending', // Asegurar que el estado esté establecido
            ]);

            foreach ($request->validated('items') as $itemData) {
                $product = Product::findOrFail($itemData['id']);

                // Verificar disponibilidad de stock
                if ($product->stock < $itemData['quantity']) {
                    throw new \Exception('Stock insuficiente para el producto: ' . $product->name);
                }

                // Decrementar stock
                $product->stock -= $itemData['quantity'];
                $product->save();

                // Crear el ítem del pedido (OrderItem)
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $itemData['quantity'],
                    'price' => $product->price, // Almacenar el precio en el momento de la compra
                ]);
            }
        });

        // El componente Carrito.vue espera una respuesta JSON, no una redirección.
        return response()->json(['message' => 'Pedido creado exitosamente y stock actualizado.'], 201);
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Order $order)
    {
        // Se pasan los productos por si se editan los ítems del pedido
        $products = Product::all(); 
        return view('admin.orders.edit', compact('order', 'products'));
    }

    /**
     * Muestra el formulario para el envío del pedido especificado.
     */
    public function showShipForm(Order $order)
    {
        return view('admin.orders.ship', compact('order'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(OrderUpdateRequest $request, Order $order)
    {
        DB::transaction(function () use ($request, $order) {
            $order->update($request->validated());

            // Si se proporcionan ítems en la petición, actualizar ítems y stock
            if ($request->has('items')) {
                // 1. Restaurar stock antiguo
                foreach ($order->items as $oldItem) {
                    $product = Product::find($oldItem->product_id);
                    if ($product) {
                        $product->stock += $oldItem->quantity;
                        $product->save();
                    }
                }

                // 2. Eliminar ítems de pedido existentes
                $order->items()->delete();

                // 3. Procesar nuevos ítems (similar al método store)
                foreach ($request->validated('items') as $itemData) {
                    $product = Product::findOrFail($itemData['id']);

                    // Verificar disponibilidad de stock
                    if ($product->stock < $itemData['quantity']) {
                        throw new \Exception('Stock insuficiente para el producto: ' . $product->name);
                    }

                    // Decrementar stock
                    $product->stock -= $itemData['quantity'];
                    $product->save();

                    // Crear nuevo ítem de pedido
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $itemData['quantity'],
                        'price' => $product->price,
                    ]);
                }
            }
        });

        return redirect()->route('admin.orders.index')->with('success', 'Pedido actualizado exitosamente y stock actualizado.');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {
            // Restaurar stock para todos los ítems del pedido
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }

            $order->delete(); // Esto también eliminará los ítems relacionados vía cascada
        });
        
        return redirect()->route('admin.orders.index')->with('success', 'Pedido eliminado exitosamente y stock restaurado.');
    }

    /**
     * Acepta el pedido especificado (API).
     */
    public function apiAccept(Order $order)
    {
        if ($order->status === 'pending') {
            $order->status = 'accepted';
            $order->save();
            return response()->json(['message' => 'Pedido aceptado.', 'order' => $order->load(['user', 'items.product'])]);
        }
        return response()->json(['message' => 'No se puede aceptar el pedido.'], 422);
    }

    /**
     * Envía el pedido especificado (API).
     */
    public function apiShip(Request $request, Order $order)
    {
        // Permitimos 'accepted' para procesar el envío, o 'shipped' si se está re-intentando
        if (in_array($order->status, ['accepted', 'shipped'])) {
            // Si se envían datos de envío en la petición API, los actualizamos
            $shippingData = $request->only([
                'shipping_address', 
                'shipping_city', 
                'shipping_state', 
                'shipping_zip_code', 
                'shipping_country', 
                'tracking_number'
            ]);
            
            if (!empty(array_filter($shippingData))) {
                $order->update($shippingData);
            }

            if ($order->status !== 'shipped') {
                $order->status = 'shipped';
                $order->save();
            }

            // Enviar factura por correo
            try {
                Mail::to($order->user->email)->send(new InvoiceMail($order));
            } catch (\Exception $e) {
                // Registrar error pero no detener el proceso de respuesta
                \Log::error('Error enviando factura al pedido ' . $order->id . ': ' . $e->getMessage());
                
                // Si es un reintento y falla el correo, devolvemos éxito del pedido igualmente
                return response()->json([
                    'message' => 'Pedido marcado como enviado, pero hubo un problema enviando el correo de la factura.', 
                    'order' => $order->load(['user', 'items.product']),
                    'mail_error' => true
                ]);
            }

            return response()->json([
                'message' => 'Pedido enviado y factura emitida exitosamente.', 
                'order' => $order->load(['user', 'items.product'])
            ]);
        }
        
        return response()->json([
            'message' => 'El pedido no puede ser enviado. Estado actual: ' . $order->status
        ], 422);
    }

    /**
     * Cancela/Rechaza el pedido especificado (API).
     */
    public function apiCancel(Order $order)
    {
        DB::transaction(function () use ($order) {
            // Restaurar stock
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }
            $order->status = 'cancelled';
            $order->save();
        });
        return response()->json(['message' => 'Pedido rechazado y stock restaurado.', 'order' => $order->load(['user', 'items.product'])]);
    }

    /**
     * Acepta el pedido especificado.
     */
    public function accept(Order $order)
    {
        if ($order->status === 'pending') {
            $order->status = 'accepted';
            $order->save();
            return back()->with('success', 'Pedido aceptado exitosamente.');
        }
        return back()->with('error', 'El pedido no puede ser aceptado en su estado actual.');
    }

    /**
     * Envía el pedido especificado.
     */
    public function ship(OrderUpdateRequest $request, Order $order)
    {
        if ($order->status === 'accepted') {
            $order->update($request->validated()); // Actualiza el pedido con detalles de envío
            $order->status = 'shipped'; // Establece el estado a enviado explícitamente
            $order->save();

            // Enviar factura por correo
            Mail::to($order->user->email)->send(new InvoiceMail($order));

            return redirect()->route('admin.orders.index')->with('success', 'Pedido enviado exitosamente y detalles de envío guardados.');
        }
        return back()->with('error', 'El pedido no puede ser enviado en su estado actual.');
    }
}
