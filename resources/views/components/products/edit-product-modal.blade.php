<div id="editProductModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center w-full sm:mt-0 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Editar Produto
                        </h3>
                        <div class="mt-2">
                            <form id="editProductForm" method="POST" action="#">
                                @csrf
                                @method('PUT')
                                <div class="mb-4 w-full">
                                    <label for="edit_name"
                                        class="block text-gray-700 text-sm font-bold mb-2">Nome:</label>
                                    <input type="text" id="edit_name" name="name"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <p id="editNameError" class="text-red-500 text-xs italic hidden">Por favor, insira
                                        um nome válido.</p>
                                </div>
                                <div class="mb-4">
                                    <label for="edit_price"
                                        class="block text-gray-700 text-sm font-bold mb-2">Preço:</label>
                                    <input type="number" step="0.01" min="0" id="edit_price" name="price"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <p id="editPriceError" class="text-red-500 text-xs italic hidden">Preço inválido.
                                        Por favor, insira um preço válido.</p>
                                </div>
                                <div class="flex items-center justify-end space-x-2">
                                    <button type="button" onclick="closeModal('editProductModal')"
                                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Cancelar</button>
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar
                                        Alterações</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
