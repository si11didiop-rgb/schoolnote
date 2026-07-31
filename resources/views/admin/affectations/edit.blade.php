<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier l'affectation
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('admin.affectations.index') }}"
                   class="text-sm text-indigo-600 hover:underline">
                    ← Retour aux affectations
                </a>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">✏️ Modifier l'affectation</h3>
                    <p class="text-pink-200 text-sm mt-1">
                        {{ $affectation->enseignant->name }} —
                        {{ $affectation->matiere->nom }} —
                        {{ $affectation->classe->nom }}
                    </p>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.affectations.update', $affectation) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="enseignant_id" value="Enseignant" />
                            <select id="enseignant_id" name="enseignant_id" required
                                    class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                                @foreach ($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}"
                                        @selected(old('enseignant_id', $affectation->enseignant_id) == $enseignant->id)>
                                        👨‍🏫 {{ $enseignant->prenom }} {{ $enseignant->nom }}
                                        @if($enseignant->specialite)
                                            ({{ $enseignant->specialite }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('enseignant_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="matiere_id" value="Matière" />
                            <select id="matiere_id" name="matiere_id" required
                                    class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                                @foreach ($matieres as $matiere)
                                    <option value="{{ $matiere->id }}"
                                        @selected(old('matiere_id', $affectation->matiere_id) == $matiere->id)>
                                        📚 {{ $matiere->nom }} (Coeff. {{ $matiere->coefficient }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('matiere_id')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="classe_id" value="Classe" />
                            <select id="classe_id" name="classe_id" required
                                    class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                                @foreach ($classes as $classe)
                                    <option value="{{ $classe->id }}"
                                        @selected(old('classe_id', $affectation->classe_id) == $classe->id)>
                                        🏫 {{ $classe->nom }} — {{ $classe->niveau }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('classe_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.affectations.index') }}"
                               class="text-sm text-gray-500 hover:text-gray-700">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 bg-pink-500 text-white rounded-lg font-medium hover:bg-pink-600 transition">
                                💾 Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>