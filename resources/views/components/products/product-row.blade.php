@props(['product'])

<tr>
    <td class="py-2 px-4 border-b text-center border-gray-200">{{ $product->id }}</td>
    <td class="py-2 px-4 border-b text-center border-gray-200">{{ $product->name }}</td>
    <td class="py-2 px-4 border-b text-center border-gray-200">
        R$ {{ number_format($product->price, 2, ',', '.') }}</td>
    <td class="py-2 px-4 border-b text-center border-gray-200 space-x-2">
        <a href="{{ route('products.show', $product->id) }}"
            class="bg-blue-500 text-white p-2 rounded hover:bg-blue-700 shadow" title="Ver">
            <i class="fa-regular fa-eye h-4 w-4 -mr-px"></i>
        </a>
        <button
            onclick="openEditProductModal({id: {{ $product->id }}, name: '{{ $product->name }}', price: '{{ $product->price }}'}, '{{ route('products.update', $product->id) }}')"
            class="bg-green-500 text-white py-[5px] px-[10px] rounded hover:bg-green-700 shadow" title="Editar">
            <i class="fas fa-edit h-3 w-3 -ml-[2px]"></i>
        </button>
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white py-[5px] px-[10px] rounded hover:bg-red-700 shadow"
                title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                <i class="fa-solid fa-trash h-3 w-3 -ml-[2px]"></i>
            </button>
        </form>
    </td>
</tr>
