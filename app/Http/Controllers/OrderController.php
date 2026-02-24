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

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // You might want to pass products to the view for selection
        $products = Product::all(); // Assuming you'd select products to create an order
        return view('admin.orders.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request)
    {
        DB::transaction(function () use ($request) {
            // Filter out simulated card details before creating the order
            $validatedData = $request->validated();
            unset($validatedData['card_number']);
            unset($validatedData['card_expiry']);
            unset($validatedData['card_cvc']);

            $order = Order::create($validatedData + [
                'user_id' => Auth::id(),
                'status' => 'pending', // Ensure status is set
            ]);

            foreach ($request->validated('items') as $itemData) {
                $product = Product::findOrFail($itemData['id']);

                // Check stock availability
                if ($product->stock < $itemData['quantity']) {
                    throw new \Exception('Stock insuficiente para el producto: ' . $product->name);
                }

                // Decrement stock
                $product->stock -= $itemData['quantity'];
                $product->save();

                // Create OrderItem
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $itemData['quantity'],
                    'price' => $product->price, // Store the price at the time of purchase
                ]);
            }
        });

        // The Carrito.vue component expects a JSON response, not a redirect.
        return response()->json(['message' => 'Pedido creado exitosamente y stock actualizado.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // This is typically not part of the basic web CRUD (index, create, edit)
        // If a 'show' view is desired, it can be implemented.
        // For this task, we focus on the basic CRUD operations (index, create, edit, store, update, destroy).
        return view('admin.orders.show', compact('order')); // Assuming show.blade.php will be created if needed
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        // You might want to pass products to the view for selection if order items are edited
        $products = Product::all(); // Assuming you'd select products to create/edit an order
        return view('admin.orders.edit', compact('order', 'products'));
    }

    /**
     * Show the form for shipping the specified order.
     */
    public function showShipForm(Order $order)
    {
        return view('admin.orders.ship', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderUpdateRequest $request, Order $order)
    {
        DB::transaction(function () use ($request, $order) {
            $order->update($request->validated());

            // If items are provided in the request, update order items and stock
            if ($request->has('items')) {
                // 1. Restore old stock
                foreach ($order->items as $oldItem) {
                    $product = Product::find($oldItem->product_id);
                    if ($product) {
                        $product->stock += $oldItem->quantity;
                        $product->save();
                    }
                }

                // 2. Delete existing OrderItems
                $order->items()->delete();

                // 3. Process new Order Items (similar to store method)
                foreach ($request->validated('items') as $itemData) {
                    $product = Product::findOrFail($itemData['id']);

                    // Check stock availability
                    if ($product->stock < $itemData['quantity']) {
                        throw new \Exception('Stock insuficiente para el producto: ' . $product->name);
                    }

                    // Decrement stock
                    $product->stock -= $itemData['quantity'];
                    $product->save();

                    // Create new OrderItem
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $itemData['quantity'],
                        'price' => $product->price, // Store the price at the time of purchase
                    ]);
                }
            }
        });

        return redirect()->route('admin.orders.index')->with('success', 'Pedido actualizado exitosamente y stock actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {
            // Restore stock for all items in the order
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }

            $order->delete(); // This will also delete related order items via cascade delete
        });
        
        return redirect()->route('admin.orders.index')->with('success', 'Pedido eliminado exitosamente y stock restaurado.');
    }

    /**
     * Accept the specified order.
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
     * Ship the specified order.
     */
    public function ship(OrderUpdateRequest $request, Order $order) // Changed Request to OrderUpdateRequest
    {
        if ($order->status === 'accepted') {
            $order->update($request->validated()); // Update the order with shipping details
            $order->status = 'shipped'; // Explicitly set status to shipped
            $order->save();
            return redirect()->route('admin.orders.index')->with('success', 'Pedido enviado exitosamente y detalles de envío guardados.');
        }
        return back()->with('error', 'El pedido no puede ser enviado en su estado actual.');
    }
}
