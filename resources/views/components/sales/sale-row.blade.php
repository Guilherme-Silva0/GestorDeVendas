@props(['sale'])

<tr>
    <td class="py-2 px-4 border-b border-gray-200 text-center">{{ $sale->id }}</td>
    <td class="py-2 px-4 border-b border-gray-200 text-center">
        {{ $sale->client->name }}</td>
    <td class="py-2 px-4 border-b border-gray-200 text-center">
        {{ $sale->user->name }}</td>
    <td class="py-2 px-4 border-b border-gray-200 text-center">
        R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
    <td class="py-2 px-4 border-b border-gray-200 text-center">
        {{ count($sale->installments) }}x</td>
    <td class="py-2 px-4 border-b border-gray-200 text-center">
        @php
            $productsSale = collect($sale->products);
            $productNames = $productsSale
                ->map(function ($product) {
                    return $product->name . ' (' . $product->pivot->quantity . ')';
                })
                ->implode(', ');

            $maxLength = 40;
            if (strlen($productNames) > $maxLength) {
                $productNames = substr($productNames, 0, $maxLength) . '...';
            }
        @endphp
        {{ $productNames }}
    </td>
    <td class="py-2 px-4 border-b border-gray-200 text-center flex gap-1 justify-center items-center flex-wrap">
        <a href="{{ route('sales.show', $sale->id) }}"
            class="bg-blue-500 text-white py-[5px] px-[8px] rounded hover:bg-blue-700 shadow" title="Ver">
            <i class="fa-regular fa-eye h-4 w-4 -ml-px"></i>
        </a>
        <a href="{{ route('sales.pdf', $sale->id) }}"
            class="bg-yellow-500 text-white py-[5px] px-[8px] rounded hover:bg-yellow-700 shadow" title="Imprimir">
            <i class="fa-solid fa-file-pdf h-4 w-4 -ml-px"></i>
        </a>
        <button onclick="openEditSaleModal({sale: {{ json_encode($sale) }}}, '{{ route('sales.update', $sale->id) }}');"
            class="bg-green-500 text-white py-[5px] px-[10px] rounded hover:bg-green-700 shadow" title="Editar">
            <i class="fas fa-edit h-3 w-3 -ml-[2px]"></i>
        </button>
        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white py-[5px] px-[10px] rounded hover:bg-red-700 shadow"
                title="Excluir" onclick="return confirm('Tem certeza que deseja excluir esta venda?')">
                <i class="fa-solid fa-trash h-3 w-3 -ml-[2px]"></i>
            </button>
        </form>
    </td>
</tr>
