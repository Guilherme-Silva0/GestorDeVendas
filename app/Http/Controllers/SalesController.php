<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Client;
use App\Models\Installments;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::query();

        // Aplicar filtros
        if ($request->filled('client_filter')) {
            $query->where('client_id', $request->input('client_filter'));
        }

        if ($request->filled('user_filter')) {
            $query->where('user_id', $request->input('user_filter'));
        }

        if ($request->filled('total_min_filter')) {
            $query->where('total', '>=', $request->input('total_min_filter'));
        }

        if ($request->filled('total_max_filter')) {
            $query->where('total', '<=', $request->input('total_max_filter'));
        }

        $sales = $query->paginate(10);

        $clients = Client::all();
        $users = User::all();
        $products = Product::all();

        return view('app.dashboard', compact('sales', 'clients', 'users', 'products'));
    }

    public function show($saleId)
    {
        $sale = Sale::with(['client', 'user', 'installments', 'products'])->find($saleId);
        $clients = Client::all();
        $products = Product::all();

        return view('app.one-sale', compact('sale', 'clients', 'products'));
    }

    public function store(StoreSaleRequest $request)
    {
        $products = json_decode($request->input('products'), true);
        $installments = json_decode($request->input('installments'), true);

        return $this->createSale($request->input('client_id'), $products, $request->input('total'), $installments);
    }

    public function update(UpdateSaleRequest $request, $id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return redirect()->route('sales.index')->with('error', 'Venda não encontrada.');
        }

        $products = json_decode($request->input('products'), true);
        $installments = json_decode($request->input('installments'), true);

        return $this->updateSale($sale, $request->input('client_id'), $products, $request->input('total'), $installments);
    }

    public function destroy($saleId)
    {
        $sale = Sale::find($saleId);

        if (!$sale) {
            return redirect()->route('sales.index')->with('error', 'Venda não encontrada.');
        }

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venda excluída com sucesso.');
    }

    public function generatePdf($id)
    {
        $sale = Sale::with(['client', 'user', 'products', 'installments'])->findOrFail($id);

        $pdf = Pdf::loadView('app.pdf-sale', compact('sale'));

        return $pdf->download('sale_'.$sale->id.'.pdf');
    }

    public function updateSale(Sale $sale, $clientId, $products, $total, $installments)
    {
        $user = Auth::user();
        $total = str_replace(['R$', ','], ['', '.'], $total);

        $sale->client_id = $clientId;
        $sale->user_id = $user->id;
        $sale->total = $total;
        $sale->save();

        SaleProduct::where('sale_id', $sale->id)->delete();
        foreach ($products as $product) {
            SaleProduct::create([
                'sale_id' => $sale->id,
                'product_id' => $product['id'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
            ]);
        }

        Installments::where('sale_id', $sale->id)->delete();
        foreach ($installments as $installment) {
            Installments::create([
                'sale_id' => $sale->id,
                'number' => $installment['number'],
                'value' => $installment['value'],
                'due_date' => \Carbon\Carbon::parse($installment['due_date'])->format('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->route('sales.index')->with('success', 'Venda atualizada com sucesso.');
    }

    public function createSale($clientId, $products, $total, $installments)
    {
        $user = Auth::user();

        $total = str_replace(['R$', ','], ['', '.'], $total);

        $sale = new Sale();
        $sale->client_id = $clientId;
        $sale->user_id = $user->id;
        $sale->total = $total;
        $sale->save();

        foreach ($products as $product) {
            SaleProduct::create([
                'sale_id' => $sale->id,
                'product_id' => $product['id'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
            ]);
        }

        foreach ($installments as $installment) {
            Installments::create([
                'sale_id' => $sale->id,
                'number' => $installment['number'],
                'value' => $installment['value'],
                'due_date' => \Carbon\Carbon::parse($installment['due_date'])->format('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->route('sales.index')->with('success', 'Venda criada com sucesso.');
    }
}
