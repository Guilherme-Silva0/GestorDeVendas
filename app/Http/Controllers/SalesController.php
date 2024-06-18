<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $sales = [
            collect([
                'id' => 1,
                'client' => collect([
                    'id' => 1,
                    'name' => 'John Doe',
                    'cpf' => '123.456.789-00',
                ]),
                'seller' => collect([
                    'id' => 1,
                    'name' => 'John Doe',
                    'email' => 'email@example.com',
                ]),
                'products' => [
                    collect([
                        'id' => 1,
                        'name' => 'Notebook',
                        'price' => 1000.00,
                        'quantity' => 1,
                    ]),
                ],
                'total' => 1000.00,
                'installments' => [
                    collect([
                        'id' => 1,
                        'number' => 1,
                        'value' => 1000.00,
                        'due_date' => '2024-06-30',
                    ]),
                ],
            ]),
            collect([
                'id' => 2,
                'client' => collect([
                    'id' => 2,
                    'name' => 'Jane Doe',
                    'cpf' => '123.456.789-00',
                ]),
                'seller' => collect([
                    'id' => 1,
                    'name' => 'John Doe',
                    'email' => 'email@example.com',
                ]),
                'products' => [
                    collect([
                        'id' => 2,
                        'name' => 'Mouse',
                        'price' => 100.00,
                        'quantity' => 2,
                    ]),
                    collect([
                        'id' => 1,
                        'name' => 'Notebook',
                        'price' => 1000.00,
                        'quantity' => 1,
                    ]),
                ],
                'total' => 1200.00,
                'installments' => [
                    collect([
                        'id' => 1,
                        'number' => 1,
                        'value' => 600.00,
                        'due_date' => '2024-06-30',
                    ]),
                    collect([
                        'id' => 1,
                        'number' => 2,
                        'value' => 600.00,
                        'due_date' => '2024-06-30',
                    ]),
                ],
            ]),
        ];

        $clients = [
            collect([
                    'id' => 1,
                    'name' => 'Guilherme',
                    'cpf' => '107.548.763-30',
            ]),
            collect([
                'id' => 2,
                'name' => 'Joaquim',
                'cpf' => '107.548.763-20',
            ]),
        ];

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

        // dd($request->all());

        return view('app.dashboard', compact('sales', 'clients', 'products'));
    }
}
