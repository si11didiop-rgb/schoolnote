<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Accessibilité
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-xl p-8 space-y-8">

                <div class="p-4 bg-indigo-50 border border-indigo-200 rounded-lg text-sm text-indigo-800">
                    Conformément à la loi n° 2005-102 du 11 février 2005 pour l'égalité des droits et des chances,
                    SchoolNote s'engage à rendre son interface accessible au plus grand nombre d'utilisateurs,
                    y compris les personnes en situation de handicap.
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">1. État de conformité</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        SchoolNote est en <strong>conformité partielle</strong> avec le Référentiel Général
                        d'Amélioration de l'Accessibilité (RGAA 4.1). Les non-conformités et les dérogations
                        sont listées ci-dessous.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">2. Mesures prises</h3>
                    <ul class="text-gray-600 text-sm space-y-2">
                        <li class="flex items-start space-x-2">
                            <span class="text-green-500 font-bold mt-0.5">✅</span>
                            <span><strong>Contraste des couleurs :</strong> ratio de contraste suffisant entre le texte et l'arrière-plan (minimum 4.5:1 pour le texte normal)</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-500 font-bold mt-0.5">✅</span>
                            <span><strong>Navigation au clavier :</strong> toutes les fonctionnalités sont accessibles via le clavier (Tab, Entrée, Échap)</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-500 font-bold mt-0.5">✅</span>
                            <span><strong>Labels de formulaire :</strong> tous les champs de formulaire ont un label explicite associé</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-500 font-bold mt-0.5">✅</span>
                            <span><strong>Messages d'erreur :</strong> les erreurs de formulaire sont clairement identifiées et expliquées en français</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-500 font-bold mt-0.5">✅</span>
                            <span><strong>Interface responsive :</strong> le site s'adapte à toutes les tailles d'écran (mobile, tablette, desktop)</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-500 font-bold mt-0.5">✅</span>
                            <span><strong>Structure sémantique :</strong> utilisation correcte des balises HTML5 (header, nav, main, footer, h1-h6)</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-500 font-bold mt-0.5">✅</span>
                            <span><strong>Langue déclarée :</strong> la langue de la page est déclarée en français (lang="fr")</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-500 font-bold mt-0.5">✅</span>
                            <span><strong>Titre des pages :</strong> chaque page possède un titre unique et descriptif</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">3. Non-conformités et limites</h3>
                    <ul class="text-gray-600 text-sm space-y-2">
                        <li class="flex items-start space-x-2">
                            <span class="text-orange-500 font-bold mt-0.5">⚠️</span>
                            <span><strong>Attributs ARIA :</strong> les attributs ARIA avancés (aria-live, aria-describedby) ne sont pas entièrement implémentés</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-orange-500 font-bold mt-0.5">⚠️</span>
                            <span><strong>Lecteurs d'écran :</strong> la compatibilité avec les lecteurs d'écran (NVDA, JAWS) n'a pas été entièrement testée</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-orange-500 font-bold mt-0.5">⚠️</span>
                            <span><strong>Emojis :</strong> les emojis utilisés comme icônes n'ont pas tous un texte alternatif explicite</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-orange-500 font-bold mt-0.5">⚠️</span>
                            <span><strong>PDF :</strong> les bulletins générés en PDF ne sont pas entièrement accessibles aux lecteurs d'écran</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">4. Technologies d'assistance supportées</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        SchoolNote a été testé avec les combinaisons suivantes :
                    </p>
                    <ul class="text-gray-600 text-sm space-y-1 ml-4 mt-2">
                        <li>• Chrome 120+ / Windows 10</li>
                        <li>• Microsoft Edge 120+ / Windows 10</li>
                        <li>• Firefox 120+ / Windows 10</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">5. Signalement et contact</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Si vous rencontrez un obstacle à l'accessibilité, vous pouvez nous contacter :
                    </p>
                    <ul class="text-gray-600 text-sm space-y-1 ml-4 mt-2">
                        <li>📧 Email : <strong>admin@schoolnote.fr</strong></li>
                    </ul>
                    <p class="text-gray-600 text-sm mt-3">
                        Nous nous engageons à vous répondre dans un délai de <strong>5 jours ouvrés</strong>.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">6. Voie de recours</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Si vous n'obtenez pas de réponse satisfaisante, vous pouvez contacter le
                        <strong>Défenseur des droits</strong> :
                    </p>
                    <ul class="text-gray-600 text-sm space-y-1 ml-4 mt-2">
                        <li>🌐 <a href="https://www.defenseurdesdroits.fr" target="_blank" class="text-indigo-600 hover:underline">www.defenseurdesdroits.fr</a></li>
                        <li>📞 09 69 39 00 00 (appel non surtaxé)</li>
                    </ul>
                </div>

                <div class="text-xs text-gray-400 border-t border-gray-100 pt-4">
                    Déclaration d'accessibilité établie le {{ date('d/m/Y') }} —
                    Dernière révision le {{ date('d/m/Y') }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>