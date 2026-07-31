<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes notes
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Mes notes</h3>
                    <p class="text-sm text-gray-500">{{ $notes->count() }} note(s) au total</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Matière</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Évaluation</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Note / 20</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notes as $note)
                            @php
                                // Coloration de la note selon le résultat
                                $valeur = $note->valeur;
                                $noteColor = $valeur >= 14 ? 'text-green-600 bg-green-50' :
                                            ($valeur >= 10 ? 'text-yellow-600 bg-yellow-50' :
                                            'text-red-600 bg-red-50');
                            @endphp
                            <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-500 text-sm">
                                    {{ $note->date_de_saisie->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                        📚 {{ $note->evaluation->enseigner->matiere->nom }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-800">
                                    {{ $note->evaluation->titre }}
                                    <span class="text-xs text-gray-400 ml-1">({{ $note->evaluation->type }})</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-bold {{ $noteColor }}">
                                        {{ $note->valeur }} / 20
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                    <div class="text-4xl mb-2">📝</div>
                                    <p>Aucune note pour le moment.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>