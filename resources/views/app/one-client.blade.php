@extends('app.layout.app')

@section('content')
    <div class="flex flex-col items-center justify-center  min-h-[calc(100vh-113px)] bg-gray-100">
        <div class="container mx-auto p-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Detalhes do Cliente</h2>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="clientId">ID do Cliente</label>
                    <p id="clientId" class="border border-gray-300 rounded p-2">{{ $client->id }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="clientName">Nome do Cliente</label>
                    <p id="clientName" class="border border-gray-300 rounded p-2">{{ $client->name }}</p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2" for="clientPrice">CPF do Cliente</label>
                    <p id="clientPrice" class="border border-gray-300 rounded p-2">
                        {{ $client->cpf }}</p>
                </div>
                <div class="flex space-x-4 justify-end">
                    <a href="{{ route('clients.index') }}" id="backButton"
                        class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700" title="Voltar"><i
                            class="fa-solid fa-arrow-left"></i> Voltar</a>
                    <form action="{{ route('clients.destroy', $client->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button id="deleteButton" type="submit"
                            onclick="return confirm('Tem certeza que deseja excluir este produto?')" title="Apagar"
                            class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-700"><i
                                class="fa-solid fa-trash"></i> Apagar</button>
                    </form>
                    <button
                        onclick="openEditModal({id: {{ $client->id }}, name: '{{ $client->name }}', cpf: '{{ $client->cpf }}'}, '{{ route('clients.update', $client->id) }}')"
                        id="editButton" title="Editar"
                        class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-700"><i class="fas fa-edit"></i>
                        Editar</button>
                </div>
            </div>
        </div>
    </div>

    <x-clients.edit-client-modal />
@endsection
