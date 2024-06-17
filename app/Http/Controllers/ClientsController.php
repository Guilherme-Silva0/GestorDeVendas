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
                    'cpf' => '12345678901',
            ]),
            collect([
                'id' => 2,
                'name' => 'Joaquim',
                'cpf' => '12345678902',
            ]),
        ];

        return view('app.clients', compact('clients'));
    }
}
