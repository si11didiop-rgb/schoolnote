<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modifier le compte — {{ $user->nom }} {{ $user->prenom }}
            </h2>
            <a href="{{ route('admin.comptes.index') }}"
               class="text-sm text-indigo-600 hover:underline">
                ← Retour aux comptes
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                <div class="bg-indigo-600 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">✏️ Modifier le compte</h3>
                </div>

                <form action="{{ route('admin.comptes.update', $user) }}" method="POST" class="p-6 space-y-5">
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

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="nom" value="Nom" />
                            <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full"
                                          :value="old('nom', $user->nom)" required />
                            <x-input-error :messages="$errors->get('nom')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="prenom" value="Prénom" />
                            <x-text-input id="prenom" name="prenom" type="text" class="mt-1 block w-full"
                                          :value="old('prenom', $user->prenom)" required />
                            <x-input-error :messages="$errors->get('prenom')" class="mt-1" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="genre" value="Genre" />
                            <select id="genre" name="genre" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="">-- Choisir --</option>
                                <option value="M" @selected(old('genre', $user->genre) == 'M')>Masculin</option>
                                <option value="F" @selected(old('genre', $user->genre) == 'F')>Féminin</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="role" value="Rôle" />
                            <select id="role" name="role" required
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm"
                                    onchange="afficherChamps(this.value)">
                                <option value="administrateur" @selected(old('role', $user->role) == 'administrateur')>Administrateur</option>
                                <option value="enseignant" @selected(old('role', $user->role) == 'enseignant')>Enseignant</option>
                                <option value="eleve" @selected(old('role', $user->role) == 'eleve')>Élève</option>
                                <option value="parent" @selected(old('role', $user->role) == 'parent')>Parent</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-1" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="email" value="Adresse email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                      :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Nouveau mot de passe (laisser vide pour ne pas changer)" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Champs Élève -->
                    <div id="champs-eleve" class="space-y-4 {{ $user->role !== 'eleve' ? 'hidden' : '' }}">
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h4 class="font-semibold text-yellow-800 mb-3">🎓 Informations élève</h4>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="date_de_naissance" value="Date de naissance" />
                                    <x-text-input id="date_de_naissance" name="date_de_naissance" type="date"
                                                  class="mt-1 block w-full"
                                                  :value="old('date_de_naissance', $user->date_de_naissance?->format('Y-m-d'))" />
                                    <x-input-error :messages="$errors->get('date_de_naissance')" class="mt-1" />
                                </div>
                                <div>
                                    <x-input-label for="statut" value="Statut" />
                                    <select id="statut" name="statut"
                                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                                        <option value="actif" @selected(old('statut', $user->statut) == 'actif')>✅ Actif</option>
                                        <option value="suspendu" @selected(old('statut', $user->statut) == 'suspendu')>⏸️ Suspendu</option>
                                        <option value="diplome" @selected(old('statut', $user->statut) == 'diplome')>🎓 Diplômé</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('statut')" class="mt-1" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-input-label for="classe_id" value="Classe" />
                                <select id="classe_id" name="classe_id"
                                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="">-- Choisir une classe --</option>
                                    @foreach ($classes as $classe)
                                        <option value="{{ $classe->id }}"
                                                @selected(old('classe_id', $user->classe_id) == $classe->id)>
                                            {{ $classe->nom }} ({{ $classe->afficherEffectif() }}/{{ $classe->effectif_max }} élèves)
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('classe_id')" class="mt-1" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="parent_id" value="Parent (optionnel)" />
                                <select id="parent_id" name="parent_id"
                                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="">-- Aucun parent --</option>
                                    @foreach ($parents as $parent)
                                        <option value="{{ $parent->id }}"
                                                @selected(old('parent_id', $user->parent_id) == $parent->id)>
                                            {{ $parent->nom }} {{ $parent->prenom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Champs Enseignant -->
                    <div id="champs-enseignant" class="{{ $user->role !== 'enseignant' ? 'hidden' : '' }}">
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                            <h4 class="font-semibold text-green-800 mb-3">👨‍🏫 Informations enseignant</h4>
                            <x-input-label for="specialite" value="Spécialité" />
                            <x-text-input id="specialite" name="specialite" type="text"
                                          class="mt-1 block w-full"
                                          :value="old('specialite', $user->specialite)"
                                          placeholder="Ex : Mathématiques" />
                            <x-input-error :messages="$errors->get('specialite')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Champs Parent -->
                    <div id="champs-parent" class="{{ $user->role !== 'parent' ? 'hidden' : '' }}">
                        <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                            <h4 class="font-semibold text-red-800 mb-3">👨‍👩‍👧 Informations parent</h4>
                            <x-input-label for="lien_parente" value="Lien de parenté" />
                            <x-text-input id="lien_parente" name="lien_parente" type="text"
                                          class="mt-1 block w-full"
                                          :value="old('lien_parente', $user->lien_parente)"
                                          placeholder="Ex : père, mère, tuteur" />
                            <x-input-error :messages="$errors->get('lien_parente')" class="mt-1" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.comptes.index') }}"
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

    <script>
        function afficherChamps(role) {
            document.getElementById('champs-eleve').classList.add('hidden');
            document.getElementById('champs-enseignant').classList.add('hidden');
            document.getElementById('champs-parent').classList.add('hidden');

            if (role === 'eleve') {
                document.getElementById('champs-eleve').classList.remove('hidden');
            } else if (role === 'enseignant') {
                document.getElementById('champs-enseignant').classList.remove('hidden');
            } else if (role === 'parent') {
                document.getElementById('champs-parent').classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>
