<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CAMPUSPAY</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
    {{--
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @endif
</head>

<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col particles-js">
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
            <a href="{{ url('/dashboard') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-white dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                Dashboard
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border  dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-white text-red-500">
                    Déconnexion
                </button>
            </form>
            @else
            <a href="{{ route('login') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-white border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                Log in
            </a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-white">
                Register
            </a>
            @endif
            @endauth
        </nav>
        @endif
    </header>


    <!-- Particles Background -->
    <div id="particles-js" class="fixed top-0 left-0 w-full h-full -z-10"></div>

    <main class="flex-grow p-4 flex flex-wrap  items-center justify-center gap-12 text-center">
        <div class="max-w-xl w-full space-y-6 justify-center  items-center">
            <h1 id="hero-title"
                class="text-2xl sm:text-3xl md:text-5xl font-extrabold leading-tight text-white dark:text-gray-900">
                <span id="typewriter"></span>
            </h1>

            <p class="text-lg text-white dark:text-gray-400">
                Conçue pour les établissements d’enseignement, cette plateforme vous aide à centraliser la gestion des
                étudiants, suivre les paiements, et éditer des rapports rapidement.
            </p>
            <div
             {{-- class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 justify-center" --}}
             >
                {{-- <a href="/register"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Créer un compte
                </a> --}}
                {{-- @if(Route::has('login')) --}}
                {{-- @guest --}}
                <a href="{{ route('presentation') }}"
                    class="px-6 py-3 border-2 border-white hover:bg-blue-50 dark:hover:bg-gray-700 text-blue-600 dark:text-blue-400 font-semibold rounded-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 bg-white max-w-[200px]">
                    Voir plus
                </a>
                {{-- @endguest --}}

                {{-- @endif --}}
            </div>
        </div>

        <img src="{{asset('logos/illustration.jpg')}} " alt="Université" class="w-full max-w-md rounded-lg shadow-lg" />
    </main>

    <footer class="text-white  py-6">
        <div class="max-w-5xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
            <p id="copyright" class="text-sm mb-4 md:mb-0 font-cursive">&copy; <span id="year">{{date('Y')}}</span> with ❤️ by
                Boris Aubin SIMO. Tous droits
                réservés.</p>

        </div>


    </footer>


    @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
    @endif
    <!-- TypewriterJS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/typewriter-effect@2.18.0/dist/core.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="{{asset('js/typewritter.js')}}"></script>

    <script src="{{ asset('js/particles-config.js') }}"></script>
</body>

</html>