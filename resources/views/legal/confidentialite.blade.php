<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Politique de confidentialité
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-xl p-8 space-y-8">

                <div class="p-4 bg-indigo-50 border border-indigo-200 rounded-lg text-sm text-indigo-800">
                    Conformément au Règlement Général sur la Protection des Données (RGPD — Règlement UE 2016/679)
                    et à la loi Informatique et Libertés n° 78-17 du 6 janvier 1978 modifiée,
                    SchoolNote s'engage à protéger les données personnelles de ses utilisateurs.
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">1. Responsable du traitement</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Le responsable du traitement des données est l'établissement scolaire utilisant
                        la plateforme SchoolNote. Dans le cadre de ce projet pédagogique :
                        <strong>Sidy Diop — INT Éducation Paris</strong><br>
                        Contact : admin@schoolnote.fr
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">2. Données collectées</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-2">
                        SchoolNote collecte uniquement les données strictement nécessaires à son fonctionnement
                        (principe de minimisation des données — Art. 5 RGPD) :
                    </p>
                    <ul class="text-gray-600 text-sm space-y-1 ml-4">
                        <li>• <strong>Identité :</strong> nom, prénom, genre</li>
                        <li>• <strong>Contact :</strong> adresse email</li>
                        <li>• <strong>Authentification :</strong> mot de passe (chiffré via bcrypt)</li>
                        <li>• <strong>Données scolaires :</strong> notes, évaluations, moyennes, bulletins</li>
                        <li>• <strong>Données spécifiques élèves :</strong> date de naissance, classe</li>
                        <li>• <strong>Données de connexion :</strong> adresse IP, date/heure de connexion (sessions)</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">3. Base légale du traitement</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Le traitement des données est fondé sur :
                    </p>
                    <ul class="text-gray-600 text-sm space-y-1 ml-4 mt-2">
                        <li>• <strong>L'exécution d'une mission d'intérêt public</strong> (Art. 6.1.e RGPD) :
                        gestion scolaire et suivi pédagogique</li>
                        <li>• <strong>L'obligation légale</strong> (Art. 6.1.c RGPD) :
                        conservation des résultats scolaires</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">4. Finalités du traitement</h3>
                    <ul class="text-gray-600 text-sm space-y-1 ml-4">
                        <li>• Gestion des comptes utilisateurs (élèves, enseignants, parents, administrateurs)</li>
                        <li>• Suivi des résultats scolaires et génération des bulletins</li>
                        <li>• Communication par email (notifications pédagogiques)</li>
                        <li>• Sécurisation de l'accès par rôles</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">5. Destinataires des données</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Les données sont accessibles uniquement aux personnes autorisées selon leur rôle :
                    </p>
                    <ul class="text-gray-600 text-sm space-y-1 ml-4 mt-2">
                        <li>• <strong>Administrateur :</strong> accès à toutes les données</li>
                        <li>• <strong>Enseignant :</strong> accès aux données de ses classes uniquement</li>
                        <li>• <strong>Élève :</strong> accès à ses propres données uniquement</li>
                        <li>• <strong>Parent :</strong> accès aux données de ses enfants uniquement</li>
                    </ul>
                    <p class="text-gray-600 text-sm mt-2">
                        Les données ne sont ni vendues, ni cédées, ni transmises à des tiers.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">6. Durée de conservation</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Conformément au principe de limitation de la conservation (Art. 5.1.e RGPD) :
                    </p>
                    <ul class="text-gray-600 text-sm space-y-1 ml-4 mt-2">
                        <li>• Données scolaires : durée de la scolarité + 5 ans</li>
                        <li>• Données de connexion (sessions) : 120 minutes (durée de session)</li>
                        <li>• Emails envoyés : non conservés par SchoolNote</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">7. Sécurité des données</h3>
                    <ul class="text-gray-600 text-sm space-y-1 ml-4">
                        <li>✅ Mots de passe chiffrés via bcrypt (irréversible)</li>
                        <li>✅ Accès contrôlé par système de rôles (RBAC)</li>
                        <li>✅ Protection CSRF sur tous les formulaires</li>
                        <li>✅ Validation et assainissement de toutes les entrées utilisateur</li>
                        <li>✅ Sessions sécurisées</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">8. Vos droits (Art. 15 à 22 RGPD)</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-2">
                        Conformément au RGPD, vous disposez des droits suivants sur vos données :
                    </p>
                    <ul class="text-gray-600 text-sm space-y-1 ml-4">
                        <li>• <strong>Droit d'accès</strong> (Art. 15) : consulter vos données personnelles</li>
                        <li>• <strong>Droit de rectification</strong> (Art. 16) : corriger vos données inexactes</li>
                        <li>• <strong>Droit à l'effacement</strong> (Art. 17) : supprimer vos données</li>
                        <li>• <strong>Droit à la portabilité</strong> (Art. 20) : recevoir vos données dans un format lisible</li>
                        <li>• <strong>Droit d'opposition</strong> (Art. 21) : vous opposer au traitement</li>
                        <li>• <strong>Droit à la limitation</strong> (Art. 18) : limiter le traitement de vos données</li>
                    </ul>
                    <p class="text-gray-600 text-sm mt-3">
                        Pour exercer ces droits, contactez l'administrateur à : <strong>admin@schoolnote.fr</strong>
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">9. Réclamation auprès de la CNIL</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Si vous estimez que vos droits ne sont pas respectés, vous pouvez introduire une réclamation
                        auprès de la <strong>Commission Nationale de l'Informatique et des Libertés (CNIL)</strong> :
                    </p>
                    <ul class="text-gray-600 text-sm space-y-1 ml-4 mt-2">
                        <li>🌐 <a href="https://www.cnil.fr" target="_blank" class="text-indigo-600 hover:underline">www.cnil.fr</a></li>
                        <li>📮 3 Place de Fontenoy — TSA 80715 — 75334 Paris Cedex 07</li>
                        <li>📞 01 53 73 22 22</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">10. Cookies</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        SchoolNote utilise uniquement des cookies strictement nécessaires au fonctionnement
                        de l'application (cookie de session, token CSRF). Aucun cookie publicitaire ou de
                        traçage n'est utilisé. Ces cookies ne nécessitent pas de consentement préalable
                        conformément à la recommandation de la CNIL du 17 septembre 2020.
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>