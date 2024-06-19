<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::paginate(10);

        return view('app.clients', compact('clients'));
    }
}
