import "./clients/index";
import "./clients/edit";

function openModal(modalId) {
    document.getElementById(modalId).classList.remove("hidden");
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add("hidden");
}

window.openModal = openModal;
window.closeModal = closeModal;
