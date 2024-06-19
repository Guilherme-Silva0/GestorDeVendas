<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::paginate(10);

        return view('app.clients', compact('clients'));
    }

    public function show(string $clientId)
    {
        if (!$client = Client::find($clientId)) {
            return redirect()->route('clients.index')->with('error', 'Cliente não encontrado.');
        }

        return view('app.one-client', compact('client'));
    }

    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->all());

        if (!$client) {
            return redirect()->route('clients.index')->with('error', 'Erro ao criar o cliente.');
        }

        return redirect()->route('clients.index')->with('success', 'Cliente criado com sucesso.');
    }

    public function update(UpdateClientRequest $request, string $clientId)
    {
        if (!$client = Client::find($clientId)) {
            return redirect()->route('clients.index')->with('error', 'Cliente não encontrado.');
        }

        $client = $client->update($request->all());

        if (!$client) {
            return redirect()->route('clients.index')->with('error', 'Erro ao atualizar o cliente.');
        }

        return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy(string $clientId)
    {
        if (!$client = Client::find($clientId)) {
            return redirect()->route('clients.index')->with('error', 'Cliente não encontrado.');
        }

        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente excluído com sucesso.');
    }
}
