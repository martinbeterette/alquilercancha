<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido 🚀</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-5xl font-bold mb-4">¡Bienvenido a tu proyecto! 🎉</h1>
        <p class="text-lg text-gray-300">Este es el punto de partida. Edita esta vista en <code class="bg-gray-800 px-2 py-1 rounded">resources/views/welcome.blade.php</code></p>
        <div class="mt-6">
            <a href="{{ url('/login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Ir al Login</a>
        </div>
    </div>
</body>
</html>
