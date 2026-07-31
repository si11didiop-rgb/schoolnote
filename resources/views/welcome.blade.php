<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SchoolNote — Gestion des notes et évaluations</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm">SN</span>
                </div>
                <span class="font-bold text-xl text-indigo-600">SchoolNote</span>
            </div>
            <div>
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-5 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">
                        Mon espace →
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-5 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">
                        Se connecter
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="bg-gradient-to-br from-indigo-600 to-indigo-800 text-white py-24">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <span class="inline-block bg-white/20 text-white text-sm font-medium px-4 py-1 rounded-full mb-6">
                Plateforme scolaire numérique
            </span>
            <h1 class="text-5xl font-bold mb-6 leading-tight">
                Gérez vos notes et évaluations <br> en toute simplicité
            </h1>
            <p class="text-lg text-indigo-100 mb-10 max-w-2xl mx-auto">
                SchoolNote centralise la gestion pédagogique d'un lycée :
                notes, bulletins, évaluations et suivi des résultats pour tous les acteurs.
            </p>
            @auth
                <a href="{{ route('dashboard') }}"
                   class="inline-block px-8 py-4 bg-white text-indigo-600 font-bold rounded-lg text-lg hover:bg-indigo-50 transition shadow-lg">
                    Accéder à mon espace →
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="inline-block px-8 py-4 bg-white text-indigo-600 font-bold rounded-lg text-lg hover:bg-indigo-50 transition shadow-lg">
                    Se connecter →
                </a>
            @endauth
        </div>
    </section>

    <!-- Stats -->
    <section class="bg-white py-12 border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-indigo-600">4</div>
                    <div class="text-gray-500 text-sm mt-1">Rôles utilisateurs</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-indigo-600">100%</div>
                    <div class="text-gray-500 text-sm mt-1">Sécurisé</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-indigo-600">PDF</div>
                    <div class="text-gray-500 text-sm mt-1">Bulletins téléchargeables</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-indigo-600">2</div>
                    <div class="text-gray-500 text-sm mt-1">Semestres gérés</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fonctionnalités -->
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">
                    Une plateforme pour chaque acteur
                </h2>
                <p class="text-gray-500">Chaque utilisateur accède à son propre espace sécurisé</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Admin -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-md transition hover:-translate-y-1">
                    <div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🛡️</span>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Administrateur</h3>
                    <p class="text-sm text-gray-500">
                        Gère les classes, matières, comptes et affectations.
                        Publie les bulletins par semestre.
                    </p>
                </div>

                <!-- Enseignant -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-md transition hover:-translate-y-1">
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">👨‍🏫</span>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Enseignant</h3>
                    <p class="text-sm text-gray-500">
                        Planifie les évaluations et saisit les notes.
                        Consulte ses classes et matières.
                    </p>
                </div>

                <!-- Élève -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-md transition hover:-translate-y-1">
                    <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🎓</span>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Élève</h3>
                    <p class="text-sm text-gray-500">
                        Consulte ses notes et évaluations.
                        Télécharge son bulletin avec rang et moyennes.
                    </p>
                </div>

                <!-- Parent -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-md transition hover:-translate-y-1">
                    <div class="w-14 h-14 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">👨‍👩‍👧</span>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Parent</h3>
                    <p class="text-sm text-gray-500">
                        Suit les notes et bulletins de ses enfants
                        en temps réel.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-indigo-600 py-16 text-center text-white">
        <div class="max-w-2xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-4">Prêt à commencer ?</h2>
            <p class="text-indigo-100 mb-8">Connectez-vous pour accéder à votre espace personnel.</p>
            @auth
                <a href="{{ route('dashboard') }}"
                   class="inline-block px-8 py-4 bg-white text-indigo-600 font-bold rounded-lg hover:bg-indigo-50 transition">
                    Mon espace →
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="inline-block px-8 py-4 bg-white text-indigo-600 font-bold rounded-lg hover:bg-indigo-50 transition">
                    Se connecter →
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <x-footer />

</body>
</html>