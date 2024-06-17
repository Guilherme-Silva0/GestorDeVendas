<!-- resources/views/welcome.blade.php -->
@extends('app.layout.app')

@section('header')
    <div class="bg-blue-600 text-white p-4 shadow rounded-b-2xl">
        <h1 class="text-2xl font-bold">Bem-vindo ao Sistema de Vendas</h1>
    </div>
@endsection

@section('content')
    <div class="flex flex-col items-center justify-center min-h-[calc(100vh-113px)] bg-gray-100">
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-4">Gerencie suas Vendas de Forma Simples</h2>
            <p class="text-lg mb-8">Faça o login ou registre-se para começar.</p>
            <div class="space-x-1">
                <a href="/register"
                    class="bg-blue-500 text-white px-4 py-2 rounded-2xl transition-shadow hover:shadow-md">Registrar</a>
                <a href="/login"
                    class="text-gray-800 px-4 py-2 rounded-2xl border transition-shadow hover:shadow-md">Login</a>
            </div>
        </div>
    </div>
@endsection
