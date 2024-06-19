document.addEventListener("DOMContentLoaded", function () {
    const productSelect = document.getElementById("productSelect");
    const productList = document.getElementById("productList");
    const totalInput = document.getElementById("total");
    const addInstallmentBtn = document.getElementById("addInstallmentBtn");
    const installmentList = document.getElementById("installmentList");
    const addSaleForm = document.getElementById("addSaleForm");
    const productsInput = document.getElementById("products");
    const installmentsInput = document.getElementById("installments");
    const clientSelect = document.getElementById("client");

    let products = [];
    let total = 0;
    let installments = [];

    productSelect.addEventListener("change", function () {
        const selectedProduct = JSON.parse(productSelect.value);
        if (selectedProduct) {
            selectedProduct.quantity = 1; // Adicionando a quantidade padrão como 1
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

    function updateProductList() {
        productList.innerHTML = "";
        products.forEach((product, index) => {
            const li = document.createElement("li");
            li.className = "flex items-center gap-1 flex-wrap";
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

    function updateTotal() {
        total = products.reduce(
            (sum, product) => sum + product.price * product.quantity,
            0
        );
        totalInput.value = `R$ ${total.toFixed(2).replace(".", ",")}`;
        recalculateInstallments();
        updateInstallmentList();
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
        };
        installments.push(newInstallment);

        recalculateInstallments();
        updateInstallmentList();
    }

    function recalculateInstallments() {
        if (installments.length > 0) {
            const amountPerInstallment = total / installments.length;
            installments.forEach(
                (installment, index) =>
                    (installment.value = amountPerInstallment)
            );
        }
    }

    function updateInstallmentList() {
        installmentList.innerHTML = "";
        installments.forEach((installment, index) => {
            const div = document.createElement("div");
            div.className = "flex items-center mb-2";
            div.innerHTML = `
                <input type="number" value="${installment.value.toFixed(
                    2
                )}" class="installment-amount-input ml-2 mr-2 w-24 text-right border rounded px-1" data-index="${index}">
                <input type="date" value="${installment.due_date
                    .toISOString()
                    .substring(
                        0,
                        10
                    )}" class="installment-date-input ml-2 mr-2 border rounded px-1" data-index="${index}">
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
                    amountInput.value = installments[index].value.toFixed(2);
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
        const remainingAmount = total - newAmount;
        const remainingInstallments = installments.length - 1;
        const amountPerRemainingInstallment =
            remainingAmount / remainingInstallments;

        installments[changedIndex].value = newAmount;

        installments.forEach((installment, index) => {
            if (index !== changedIndex) {
                installment.value = amountPerRemainingInstallment;
            }
        });

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

    addSaleForm.addEventListener("submit", function (event) {
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
        addSaleForm.submit();
    });
});
