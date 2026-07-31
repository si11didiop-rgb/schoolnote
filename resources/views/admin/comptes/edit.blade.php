<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le compte
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('admin.comptes.index') }}"
                   class="text-sm text-indigo-600 hover:underline">
                    ← Retour aux comptes
                </a>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">✏️ Modifier le compte</h3>
                    <p class="text-indigo-200 text-sm mt-1">{{ $user->prenom }} {{ $user->nom }}</p>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.comptes.update', $user) }}" method="POST"
                          x-data="{ role: '{{ old('role', $user->role) }}' }">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="nom" value="Nom" />
                                <x-text-input id="nom" name="nom" class="block mt-1 w-full rounded-lg"
                                              type="text" :value="old('nom', $user->nom)" required autofocus />
                                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="prenom" value="Prénom" />
                                <x-text-input id="prenom" name="prenom" class="block mt-1 w-full rounded-lg"
                                              type="text" :value="old('prenom', $user->prenom)" required />
                                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="genre" value="Genre" />
                            <select id="genre" name="genre"
                                    class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="">-- Non précisé --</option>
                                <option value="M" @selected(old('genre', $user->genre) == 'M')>Masculin</option>
                                <option value="F" @selected(old('genre', $user->genre) == 'F')>Féminin</option>
                            </select>
                            <x-input-error :messages="$errors->get('genre')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="email" value="Adresse email" />
                            <x-text-input id="email" name="email" class="block mt-1 w-full rounded-lg"
                                          type="email" :value="old('email', $user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="password" value="Mot de passe (laisser vide pour ne pas changer)" />
                            <x-text-input id="password" name="password" class="block mt-1 w-full rounded-lg"
                                          type="password" placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="role" value="Rôle" />
                            <select id="role" name="role" x-model="role" required
                                    class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="administrateur">🛡️ Administrateur</option>
                                <option value="enseignant">👨‍🏫 Enseignant</option>
                                <option value="eleve">🎓 Élève</option>
                                <option value="parent">👨‍👩‍👧 Parent</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Champs spécifiques ELEVE -->
                        <div x-show="role === 'eleve'"
                             class="mt-4 space-y-4 border border-yellow-200 bg-yellow-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-yellow-700 uppercase tracking-wider">
                                🎓 Informations élève
                            </p>
                            <div>
                                <x-input-label for="date_de_naissance" value="Date de naissance" />
                                <x-text-input id="date_de_naissance" name="date_de_naissance"
                                              class="block mt-1 w-full rounded-lg"
                                              type="date"
                                              :value="old('date_de_naissance', $user->date_de_naissance?->format('Y-m-d'))" />
                                <x-input-error :messages="$errors->get('date_de_naissance')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="classe_id" value="Classe" />
                                <select id="classe_id" name="classe_id"
                                        class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="">-- Choisir une classe --</option>
                                    @foreach ($classes as $classe)
                                        <option value="{{ $classe->id }}"
                                            @selected(old('classe_id', $user->classe_id) == $classe->id)>
                                            {{ $classe->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('classe_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="parent_id" value="Parent (facultatif)" />
                                <select id="parent_id" name="parent_id"
                                        class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="">-- Aucun --</option>
                                    @foreach ($parents as $parent)
                                        <option value="{{ $parent->id }}"
                                            @selected(old('parent_id', $user->parent_id) == $parent->id)>
                                            {{ $parent->prenom }} {{ $parent->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Champ spécifique ENSEIGNANT -->
                        <div x-show="role === 'enseignant'"
                             class="mt-4 border border-green-200 bg-green-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-green-700 uppercase tracking-wider mb-3">
                                👨‍🏫 Informations enseignant
                            </p>
                            <x-input-label for="specialite" value="Spécialité" />
                            <x-text-input id="specialite" name="specialite" class="block mt-1 w-full rounded-lg"
                                          type="text" :value="old('specialite', $user->specialite)"
                                          placeholder="ex: Mathématiques" />
                            <x-input-error :messages="$errors->get('specialite')" class="mt-2" />
                        </div>

                        <!-- Champ spécifique PARENT -->
                        <div x-show="role === 'parent'"
                             class="mt-4 border border-pink-200 bg-pink-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-pink-700 uppercase tracking-wider mb-3">
                                👨‍👩‍👧 Informations parent
                            </p>
                            <x-input-label for="lien_parente" value="Lien de parenté" />
                            <x-text-input id="lien_parente" name="lien_parente" class="block mt-1 w-full rounded-lg"
                                          type="text" :value="old('lien_parente', $user->lien_parente)"
                                          placeholder="ex: père, mère, tuteur" />
                            <x-input-error :messages="$errors->get('lien_parente')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.comptes.index') }}"
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