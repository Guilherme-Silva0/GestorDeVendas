@props(['products', 'clients'])

<div id="editSaleModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center w-full sm:mt-0 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Editar Venda</h3>
                        <div class="mt-2">
                            <form id="editSaleForm" method="GET" action="#">
                                @csrf
                                <div class="mt-2">
                                    <label for="edit_client"
                                        class="block text-sm font-medium text-gray-700">Cliente</label>
                                    <select id="edit_client" name="edit_client_id"
                                        class="form-select mt-1 block w-full">
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <label for="edit_productSelect"
                                        class="block text-sm font-medium text-gray-700">Produtos</label>
                                    <select id="edit_productSelect" class="form-select mt-1 block w-full">
                                        <option value="">Selecione um produto</option>
                                        @foreach ($products as $product)
                                            <option
                                                value="{{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => $product->price]) }}">
                                                {{ $product->name }} (R$
                                                {{ number_format($product->price, 2, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="hidden" name="edit_products" id="edit_products">

                                <div class="mt-4">
                                    <ul id="edit_productList" class="list-disc pl-5"></ul>
                                </div>

                                <div class="mt-4">
                                    <label for="edit_total"
                                        class="block text-sm font-medium text-gray-700">Total</label>
                                    <input type="text" id="edit_total" name="edit_total"
                                        class="form-input mt-1 block w-full" readonly>
                                </div>

                                <div id="edit_installmentsContainer" class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700">Parcelas</label>
                                    <button type="button" id="edit_addInstallmentBtn"
                                        class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue disabled:opacity-25 transition ease-in-out duration-150">
                                        Adicionar Parcela
                                    </button>
                                    <div id="edit_installmentList" class="mt-4"></div>
                                </div>

                                <input type="hidden" name="edit_installments" id="edit_installments">

                                <div class="mt-4 flex justify-end gap-1">
                                    <button onclick="closeModal('editSaleModal')" type="button"
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
