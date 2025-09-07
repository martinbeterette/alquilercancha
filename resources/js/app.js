import "./bootstrap";

import Alpine from "alpinejs";

if (!window.Alpine) {
    window.Alpine = Alpine;
    Alpine.start();
}

import "@coasys/flux-ui"; // o el paquete correcto que instalaste
