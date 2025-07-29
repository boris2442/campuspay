<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page non trouvée - 404</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    {{--
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @endif
</head>

<body class="bg-blue-50 flex items-center justify-center min-h-screen px-6">

    <div class="text-center max-w-xl">
        <h1 class="text-9xl font-extrabold text-blue-600">404</h1>
        <p class="text-2xl md:text-3xl font-semibold text-gray-800 mt-4">Oups ! Cette page est introuvable.</p>
        <p class="text-gray-600 mt-2 mb-6">
            La page que vous cherchez n'existe pas ou a été déplacée.
        </p>

        <a href="{{ route('home.welcome') }}"
            class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
            Retour à l'accueil
        </a>
    </div>

</body>

</html>