<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Planifier une évaluation
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('enseignant.evaluations.index') }}"
                   class="text-sm text-indigo-600 hover:underline">
                    ← Retour aux évaluations
                </a>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">✏️ Nouvelle évaluation</h3>
                    <p class="text-green-100 text-sm mt-1">
                        Disponible du lundi au vendredi, entre 07h30 et 18h00
                    </p>
                </div>

                <div class="p-6">
                    <form action="{{ route('enseignant.evaluations.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="enseigner_id" value="Matière / Classe" />
                            <select id="enseigner_id" name="enseigner_id" required
                                    class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="">-- Choisir --</option>
                                @foreach ($enseignements as $enseignement)
                                    <option value="{{ $enseignement->id }}" @selected(old('enseigner_id') == $enseignement->id)>
                                        📚 {{ $enseignement->matiere->nom }} — 🏫 {{ $enseignement->classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('enseigner_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="type" value="Type d'évaluation" />
                            <select id="type" name="type" required
                                    class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="">-- Choisir --</option>
                                <option value="Contrôle" @selected(old('type') == 'Contrôle')>Contrôle</option>
                                <option value="Devoir surveillé" @selected(old('type') == 'Devoir surveillé')>Devoir surveillé</option>
                                <option value="Interrogation" @selected(old('type') == 'Interrogation')>Interrogation</option>
                                <option value="Dissertation" @selected(old('type') == 'Dissertation')>Dissertation</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="titre" value="Titre" />
                            <x-text-input id="titre" name="titre" class="block mt-1 w-full rounded-lg"
                                          type="text" :value="old('titre')" required
                                          placeholder="ex: Chapitre 3 - Les suites" />
                            <x-input-error :messages="$errors->get('titre')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="date_evaluation" value="Date (lundi à vendredi uniquement)" />
                            <x-text-input id="date_evaluation" name="date_evaluation" class="block mt-1 w-full rounded-lg"
                                          type="date" :value="old('date_evaluation')" required />
                            <x-input-error :messages="$errors->get('date_evaluation')" class="mt-2" />
                        </div>

                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="heure_debut" value="Heure de début (07h30 min)" />
                                <x-text-input id="heure_debut" name="heure_debut" class="block mt-1 w-full rounded-lg"
                                              type="time" :value="old('heure_debut')" required
                                              min="07:30" max="17:00" />
                                <x-input-error :messages="$errors->get('heure_debut')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="heure_fin" value="Heure de fin (18h00 max)" />
                                <x-text-input id="heure_fin" name="heure_fin" class="block mt-1 w-full rounded-lg"
                                              type="time" :value="old('heure_fin')" required
                                              min="07:30" max="18:00" />
                                <x-input-error :messages="$errors->get('heure_fin')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="semestre" value="Semestre" />
                            <select id="semestre" name="semestre" required
                                    class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="1" @selected(old('semestre') == 1)>Semestre 1</option>
                                <option value="2" @selected(old('semestre') == 2)>Semestre 2</option>
                            </select>
                            <x-input-error :messages="$errors->get('semestre')" class="mt-2" />
                        </div>

                        <!-- Info sur les contraintes -->
                        <div class="mb-6 p-3 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-700">
                            ℹ️ Les évaluations doivent se tenir du <strong>lundi au vendredi</strong>,
                            entre <strong>07h30 et 18h00</strong>.
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="{{ route('enseignant.evaluations.index') }}"
                               class="text-sm text-gray-500 hover:text-gray-700">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">
                                ✅ Planifier l'évaluation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>