<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
</head>
<body>
    @if (session('message'))
        <div id="app">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>
</html>
