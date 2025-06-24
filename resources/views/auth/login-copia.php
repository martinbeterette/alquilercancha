<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet">
    <style>
        .divider:after,
        .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #7a7a7a;
        }
    </style>
</head>
<body>
    @if (session('message'))
        <div id="app">
            <div 
                v-if="showError" 
                class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }} d-flex justify-content-between align-items-center" 
                role="alert"
            >
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
    <div>
        <section class="vh-100">
            <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img src="{{asset('images/shoot.png')}}"
                class="img-fluid" alt="Jugador de fútbol">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form action="/login" method="POST">
                    @csrf

                    <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input 
                            type="email" 
                            name="email" 
                            id="form1Example13" 
                            class="form-control form-control-lg" 
                            @if(isset($email) && $email) 
                                value="{{ $email }}"
                            @endif
                        />
                        <label class="form-label" for="form1Example13">Email address</label>
                    </div>

                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input 
                            type="password" 
                            name="password" 
                            id="form1Example23" 
                            class="form-control form-control-lg" 
                        />
                        <label class="form-label" for="form1Example23">Password</label>
                    </div>

                    <div class="d-flex justify-content-around align-items-center mb-4">
                        <!-- Checkbox -->
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                        <label class="form-check-label" for="form1Example3"> Remember me </label>
                        </div>
                        <a href="#!">Forgot password?</a>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block">Sign in</button>
                    
                    <!-- Register button -->
                    <a href="{{url('formulario-registro')}}" class="btn btn-secondary btn-lg btn-block mt-3">Register</a>

                    <div class="divider d-flex align-items-center my-4">
                        <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
                    </div>

                    <a data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" style="background-color: #3b5998" href="#!"
                        role="button">
                        <i class="fab fa-facebook-f me-2"></i>Continue with Facebook
                    </a>
                    <a data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" style="background-color: #55acee" href="#!"
                        role="button">
                        <i class="fab fa-twitter me-2"></i>Continue with Twitter</a>

                </form>
            </div>
            </div>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.min.js"></script>
    <script>
        Vue.createApp({
            data() {
                return {
                    showError: true
                };
            }
        }).mount("#app");
    </script>
</body>
</html>