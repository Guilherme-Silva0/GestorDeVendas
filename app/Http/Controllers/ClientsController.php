<?php

namespace App\Http\Controllers;

class ClientsController extends Controller
{
    public function index()
    {
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

        return view('app.clients', compact('clients'));
    }
}
