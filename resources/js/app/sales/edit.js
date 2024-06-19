document.addEventListener("DOMContentLoaded", function () {
    const productSelect = document.getElementById("edit_productSelect");
    const productList = document.getElementById("edit_productList");
    const totalInput = document.getElementById("edit_total");
    const addInstallmentBtn = document.getElementById("edit_addInstallmentBtn");
    const installmentList = document.getElementById("edit_installmentList");
    const editSaleForm = document.getElementById("editSaleForm");
    const productsInput = document.getElementById("edit_products");
    const installmentsInput = document.getElementById("edit_installments");
    const clientSelect = document.getElementById("edit_client");

    let products = [];
    let total = 0;
    let installments = [];

    productSelect.addEventListener("change", function () {
        const selectedProduct = JSON.parse(productSelect.value);
        if (selectedProduct) {
            selectedProduct.quantity = 1;
            products.push(selectedProduct);
            updateProductList();
            updateTotal();
            createInitialInstallment();
            productSelect.value = "";
        }
    });

    addInstallmentBtn.addEventListener("click", function () {
        addInstallment();
    });

    function openEditSaleModal({ sale }, route) {
        sale.products.forEach((product) => {
            products.push({
                id: product.id,
                name: product.name,
                price: Number(product.pivot.price),
                quantity: product.pivot.quantity,
            });
        });
        total = sale.total;
        installments = sale.installments.map((installment) => ({
            ...installment,
            isFixed: false,
        }));
        clientSelect.value = sale.client.id;
        updateProductList();
        updateTotal(true);
        updateInstallmentList();
        document.getElementById("editSaleForm").action = route;

        document.getElementById("editSaleModal").classList.remove("hidden");
    }

    function closeEditSaleModal() {
        products = [];
        total = 0;
        installments = [];
        clientSelect.value = "";
        productSelect.value = "";
        updateProductList();
        updateTotal();
        updateInstallmentList();

        document.getElementById("editSaleModal").classList.add("hidden");
    }

    function updateProductList() {
        productList.innerHTML = "";
        products.forEach((product, index) => {
            const li = document.createElement("li");
            li.className = "flex items-center";
            li.innerHTML = `
                <div>${product.name} - R$
                <input type="number" value="${product.price.toFixed(
                    2
                )}" class="price-input ml-2 mr-2 w-24 text-right border rounded px-1" data-index="${index}"></div>
                <div>Qtd: <input type="number" value="${
                    product.quantity
                }" class="quantity-input ml-2 mr-2 w-16 text-right border rounded px-1" data-index="${index}" min="1"></div>
                <button type="button" class="remove-btn ml-2 text-red-500">Remover</button>
            `;
            productList.appendChild(li);

            const priceInput = li.querySelector(".price-input");
            const quantityInput = li.querySelector(".quantity-input");
            const removeBtn = li.querySelector(".remove-btn");

            priceInput.addEventListener("change", function () {
                const newPrice = parseFloat(priceInput.value);
                if (!isNaN(newPrice) && newPrice >= 0) {
                    products[index].price = newPrice;
                    updateTotal();
                } else {
                    priceInput.value = products[index].price.toFixed(2);
                }
            });

            quantityInput.addEventListener("change", function () {
                const newQuantity = parseInt(quantityInput.value);
                if (!isNaN(newQuantity) && newQuantity > 0) {
                    products[index].quantity = newQuantity;
                    updateTotal();
                } else {
                    quantityInput.value = products[index].quantity;
                }
            });

            removeBtn.addEventListener("click", function () {
                products.splice(index, 1);
                updateProductList();
                updateTotal();
            });
        });
    }

    function updateTotal(isFistTime = false) {
        total = products.reduce(
            (sum, product) => sum + product.price * product.quantity,
            0
        );
        totalInput.value = `R$ ${total.toFixed(2).replace(".", ",")}`;

        if (!isFistTime) {
            recalculateInstallments();
            updateInstallmentList();
        }
    }

    function createInitialInstallment() {
        const desiredInstallments = installments.length + 1;
        const installmentAmount = total / desiredInstallments;

        if (installments.length === 0) {
            installments.push({
                value: installmentAmount,
                due_date: new Date(
                    new Date().setDate(new Date().getDate() + 30)
                ),
                number: 1,
                isFixed: false,
            });
        } else {
            const newAmount = total / installments.length;
            installments[0].value = newAmount;
        }

        updateInstallmentList();
    }

    function addInstallment() {
        const desiredInstallments = installments.length + 1;
        const installmentAmount = total / desiredInstallments;

        const newInstallment = {
            value: installmentAmount,
            due_date: new Date(
                new Date().setDate(
                    new Date().getDate() + 30 * (installments.length + 1)
                )
            ),
            number: installments.length + 1,
            isFixed: false,
        };
        installments.push(newInstallment);

        recalculateInstallments();
        updateInstallmentList();
    }

    function recalculateInstallments() {
        const fixedTotal = installments.reduce((sum, installment) => {
            return installment.isFixed ? sum + installment.value : sum;
        }, 0);
        const remainingTotal = total - fixedTotal;
        const flexibleInstallments = installments.filter(
            (i) => !i.isFixed
        ).length;
        if (flexibleInstallments > 0) {
            const amountPerFlexibleInstallment =
                remainingTotal / flexibleInstallments;
            installments.forEach((installment) => {
                if (!installment.isFixed) {
                    installment.value = amountPerFlexibleInstallment;
                }
            });
        }
    }

    function updateInstallmentList() {
        installmentList.innerHTML = "";
        installments.forEach((installment, index) => {
            const div = document.createElement("div");
            div.className = "flex items-center mb-2";
            let date;
            if (typeof installment.due_date === "string") {
                date = installment.due_date;
            } else {
                date = installment.due_date.toISOString().substring(0, 10);
            }
            div.innerHTML = `
                <input type="number" value="${Number(installment.value).toFixed(
                    2
                )}" class="installment-amount-input ml-2 mr-2 w-24 text-right border rounded px-1" data-index="${index}">
                <input type="date" value="${date}" class="installment-date-input ml-2 mr-2 border rounded px-1" data-index="${index}">
                <button type="button" class="remove-installment-btn ml-2 text-red-500">Remover</button>
            `;
            installmentList.appendChild(div);

            const amountInput = div.querySelector(".installment-amount-input");
            const dateInput = div.querySelector(".installment-date-input");
            const removeBtn = div.querySelector(".remove-installment-btn");

            amountInput.addEventListener("change", function () {
                const newAmount = parseFloat(amountInput.value);
                if (!isNaN(newAmount) && newAmount >= 0) {
                    adjustInstallments(index, newAmount);
                } else {
                    amountInput.value = Number(
                        installments[index].value
                    ).toFixed(2);
                }
            });

            dateInput.addEventListener("change", function () {
                const newDate = new Date(dateInput.value);
                if (!isNaN(newDate.getTime())) {
                    if (
                        index > 0 &&
                        newDate <= installments[index - 1].due_date
                    ) {
                        alert(
                            "A data da parcela deve ser posterior à data da parcela anterior."
                        );
                        dateInput.value = installments[index].due_date
                            .toISOString()
                            .substring(0, 10);
                    } else if (
                        index === 0 &&
                        newDate >= installments[index + 1].due_date
                    ) {
                        alert(
                            "A data da primeira parcela deve ser anterior à data da segunda parcela."
                        );
                        dateInput.value = installments[index].due_date
                            .toISOString()
                            .substring(0, 10);
                    } else if (
                        index > 0 &&
                        index < installments.length - 1 &&
                        newDate >= installments[index + 1].due_date
                    ) {
                        alert(
                            "A data da parcela deve ser anterior à data da parcela seguinte."
                        );
                        dateInput.value = installments[index].due_date
                            .toISOString()
                            .substring(0, 10);
                    } else {
                        installments[index].due_date = newDate;
                    }
                } else {
                    dateInput.value = installments[index].due_date
                        .toISOString()
                        .substring(0, 10);
                }
            });

            removeBtn.addEventListener("click", function () {
                installments.splice(index, 1);
                recalculateInstallments();
                updateInstallmentList();
            });
        });
    }

    function adjustInstallments(changedIndex, newAmount) {
        if (newAmount > total) {
            alert("O valor da parcela não pode ultrapassar o valor total.");
            updateInstallmentList();
            return;
        }
        installments[changedIndex].value = newAmount;
        installments[changedIndex].isFixed = true;

        recalculateInstallments();
        updateInstallmentList();
    }

    function validateClientSelect() {
        if (clientSelect.value === "") {
            alert("Selecione um cliente!");
            return false;
        }

        return true;
    }

    function validateProducts() {
        if (products.length === 0) {
            alert("Selecione pelo menos um produto!");
            return false;
        }

        return true;
    }

    function validateInstallments() {
        if (installments.length === 0) {
            alert("Selecione pelo menos uma parcela!");
            return false;
        }

        return true;
    }

    editSaleForm.addEventListener("submit", function (event) {
        if (!validateClientSelect()) {
            event.preventDefault();
            return;
        }

        if (!validateProducts()) {
            event.preventDefault();
            return;
        }

        if (!validateInstallments()) {
            event.preventDefault();
            return;
        }

        productsInput.value = JSON.stringify(products);
        installmentsInput.value = JSON.stringify(installments);
        editSaleForm.submit();
    });

    window.openEditSaleModal = openEditSaleModal;
    window.closeEditSaleModal = closeEditSaleModal;
});
