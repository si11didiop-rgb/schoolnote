<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modifier l'affectation
            </h2>
            <a href="{{ route('admin.affectations.index') }}"
               class="text-sm text-indigo-600 hover:underline">
                ← Retour aux affectations
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                <div class="bg-indigo-600 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">✏️ Modifier l'affectation</h3>
                    <p class="text-indigo-200 text-sm mt-1">
                        {{ $affectation->enseignant->nom }} {{ $affectation->enseignant->prenom }} —
                        {{ $affectation->matiere->nom }} — {{ $affectation->classe->nom }}
                    </p>
                </div>

                <form action="{{ route('admin.affectations.update', $affectation) }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PATCH')

                    @if ($errors->any())
                        <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <x-input-label for="enseignant_id" value="Enseignant" />
                        <select id="enseignant_id" name="enseignant_id" required
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Choisir un enseignant --</option>
                            @foreach ($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}"
                                        @selected(old('enseignant_id', $affectation->enseignant_id) == $enseignant->id)>
                                    {{ $enseignant->nom }} {{ $enseignant->prenom }}
                                    @if($enseignant->specialite) ({{ $enseignant->specialite }}) @endif
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('enseignant_id')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="matiere_id" value="Matière" />
                        <select id="matiere_id" name="matiere_id" required
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Choisir une matière --</option>
                            @foreach ($matieres as $matiere)
                                <option value="{{ $matiere->id }}"
                                        @selected(old('matiere_id', $affectation->matiere_id) == $matiere->id)>
                                    {{ $matiere->nom }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('matiere_id')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="classe_id" value="Classe" />
                        <select id="classe_id" name="classe_id" required
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Choisir une classe --</option>
                            @foreach ($classes as $classe)
                                <option value="{{ $classe->id }}"
                                        @selected(old('classe_id', $affectation->classe_id) == $classe->id)>
                                    {{ $classe->nom }} ({{ $classe->niveau }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('classe_id')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="coefficient" value="Coefficient (spécifique à cette classe)" />
                        <x-text-input id="coefficient" name="coefficient" type="number"
                                      class="mt-1 block w-full" min="1" max="20"
                                      :value="old('coefficient', $affectation->coefficient)" required />
                        <p class="text-xs text-gray-400 mt-1">
                            Le coefficient peut varier selon la classe (ex: Maths coeff 4 en Terminale S, coeff 2 en Première L)
                        </p>
                        <x-input-error :messages="$errors->get('coefficient')" class="mt-1" />
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.affectations.index') }}"
                           class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                            Annuler
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                            💾 Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
