@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Crear Nuevo Pedido</h1>

    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg p-6">
        <form action="{{ route('admin.orders.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="total" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total</label>
                <input type="number" name="total" id="total" value="{{ old('total') }}" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                @error('total')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completado</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

           
            {{--
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Productos</label>
                @foreach($products as $product)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="products[{{ $product->id }}][selected]" id="product_{{ $product->id }}" class="mr-2">
                        <label for="product_{{ $product->id }}" class="text-sm text-gray-700 dark:text-gray-300">{{ $product->name }} ({{ $product->price }}€)</label>
                        <input type="number" name="products[{{ $product->id }}][quantity]" class="ml-4 w-20 rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Cantidad" min="1">
                    </div>
                @endforeach
            </div>
            --}}

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Crear Pedido
                </button>
            </div>
        </form>
    </div>
@endsection
