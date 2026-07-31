<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Espace Élève
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800">
                    Bonjour, {{ Auth::user()->prenom }} 👋
                </h3>
                <p class="text-gray-500 mt-1">{{ Auth::user()->classe->nom ?? '—' }} — Année 2025-2026</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('eleve.notes') }}"
                   class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-xl p-6 text-center hover:shadow-lg transition hover:-translate-y-1">
                    <div class="text-4xl mb-3">📝</div>
                    <div class="font-bold text-lg">Mes notes</div>
                    <div class="text-indigo-200 text-sm mt-1">Consulter toutes mes notes</div>
                </a>

                <a href="{{ route('eleve.evaluations') }}"
                   class="bg-gradient-to-br from-yellow-400 to-yellow-500 text-white rounded-xl p-6 text-center hover:shadow-lg transition hover:-translate-y-1">
                    <div class="text-4xl mb-3">📅</div>
                    <div class="font-bold text-lg">Mes évaluations</div>
                    <div class="text-yellow-100 text-sm mt-1">À venir et passées</div>
                </a>

                <a href="{{ route('eleve.bulletin') }}"
                   class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-6 text-center hover:shadow-lg transition hover:-translate-y-1">
                    <div class="text-4xl mb-3">📊</div>
                    <div class="font-bold text-lg">Mon bulletin</div>
                    <div class="text-green-100 text-sm mt-1">Moyennes et rang</div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>