<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter une classe
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('admin.classes.index') }}"
                   class="text-sm text-indigo-600 hover:underline">
                    ← Retour aux classes
                </a>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                <!-- En-tête du formulaire -->
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">🏫 Nouvelle classe</h3>
                    <p class="text-indigo-200 text-sm mt-1">Remplissez les informations ci-dessous</p>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.classes.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="nom" value="Nom de la classe" />
                            <x-text-input id="nom" name="nom" class="block mt-1 w-full rounded-lg"
                                          type="text" :value="old('nom')" required autofocus
                                          placeholder="ex: Terminale A" />
                            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="niveau" value="Niveau" />
                            <x-text-input id="niveau" name="niveau" class="block mt-1 w-full rounded-lg"
                                          type="text" :value="old('niveau')" required
                                          placeholder="ex: Terminale, Première, Seconde" />
                            <x-input-error :messages="$errors->get('niveau')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="annee_scolaire" value="Année scolaire" />
                            <x-text-input id="annee_scolaire" name="annee_scolaire" class="block mt-1 w-full rounded-lg"
                                          type="text" :value="old('annee_scolaire')" required
                                          placeholder="ex: 2025-2026" />
                            <x-input-error :messages="$errors->get('annee_scolaire')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.classes.index') }}"
                               class="text-sm text-gray-500 hover:text-gray-700">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">
                                ✅ Créer la classe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>