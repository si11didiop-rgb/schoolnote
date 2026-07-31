<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tableau de bord
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Message de bienvenue -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800">
                    Bonjour, {{ Auth::user()->prenom }} 👋
                </h3>
                <p class="text-gray-500 mt-1">Voici un aperçu de votre établissement.</p>
            </div>

            <!-- Statistiques -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                <a href="{{ route('admin.classes.index') }}"
                   class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-md transition hover:-translate-y-1">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl">🏫</span>
                    </div>
                    <div class="text-3xl font-bold text-indigo-600">{{ $stats['classes'] }}</div>
                    <div class="text-gray-500 text-sm mt-1">Classes</div>
                </a>

                <a href="{{ route('admin.comptes.index') }}"
                   class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-md transition hover:-translate-y-1">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl">🎓</span>
                    </div>
                    <div class="text-3xl font-bold text-green-600">{{ $stats['eleves'] }}</div>
                    <div class="text-gray-500 text-sm mt-1">Élèves</div>
                </a>

                <a href="{{ route('admin.comptes.index') }}"
                   class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-md transition hover:-translate-y-1">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl">👨‍🏫</span>
                    </div>
                    <div class="text-3xl font-bold text-yellow-600">{{ $stats['enseignants'] }}</div>
                    <div class="text-gray-500 text-sm mt-1">Enseignants</div>
                </a>

                <a href="{{ route('admin.matieres.index') }}"
                   class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-md transition hover:-translate-y-1">
                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl">📚</span>
                    </div>
                    <div class="text-3xl font-bold text-pink-600">{{ $stats['matieres'] }}</div>
                    <div class="text-gray-500 text-sm mt-1">Matières</div>
                </a>
            </div>

            <!-- Accès rapides -->
            <div class="mb-10">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Accès rapides</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('admin.comptes.create') }}"
                       class="bg-indigo-600 text-white rounded-xl p-4 text-center hover:bg-indigo-700 transition">
                        <div class="text-2xl mb-1">➕</div>
                        <div class="text-sm font-medium">Nouveau compte</div>
                    </a>
                    <a href="{{ route('admin.classes.create') }}"
                       class="bg-green-600 text-white rounded-xl p-4 text-center hover:bg-green-700 transition">
                        <div class="text-2xl mb-1">🏫</div>
                        <div class="text-sm font-medium">Nouvelle classe</div>
                    </a>
                    <a href="{{ route('admin.matieres.create') }}"
                       class="bg-yellow-500 text-white rounded-xl p-4 text-center hover:bg-yellow-600 transition">
                        <div class="text-2xl mb-1">📚</div>
                        <div class="text-sm font-medium">Nouvelle matière</div>
                    </a>
                    <a href="{{ route('admin.affectations.create') }}"
                       class="bg-pink-500 text-white rounded-xl p-4 text-center hover:bg-pink-600 transition">
                        <div class="text-2xl mb-1">🔗</div>
                        <div class="text-sm font-medium">Nouvelle affectation</div>
                    </a>
                </div>
            </div>

            <!-- Résumé par classe -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Effectifs par classe</h3>
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Classe</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Niveau</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Effectif</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Bulletins S1</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Bulletins S2</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($classes as $classe)
                                <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-800">{{ $classe->nom }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $classe->niveau }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                                            {{ $classe->afficherEffectif() }} élève(s)
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $classe->bulletin_s1_publie ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $classe->bulletin_s1_publie ? '✅ Publié' : '🔒 Masqué' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $classe->bulletin_s2_publie ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $classe->bulletin_s2_publie ? '✅ Publié' : '🔒 Masqué' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.classes.show', $classe) }}"
                                           class="text-indigo-600 hover:underline text-sm font-medium">
                                            Voir les élèves →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                        Aucune classe pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>