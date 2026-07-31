<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mentions légales
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-xl p-8 space-y-8">

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">1. Éditeur du site</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        <strong>Nom du projet :</strong> SchoolNote<br>
                        <strong>Nature :</strong> Projet pédagogique réalisé dans le cadre du Titre Professionnel
                        Développeur Web et Web Mobile (DWWM — RNCP Niveau 5)<br>
                        <strong>Établissement de formation :</strong> INT Éducation Paris<br>
                        <strong>Auteur :</strong> Sidy Diop<br>
                        <strong>Année :</strong> {{ date('Y') }}<br>
                        <strong>Contact :</strong> admin@schoolnote.fr
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">2. Hébergement</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Ce projet est hébergé localement dans le cadre d'un environnement de développement
                        (XAMPP / Windows). Il n'est pas destiné à être mis en production publique dans sa forme actuelle.
                        En cas de déploiement, l'hébergeur devra être déclaré conformément à la loi n° 2004-575
                        du 21 juin 2004 pour la confiance dans l'économie numérique (LCEN).
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">3. Propriété intellectuelle</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        L'ensemble du code source, des designs et des contenus de SchoolNote sont la propriété
                        de l'auteur du projet. Toute reproduction, même partielle, est interdite sans autorisation
                        préalable écrite, conformément au Code de la propriété intellectuelle.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">4. Responsabilité</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Les données présentes dans cette application sont fictives et utilisées uniquement
                        à des fins de démonstration dans le cadre de la soutenance DWWM. L'éditeur ne saurait
                        être tenu responsable des dommages directs ou indirects résultant de l'utilisation
                        de ce site.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">5. Droit applicable</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Les présentes mentions légales sont soumises au droit français. En cas de litige,
                        les tribunaux français seront seuls compétents.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">6. Technologies utilisées</h3>
                    <ul class="text-gray-600 text-sm space-y-1">
                        <li>🔧 <strong>Framework PHP :</strong> Laravel 12 (MIT License)</li>
                        <li>🎨 <strong>CSS :</strong> Tailwind CSS (MIT License)</li>
                        <li>🗄️ <strong>Base de données :</strong> MySQL / MariaDB</li>
                        <li>🔐 <strong>Authentification :</strong> Laravel Breeze</li>
                        <li>📄 <strong>Génération PDF :</strong> barryvdh/laravel-dompdf</li>
                        <li>📧 <strong>Envoi d'emails :</strong> Laravel Mail + Mailtrap (développement)</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>