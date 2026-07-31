<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Connexion</h2>
        <p class="text-gray-500 text-sm mt-1">Entrez vos identifiants pour accéder à votre espace.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-4">
            <x-input-label for="email" value="Adresse email" />
            <x-text-input id="email"
                          class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                          type="email"
                          name="email"
                          :value="old('email')"
                          required autofocus autocomplete="username"
                          placeholder="exemple@schoolnote.fr" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
        <div class="mb-4">
            <x-input-label for="password" value="Mot de passe" />
            <x-text-input id="password"
                          class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                          type="password"
                          name="password"
                          required autocomplete="current-password"
                          placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Se souvenir de moi -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">Se souvenir de moi</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-700 hover:underline"
                   href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <!-- Bouton connexion -->
        <button type="submit"
                class="w-full py-3 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Se connecter →
        </button>

        <!-- Comptes de démo -->
        <div class="mt-8 p-4 bg-gray-50 border border-gray-200 rounded-lg">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Comptes de démonstration</p>
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>🛡️ Admin</span>
                    <span class="text-gray-400">admin@schoolnote.fr</span>
                </div>
                <div class="flex justify-between">
                    <span>👨‍🏫 Enseignant</span>
                    <span class="text-gray-400">jean.martin@schoolnote.fr</span>
                </div>
                <div class="flex justify-between">
                    <span>🎓 Élève</span>
                    <span class="text-gray-400">lucas.durand@schoolnote.fr</span>
                </div>
                <div class="flex justify-between">
                    <span>👨‍👩‍👧 Parent</span>
                    <span class="text-gray-400">paul.durand@schoolnote.fr</span>
                </div>
                <p class="text-gray-400 text-xs mt-2">Mot de passe : <strong>password</strong></p>
            </div>
        </div>
    </form>
</x-guest-layout>