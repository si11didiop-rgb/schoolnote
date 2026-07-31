<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes matières
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Mes matières</h3>
                    <p class="text-sm text-gray-500">{{ $matieres->count() }} matière(s) enseignée(s)</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Matière</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Coefficient</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Classes concernées</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($matieres as $matiere)
                            @php
                                // On ne garde que les affectations de cet enseignant pour cette matière
                                $classesConcernees = $matiere->enseignements
                                    ->where('enseignant_id', Auth::id())
                                    ->pluck('classe.nom');
                            @endphp
                            <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    📚 {{ $matiere->nom }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                        Coeff. {{ $matiere->coefficient }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($classesConcernees as $nomClasse)
                                            <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                                                🏫 {{ $nomClasse }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-400">
                                    <div class="text-4xl mb-2">📚</div>
                                    <p>Vous n'enseignez aucune matière pour le moment.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>