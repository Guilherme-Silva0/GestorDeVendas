<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Models\Client;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::paginate(10);

        return view('app.clients', compact('clients'));
    }

    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->all());

        if (!$client) {
            return redirect()->route('clients.index')->with('error', 'Erro ao criar o cliente.');
        }

        return redirect()->route('clients.index')->with('success', 'Cliente criado com sucesso.');
    }
}
