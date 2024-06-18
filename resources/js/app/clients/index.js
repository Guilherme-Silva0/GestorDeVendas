function validateCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, "");
    if (cpf == "") return false;
    if (
        cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999"
    )
        return false;

    let add = 0;
    for (let i = 0; i < 9; i++) add += parseInt(cpf.charAt(i)) * (10 - i);
    let rev = 11 - (add % 11);
    if (rev == 10 || rev == 11) rev = 0;
    if (rev != parseInt(cpf.charAt(9))) return false;
    add = 0;
    for (let i = 0; i < 10; i++) add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11) rev = 0;
    if (rev != parseInt(cpf.charAt(10))) return false;
    return true;
}

function validateName(name) {
    return name.trim().length > 0;
}

function maskCPF(cpf) {
    return cpf
        .replace(/\D/g, "")
        .replace(/(\d{3})(\d)/, "$1.$2")
        .replace(/(\d{3})(\d)/, "$1.$2")
        .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
}

document.addEventListener("DOMContentLoaded", function () {
    const cpfInput = document.getElementById("cpf");
    const nameInput = document.getElementById("name");
    const form = document.getElementById("clientForm");

    if (cpfInput) {
        cpfInput.addEventListener("input", function (event) {
            event.target.value = maskCPF(event.target.value);
        });
    }

    if (form) {
        form.addEventListener("submit", function (event) {
            let valid = true;

            const cpf = cpfInput.value;
            if (!validateCPF(cpf)) {
                valid = false;
                document.getElementById("cpfError").classList.remove("hidden");
            } else {
                document.getElementById("cpfError").classList.add("hidden");
            }

            const name = nameInput.value;
            if (!validateName(name)) {
                valid = false;
                document.getElementById("nameError").classList.remove("hidden");
            } else {
                document.getElementById("nameError").classList.add("hidden");
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    }
});
