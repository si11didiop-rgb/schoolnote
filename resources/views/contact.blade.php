<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nous contacter
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center space-x-2">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">📬 Formulaire de contact</h3>
                    <p class="text-indigo-200 text-sm mt-1">
                        Nous vous répondrons dans les 5 jours ouvrés.
                    </p>
                </div>

                <div class="p-6">
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="nom" value="Nom complet" />
                                <x-text-input id="nom" name="nom" class="block mt-1 w-full rounded-lg"
                                              type="text" :value="old('nom')"
                                              placeholder="Dupont Jean" required />
                                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="email" value="Adresse email" />
                                <x-text-input id="email" name="email" class="block mt-1 w-full rounded-lg"
                                              type="email" :value="old('email')"
                                              placeholder="jean.dupont@email.fr" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="sujet" value="Sujet" />
                            <select id="sujet" name="sujet" required
                                    class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="">-- Choisir un sujet --</option>
                                <option value="Problème de connexion" @selected(old('sujet') == 'Problème de connexion')>Problème de connexion</option>
                                <option value="Demande d'accès" @selected(old('sujet') == 'Demande d\'accès')>Demande d'accès</option>
                                <option value="Erreur dans les notes" @selected(old('sujet') == 'Erreur dans les notes')>Erreur dans les notes</option>
                                <option value="Question sur le bulletin" @selected(old('sujet') == 'Question sur le bulletin')>Question sur le bulletin</option>
                                <option value="Signalement de bug" @selected(old('sujet') == 'Signalement de bug')>Signalement de bug</option>
                                <option value="Autre" @selected(old('sujet') == 'Autre')>Autre</option>
                            </select>
                            <x-input-error :messages="$errors->get('sujet')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="message" value="Message" />
                            <textarea id="message" name="message" rows="5" required
                                      placeholder="Décrivez votre demande en détail..."
                                      class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('message') }}</textarea>
                            <p class="text-xs text-gray-400 mt-1">Maximum 2000 caractères.</p>
                            <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-400">
                                Vos données sont traitées conformément à notre
                                <a href="{{ route('confidentialite') }}" class="text-indigo-600 hover:underline">
                                    politique de confidentialité
                                </a>.
                            </p>
                            <button type="submit"
                                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">
                                📬 Envoyer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informations de contact -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
                    <div class="text-2xl mb-2">📧</div>
                    <div class="font-semibold text-gray-800 text-sm">Email</div>
                    <div class="text-gray-500 text-xs mt-1">admin@schoolnote.fr</div>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
                    <div class="text-2xl mb-2">⏰</div>
                    <div class="font-semibold text-gray-800 text-sm">Délai de réponse</div>
                    <div class="text-gray-500 text-xs mt-1">5 jours ouvrés</div>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
                    <div class="text-2xl mb-2">🏫</div>
                    <div class="font-semibold text-gray-800 text-sm">Établissement</div>
                    <div class="text-gray-500 text-xs mt-1">INT Éducation Paris</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>