<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
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
}
