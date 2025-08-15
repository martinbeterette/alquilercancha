<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Wizard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
    <style>
        .step-container {
            display: none;
        }
        .step-container.active {
            display: block;
        }
    </style>
</head>
<body>
    @if (session('message'))
        <div id="app2">
            <div v-if="showError" class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
                <div>
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0">

                        @if (session('message'))
                            <li>{{ session('message') }}</li>
                            @if (session('errors'))
                                <ul class="mb-0">
                                    @foreach (session('errors') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif

                        
                    </ul>
                </div>
                <button @click="showError = false" class="btn-close btn-sm" aria-label="Close"></button>
            </div>
        </div>
    @endif
    <div id="app">
        <div class="container mt-5">
            <form method="POST" action="{{ route('procesarRegistro') }}" >
                @csrf
                @method('POST')
                <!-- Paso 1: Datos personales -->
                <div class="step-container" v-bind:class="{ 'active': currentStep === 1 }">
                    <h4 class="mb-4">Paso 1: Datos personales</h4>
                    <div class="form-group">
                        <label for="firstName">Nombre</label>
                        <input type="text" id="firstName"  class="form-control" name="nombre">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Apellido</label>
                        <input type="text" id="lastName"  class="form-control" name="apellido">
                    </div>
                    <div class="form-group">
                        <label for="document">Documento</label>
                        <input type="text" id="document"  class="form-control" name="documento">
                    </div>
                    
                    <div class="form-group">
                        <label for="tipo_documento">Tipo de documento</label>
                        <select id="documentType"  class="form-control" name="tipo_documento">
                            <option value="1">DNI</option>
                            <option value="2">Pasaporte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" id="fecha_nacimiento"  class="form-control" name="fecha_nacimiento">
                    </div>
                    <div class="form-group">
                        <label for="gender">Sexo</label>
                        <select id="gender"  class="form-control" name="sexo">
                            <option value="1">Masculino</option>
                            <option value="2">Femenino</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary mt-3" @click="nextStep">Siguiente</button>
                </div>

                <!-- Paso 2: Datos del usuario -->
                <div class="step-container" v-bind:class="{ 'active': currentStep === 2 }">
                    <h4 class="mb-4">Paso 2: Datos del usuario</h4>
                    <div class="form-group">
                        <label for="username">Nombre de usuario</label>
                        <input type="text" id="username"  class="form-control" name="username">
                    </div>
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email"  class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password"  class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirmar Contraseña</label>
                        <input type="password" id="confirmPassword"  class="form-control" name="confirm_password">
                    </div>
                    <button type="button" class="btn btn-secondary mt-3" @click="prevStep">Anterior</button>
                    <button type="submit" class="btn btn-primary mt-3">Finalizar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    currentStep: 1
                };
            },
            methods: {
                nextStep() {
                    if (this.currentStep < 2) {
                        this.currentStep++;
                    }
                },
                prevStep() {
                    if (this.currentStep > 1) {
                        this.currentStep--;
                    }
                }
            }
        });
    </script>
    <script>
        Vue.createApp({
            data() {
                return {
                    showError: true
                };
            }
        }).mount("#app2");
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>
</html>
