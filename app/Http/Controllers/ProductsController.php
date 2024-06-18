<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);

        return view('app.products', compact('products'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso.');
    }

    public function update(UpdateProductRequest $request, string $productId)
    {
        if (!$product = Product::find($productId)) {
            return redirect()->route('products.index')->with('error', 'Produto não encontrado.');
        }

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(string $productId)
    {
        if (!$product = Product::find($productId)) {
            return redirect()->route('products.index')->with('error', 'Produto não encontrado.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso.');
    }
}
