<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier la classe
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
                    <h3 class="text-white font-bold text-lg">✏️ Modifier la classe</h3>
                    <p class="text-indigo-200 text-sm mt-1">{{ $classe->nom }}</p>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.classes.update', $classe) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="nom" value="Nom de la classe" />
                            <x-text-input id="nom" name="nom" class="block mt-1 w-full rounded-lg"
                                          type="text" :value="old('nom', $classe->nom)" required autofocus />
                            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="niveau" value="Niveau" />
                            <x-text-input id="niveau" name="niveau" class="block mt-1 w-full rounded-lg"
                                          type="text" :value="old('niveau', $classe->niveau)" required />
                            <x-input-error :messages="$errors->get('niveau')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="annee_scolaire" value="Année scolaire" />
                            <x-text-input id="annee_scolaire" name="annee_scolaire" class="block mt-1 w-full rounded-lg"
                                          type="text" :value="old('annee_scolaire', $classe->annee_scolaire)" required />
                            <x-input-error :messages="$errors->get('annee_scolaire')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.classes.index') }}"
                               class="text-sm text-gray-500 hover:text-gray-700">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">
                                💾 Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>