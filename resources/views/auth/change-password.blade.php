<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Changement de mot de passe</h2>
        <p class="text-gray-500 text-sm mt-1">
            Pour des raisons de sécurité, vous devez changer votre mot de passe avant de continuer.
        </p>
    </div>

    <!-- Règles du mot de passe -->
    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-800">
        ⚠️ <strong>Votre nouveau mot de passe doit contenir :</strong>
        <ul class="mt-2 space-y-1 ml-4">
            <li>✅ Au moins <strong>8 caractères</strong></li>
            <li>✅ Une <strong>majuscule</strong> (A-Z)</li>
            <li>✅ Une <strong>minuscule</strong> (a-z)</li>
            <li>✅ Un <strong>chiffre</strong> (0-9)</li>
            <li>✅ Un <strong>caractère spécial</strong> (!@#$%...)</li>
        </ul>
    </div>

    <form method="POST" action="{{ route('password.change.store') }}">
        @csrf

        <!-- Nouveau mot de passe -->
        <div class="mb-4">
            <x-input-label for="password" value="Nouveau mot de passe" />
            <x-text-input id="password" class="block mt-1 w-full rounded-lg"
                          type="password" name="password" required
                          placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmation -->
        <div class="mb-6">
            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-lg"
                          type="password" name="password_confirmation" required
                          placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit"
                class="w-full py-3 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
            🔐 Enregistrer mon mot de passe →
        </button>

        <!-- Lien déconnexion -->
        <div class="mt-4 text-center">
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm text-gray-400 hover:text-gray-600">
                    Se déconnecter
                </button>
            </form>
        </div>
    </form>
</x-guest-layout>