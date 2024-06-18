<?php

namespace App\Http\Controllers;

class ProductsController extends Controller
{
    public function index()
    {
        $products = [
          collect([
              'id' => 1,
              'name' => 'Notebook',
              'price' => 1000.00,
          ]),
          collect([
              'id' => 2,
              'name' => 'Tablet',
              'price' => 500.50,
          ]),
          collect([
              'id' => 3,
              'name' => 'Mouse',
              'price' => 50.00,
          ]),
          collect([
              'id' => 4,
              'name' => 'Teclado',
              'price' => 100.00,
          ]),
        ];

        return view('app.products', compact('products'));
    }
}
