<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Client;
use App\Models\Installments;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $sales = Sale::with(['client', 'user', 'installments', 'products'])->paginate(10);
        $clients = Client::all();
        $products = Product::all();

        return view('app.dashboard', compact('sales', 'clients', 'products'));
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
