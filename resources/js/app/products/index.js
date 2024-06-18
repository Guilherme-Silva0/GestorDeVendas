document.addEventListener("DOMContentLoaded", function () {
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

    const form = document.getElementById("productForm");
    if (form) {
        form.addEventListener("submit", function (event) {
            let valid = true;

            const name = document.getElementById("name").value;
            if (!validateProductName(name)) {
                valid = false;
                document.getElementById("nameError").classList.remove("hidden");
            } else {
                document.getElementById("nameError").classList.add("hidden");
            }

            const price = document.getElementById("price").value;
            if (!validateProductPrice(price)) {
                valid = false;
                document
                    .getElementById("priceError")
                    .classList.remove("hidden");
            } else {
                document.getElementById("priceError").classList.add("hidden");
            }

            if (!valid) {
                event.preventDefault();
            }
        });

        const priceInput = document.getElementById("price");
        if (priceInput) {
            priceInput.addEventListener("input", function (event) {
                event.target.value = maskPrice(event.target.value);
            });
        }
    }
});
