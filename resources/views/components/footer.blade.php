<footer class="bg-gray-800 text-gray-300 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">

            <!-- Colonne 1 : Logo -->
            <div>
                <div class="flex items-center space-x-2 mb-3">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">SN</span>
                    </div>
                    <span class="font-bold text-lg text-white">SchoolNote</span>
                </div>
                <p class="text-sm text-gray-400">
                    Plateforme de gestion des notes et évaluations pour lycées.
                    Projet réalisé dans le cadre du Titre Professionnel DWWM.
                </p>
            </div>

            <!-- Colonne 2 : Navigation -->
            <div>
                <h4 class="font-semibold text-white mb-3 text-sm uppercase tracking-wider">Navigation</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>
                        <a href="{{ route('welcome') }}" class="hover:text-white transition">Accueil</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="hover:text-white transition">Contact</a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}" class="hover:text-white transition">Se connecter</a>
                    </li>
                </ul>
            </div>

            <!-- Colonne 3 : Mentions légales -->
            <div>
                <h4 class="font-semibold text-white mb-3 text-sm uppercase tracking-wider">Informations</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>
                        <a href="{{ route('mentions.legales') }}" class="hover:text-white transition">
                            Mentions légales
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('confidentialite') }}" class="hover:text-white transition">
                            Politique de confidentialité
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('accessibilite') }}" class="hover:text-white transition">
                            Accessibilité
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-700 pt-6 flex flex-col md:flex-row items-center justify-between text-xs text-gray-500">
            <p>© {{ date('Y') }} SchoolNote — Tous droits réservés</p>
            <p class="mt-2 md:mt-0">
                Projet DWWM — INT Éducation Paris —
                Développé avec
                <span class="text-indigo-400">Laravel 12</span> ·
                <span class="text-indigo-400">Tailwind CSS</span> ·
                <span class="text-indigo-400">MySQL</span>
            </p>
        </div>
    </div>
</footer>