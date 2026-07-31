<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes classes
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Mes classes</h3>
                    <p class="text-sm text-gray-500">{{ $classes->count() }} classe(s) où j'interviens</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Classe</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Niveau</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Année scolaire</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Effectif</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classes as $classe)
                            <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    🏫 {{ $classe->nom }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                                        {{ $classe->niveau }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $classe->annee_scolaire }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                        {{ $classe->afficherEffectif() }} élève(s)
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('enseignant.classes.show', $classe) }}"
                                       class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                        👥 Voir les élèves →
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                    <div class="text-4xl mb-2">🏫</div>
                                    <p>Vous n'intervenez dans aucune classe pour le moment.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>