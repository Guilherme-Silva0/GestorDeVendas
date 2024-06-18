document.addEventListener("DOMContentLoaded", function () {
    function openEditProductModal(product) {
        document.getElementById("editProductModal").classList.remove("hidden");
        document.getElementById("edit_name").value = product.name;
        document.getElementById("edit_price").value = maskPrice(product.price);
    }

    function validateProductName(name) {
        return name.trim().length > 0;
    }

    function validateProductPrice(price) {
        return !isNaN(price) && parseFloat(price) > 0;
    }

    function maskPrice(price) {
        price = price.replace(/[^\d.,]/g, "");
        return price;
    }

    const form = document.getElementById("editProductForm");
    if (form) {
        form.addEventListener("submit", function (event) {
            let valid = true;

            const name = document.getElementById("edit_name").value;
            if (!validateProductName(name)) {
                valid = false;
                document
                    .getElementById("editNameError")
                    .classList.remove("hidden");
            } else {
                document
                    .getElementById("editNameError")
                    .classList.add("hidden");
            }

            const price = document.getElementById("edit_price").value;
            if (!validateProductPrice(price)) {
                valid = false;
                document
                    .getElementById("editPriceError")
                    .classList.remove("hidden");
            } else {
                document
                    .getElementById("editPriceError")
                    .classList.add("hidden");
            }

            if (!valid) {
                event.preventDefault();
            }
        });

        const priceInput = document.getElementById("edit_price");
        if (priceInput) {
            priceInput.addEventListener("input", function (event) {
                event.target.value = maskPrice(event.target.value);
            });
        }
    }

    window.openEditProductModal = openEditProductModal;
});
