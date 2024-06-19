<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $sales = Sale::paginate(10);
        $clients = Client::all();
        $products = Product::all();

        return view('app.dashboard', compact('sales', 'clients', 'products'));
    }
}
