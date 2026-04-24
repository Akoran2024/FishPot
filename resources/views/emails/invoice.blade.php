<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Hola {{ $order->user->name }},</h2>
    <p>Tu pedido #{{ $order->id }} ha sido enviado.</p>
    <p>Adjuntamos la factura correspondiente a tu compra en FishPot.</p>
    <p>¡Gracias por confiar en nosotros!</p>
</body>
</html>
