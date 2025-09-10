import "./bootstrap";

import Alpine from "alpinejs";

if (!window.Alpine) {
    window.Alpine = Alpine;
    Alpine.start();
}

import "@coasys/flux-ui";

import toastr from "toastr";
import "toastr/build/toastr.min.css";
window.toastr = toastr;

// Configuración global opcional
toastr.options = {
    closeButton: false,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
};

// Livewire + Toastr
document.addEventListener("livewire:init", () => {
    Livewire.on("toastr", (event) => {
        // Flux/Livewire 3 envía los datos en detail
        const { type, message } = event.detail || event;

        const validTypes = ["success", "error", "info", "warning"];
        if (validTypes.includes(type)) {
            toastr[type](message);
        } else {
            console.warn(`Toastr tipo inválido: ${type}`);
        }
    });
});
