<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;


class ProductController extends Controller
{
    /**
     * Muestra un listado del recurso.
     */
    public function index()
    {
        $products = Product::all();
        if (request()->wantsJson()) {
            return response()->json($products);
        }
        return view('admin.products.index', compact('products'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->validated());

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Producto creado exitosamente.', 'product' => $product], 201);
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->validated());

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Producto actualizado exitosamente.', 'product' => $product]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Producto eliminado exitosamente.']);
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Muestra un listado del recurso para consumo de la API.
     */
    public function apiIndex()
    {
        return response()->json(Product::all());
    }
}
