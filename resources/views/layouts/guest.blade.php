<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SchoolNote — Connexion</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="min-h-screen flex">

            <!-- Côté gauche : visuel -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 to-indigo-800 flex-col justify-between p-12">
                <div>
                    <a href="/" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-lg">SN</span>
                        </div>
                        <span class="text-white font-bold text-2xl">SchoolNote</span>
                    </a>
                </div>

                <div>
                    <h2 class="text-3xl font-bold text-white mb-4">
                        Bienvenue sur votre espace scolaire numérique
                    </h2>
                    <p class="text-indigo-200 text-lg">
                        Gérez vos notes, évaluations et bulletins en toute simplicité.
                    </p>

                    <div class="mt-10 space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-sm">🛡️</div>
                            <span class="text-indigo-100">Espace sécurisé par rôle</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-sm">📊</div>
                            <span class="text-indigo-100">Bulletins avec rang et moyennes pondérées</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-sm">📥</div>
                            <span class="text-indigo-100">Téléchargement PDF des bulletins</span>
                        </div>
                    </div>
                </div>

                <div class="text-indigo-300 text-sm">
                    SchoolNote — Projet DWWM {{ date('Y') }} — INT Éducation Paris
                </div>
            </div>

            <!-- Côté droit : formulaire -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 py-12">
                <div class="w-full max-w-md">
                    <!-- Logo mobile -->
                    <div class="lg:hidden flex items-center justify-center space-x-2 mb-8">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-lg">SN</span>
                        </div>
                        <span class="text-indigo-600 font-bold text-2xl">SchoolNote</span>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>