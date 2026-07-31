<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes évaluations
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800">Mes évaluations</h3>
                <p class="text-sm text-gray-500">
                    {{ $evaluationsAVenir->count() }} à venir —
                    {{ $evaluationsPassees->count() }} passée(s)
                </p>
            </div>

            <!-- Évaluations à venir -->
            <div class="mb-8">
                <div class="flex items-center space-x-2 mb-3">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <h3 class="text-base font-bold text-gray-800">À venir</h3>
                    <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                        {{ $evaluationsAVenir->count() }}
                    </span>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Heure</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Matière</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($evaluationsAVenir as $evaluation)
                                <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-green-600">
                                            {{ $evaluation->date_evaluation->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-sm">
                                        {{ $evaluation->heure_debut }} - {{ $evaluation->heure_fin }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                            📚 {{ $evaluation->enseigner->matiere->nom }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 font-medium">{{ $evaluation->titre }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                                            {{ $evaluation->type }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                        <div class="text-3xl mb-2">📅</div>
                                        <p>Aucune évaluation à venir.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Évaluations passées -->
            <div>
                <div class="flex items-center space-x-2 mb-3">
                    <span class="w-3 h-3 bg-gray-400 rounded-full"></span>
                    <h3 class="text-base font-bold text-gray-800">Passées</h3>
                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">
                        {{ $evaluationsPassees->count() }}
                    </span>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Heure</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Matière</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($evaluationsPassees as $evaluation)
                                <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-gray-500 text-sm">
                                        {{ $evaluation->date_evaluation->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-sm">
                                        {{ $evaluation->heure_debut }} - {{ $evaluation->heure_fin }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                            📚 {{ $evaluation->enseigner->matiere->nom }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $evaluation->titre }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">
                                            {{ $evaluation->type }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                        <div class="text-3xl mb-2">📅</div>
                                        <p>Aucune évaluation passée.</p>
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