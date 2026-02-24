@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Gestión de Pedidos</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('admin.orders.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Crear Nuevo Pedido
        </a>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-white-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Usuario</th>
                    <th scope="col" class="px-6 py-3">Total</th>
                    <th scope="col" class="px-6 py-3">Unidades</th>
                    <th scope="col" class="px-6 py-3">Estado</th>
                    <th scope="col" class="px-6 py-3">Fecha</th>
                    <th scope="col" class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $order->id }}</th>
                        <td class="px-6 py-4">{{ $order->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $order->total }}</td>
                        <td class="px-6 py-4">
                            {{ $order->items->sum('quantity') }}
                        </td>
                        <td class="px-6 py-4">{{ $order->status }}</td>
                        <td class="px-6 py-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 flex items-center space-x-2">
                            @if ($order->status === 'pending')
                                <form action="{{ route('admin.orders.accept', $order) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="font-medium text-green-600 dark:text-green-500 hover:underline">Aceptar</button>
                                </form>
                            @endif
                            @if ($order->status === 'accepted')
                                <a href="{{ route('admin.orders.ship.form', $order) }}" class="font-medium text-purple-600 dark:text-purple-500 hover:underline mr-3">Enviar</a>
                            @endif
                            <a href="{{ route('admin.orders.edit', $order) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este pedido?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
