<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(2);

        return view('app.products', compact('products'));
    }
}
