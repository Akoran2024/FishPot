@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Enviar Pedido #{{ $order->id }}</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('admin.orders.ship', $order) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="shipping_address" class="block text-gray-700 text-sm font-bold mb-2">Dirección de Envío:</label>
                <input type="text" name="shipping_address" id="shipping_address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('shipping_address', $order->shipping_address) }}" required>
            </div>
            <div class="mb-4">
                <label for="shipping_city" class="block text-gray-700 text-sm font-bold mb-2">Ciudad:</label>
                <input type="text" name="shipping_city" id="shipping_city" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('shipping_city', $order->shipping_city) }}" required>
            </div>
            <div class="mb-4">
                <label for="shipping_state" class="block text-gray-700 text-sm font-bold mb-2">Provincia/Estado:</label>
                <input type="text" name="shipping_state" id="shipping_state" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('shipping_state', $order->shipping_state) }}" required>
            </div>
            <div class="mb-4">
                <label for="shipping_zip_code" class="block text-gray-700 text-sm font-bold mb-2">Código Postal:</label>
                <input type="text" name="shipping_zip_code" id="shipping_zip_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('shipping_zip_code', $order->shipping_zip_code) }}" required>
            </div>
            <div class="mb-4">
                <label for="shipping_country" class="block text-gray-700 text-sm font-bold mb-2">País:</label>
                <input type="text" name="shipping_country" id="shipping_country" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('shipping_country', $order->shipping_country) }}" required>
            </div>
            <div class="mb-4">
                <label for="tracking_number" class="block text-gray-700 text-sm font-bold mb-2">Número de Seguimiento:</label>
                <input type="text" name="tracking_number" id="tracking_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tracking_number', $order->tracking_number) }}">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Confirmar Envío
                </button>
                <a href="{{ route('admin.orders.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
