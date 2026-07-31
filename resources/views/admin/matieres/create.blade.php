<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter une matière
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('admin.matieres.index') }}"
                   class="text-sm text-indigo-600 hover:underline">
                    ← Retour aux matières
                </a>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">📚 Nouvelle matière</h3>
                    <p class="text-yellow-100 text-sm mt-1">Remplissez les informations ci-dessous</p>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.matieres.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="nom" value="Nom de la matière" />
                            <x-text-input id="nom" name="nom" class="block mt-1 w-full rounded-lg"
                                          type="text" :value="old('nom')" required autofocus
                                          placeholder="ex: Mathématiques" />
                            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="coefficient" value="Coefficient" />
                            <x-text-input id="coefficient" name="coefficient" class="block mt-1 w-full rounded-lg"
                                          type="number" :value="old('coefficient')" required min="1" max="20"
                                          placeholder="ex: 4" />
                            <x-input-error :messages="$errors->get('coefficient')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.matieres.index') }}"
                               class="text-sm text-gray-500 hover:text-gray-700">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 bg-yellow-500 text-white rounded-lg font-medium hover:bg-yellow-600 transition">
                                ✅ Créer la matière
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>