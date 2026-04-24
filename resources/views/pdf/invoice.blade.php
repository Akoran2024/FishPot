<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px; line-height: 24px; color: #555; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.top table td.title { font-size: 45px; line-height: 45px; color: #333; }
        .invoice-box table tr.information table td { padding-bottom: 40px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .invoice-box table tr.details td { padding-bottom: 20px; }
        .invoice-box table tr.item td{ border-bottom: 1px solid #eee; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h1>FishPot</h1>
                            </td>
                            <td>
                                Factura #: {{ $order->id }}<br>
                                Creada: {{ $order->created_at->format('d/m/Y') }}<br>
                                Enviada: {{ now()->format('d/m/Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Dirección de envío:</strong><br>
                                {{ $order->shipping_address }}<br>
                                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip_code }}<br>
                                {{ $order->shipping_country }}
                            </td>
                            <td>
                                <strong>Cliente:</strong><br>
                                {{ $order->user->name }}<br>
                                {{ $order->user->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Método de Pago</td>
                <td></td>
            </tr>
            <tr class="details">
                <td>{{ ucfirst($order->payment_method) }}</td>
                <td></td>
            </tr>
            <tr class="heading">
                <td>Producto</td>
                <td>Precio</td>
            </tr>
            @foreach($order->items as $item)
            <tr class="item">
                <td>{{ $item->product->name }} x {{ $item->quantity }}</td>
                <td>{{ number_format($item->price * $item->quantity, 2) }}€</td>
            </tr>
            @endforeach
            <tr class="total">
                <td></td>
                <td>Subtotal productos: {{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 2) }}€</td>
            </tr>
            @php
                $shipping = $order->total - $order->items->sum(function($item) { return $item->price * $item->quantity; });
            @endphp
            @if($shipping > 0)
            <tr class="total">
                <td></td>
                <td>Gastos de envío: {{ number_format($shipping, 2) }}€</td>
            </tr>
            @endif
            <tr class="total">
                <td></td>
                <td>Total a pagar: {{ number_format($order->total, 2) }}€</td>
            </tr>
        </table>
    </div>
</body>
</html>
