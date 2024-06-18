@props(['products', 'clients'])

<div id="addSaleModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center w-full sm:mt-0 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Adicionar Venda</h3>
                        <div class="mt-2">
                            <form id="addSaleForm" method="GET" action="#">
                                @csrf

                                <div class="mt-2">
                                    <label for="client"
                                        class="block text-sm font-medium text-gray-700">Cliente</label>
                                    <select id="client" name="client_id" class="form-select mt-1 block w-full">
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->get('id') }}">{{ $client->get('name') }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <label for="productSelect"
                                        class="block text-sm font-medium text-gray-700">Produtos</label>
                                    <select id="productSelect" class="form-select mt-1 block w-full">
                                        <option value="">Selecione um produto</option>
                                        @foreach ($products as $product)
                                            <option
                                                value="{{ json_encode(['id' => $product->get('id'), 'name' => $product->get('name'), 'price' => $product->get('price')]) }}">
                                                {{ $product->get('name') }} (R$
                                                {{ number_format($product->get('price'), 2, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="hidden" name="products" id="products">

                                <div class="mt-4">
                                    <ul id="productList" class="list-disc pl-5"></ul>
                                </div>

                                <div class="mt-4">
                                    <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                                    <input type="text" id="total" name="total"
                                        class="form-input mt-1 block w-full" readonly>
                                </div>

                                <div id="installmentsContainer" class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700">Parcelas</label>
                                    <button type="button" id="addInstallmentBtn"
                                        class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue disabled:opacity-25 transition ease-in-out duration-150">
                                        Adicionar Parcela
                                    </button>
                                    <div id="installmentList" class="mt-4"></div>
                                </div>

                                <input type="hidden" name="installments" id="installments">

                                <div class="mt-4 flex justify-end gap-1">
                                    <button onclick="closeModal('addSaleModal')" type="button"
                                        class="inline-flex items-center px-4 py-2 border rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-200 active:bg-gray-300 focus:outline-none focus:border-green-700 focus:shadow-outline-green disabled:opacity-25 transition ease-in-out duration-150">
                                        Cancelar
                                    </button>
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green disabled:opacity-25 transition ease-in-out duration-150">
                                        Salvar Venda
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
