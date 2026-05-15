<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $items = $request->items; // [{id, quantity}]
        $shipping = $request->only(['shipping_address', 'shipping_city', 'shipping_zip_code']);

        $stripeSecret = config('services.stripe.secret');
        if (!$stripeSecret) {
            Log::error('Stripe Secret Key is missing in .env');
            return response()->json(['message' => 'Error de configuración: Claves de Stripe no encontradas.'], 500);
        }

        Stripe::setApiKey($stripeSecret);

        $lineItems = [];
        $orderItemsData = [];

        foreach ($items as $item) {
            $product = Product::findOrFail($item['id']);
            
            if ($product->stock < $item['quantity']) {
                return response()->json(['message' => 'Stock insuficiente para ' . $product->name], 422);
            }

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $product->name,
                        // 'images' => [url($product->image)],
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $item['quantity'],
            ];

            $orderItemsData[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ];
        }

        // Add shipping cost if applicable (simplified logic from frontend)
        $shippingZip = $shipping['shipping_zip_code'];
        $prefix = substr($shippingZip, 0, 2);
        $shippingCost = ($prefix === '35' || $prefix === '38') ? 0 : 9.50;

        if ($shippingCost > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Gastos de envío',
                    ],
                    'unit_amount' => $shippingCost * 100,
                ],
                'quantity' => 1,
            ];
        }

        try {
            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => url('/stripe/success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('/carrito'),
                'customer_email' => $user->email,
                'metadata' => [
                    'user_id' => $user->id,
                    'shipping_address' => $shipping['shipping_address'],
                    'shipping_city' => $shipping['shipping_city'],
                    'shipping_zip_code' => $shipping['shipping_zip_code'],
                    'order_items' => json_encode($orderItemsData),
                ],
            ]);

            return response()->json(['url' => $checkoutSession->url]);
        } catch (\Exception $e) {
            Log::error('Stripe Checkout Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error al conectar con la pasarela de pago.'], 500);
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if (!$sessionId) {
            return redirect('/carrito');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::retrieve($sessionId);
            
            if ($session->payment_status !== 'paid') {
                return redirect('/carrito')->with('error', 'El pago no se ha completado.');
            }

            // Check if order already created (to avoid duplicates on refresh)
            $existingOrder = Order::where('payment_intent', $session->payment_intent)->first();
            if ($existingOrder) {
                return redirect('/mis-pedidos');
            }

            $metadata = $session->metadata;
            $items = json_decode($metadata->order_items, true);

            DB::transaction(function () use ($metadata, $items, $session) {
                $order = Order::create([
                    'user_id' => $metadata->user_id,
                    'total' => $session->amount_total / 100,
                    'status' => 'accepted', // Paid orders are automatically accepted
                    'payment_intent' => $session->payment_intent,
                    'payment_method' => 'online_payment',
                    'shipping_address' => $metadata->shipping_address,
                    'shipping_city' => $metadata->shipping_city,
                    'shipping_zip_code' => $metadata->shipping_zip_code,
                ]);

                foreach ($items as $itemData) {
                    $product = Product::findOrFail($itemData['product_id']);
                    
                    // Decrement stock
                    $product->stock -= $itemData['quantity'];
                    $product->save();

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $itemData['quantity'],
                        'price' => $itemData['price'],
                    ]);
                }
            });

            return redirect('/mis-pedidos?payment=success')->with('success', '¡Pago realizado con éxito!');

        } catch (\Exception $e) {
            Log::error('Stripe Success Error: ' . $e->getMessage());
            return redirect('/carrito')->with('error', 'Error al procesar el resultado del pago.');
        }
    }
}
