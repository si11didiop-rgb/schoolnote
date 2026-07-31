<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Saisie des notes
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('enseignant.evaluations.index') }}"
                   class="text-sm text-indigo-600 hover:underline">
                    ← Retour aux évaluations
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center space-x-2">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                <!-- En-tête avec infos évaluation -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">📝 {{ $evaluation->titre }}</h3>
                    <div class="flex items-center space-x-4 mt-2 text-green-100 text-sm">
                        <span>📚 {{ $evaluation->enseigner->matiere->nom }}</span>
                        <span>🏫 {{ $evaluation->enseigner->classe->nom }}</span>
                        <span>📅 {{ $evaluation->date_evaluation->format('d/m/Y') }}</span>
                        <span>🕐 {{ $evaluation->heure_debut }} - {{ $evaluation->heure_fin }}</span>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('enseignant.notes.update', $evaluation) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4 flex items-center justify-between">
                            <p class="text-sm text-gray-500">
                                {{ $eleves->count() }} élève(s) — Notes sur 20 (par pas de 0.5)
                            </p>
                            <span class="text-xs text-gray-400">
                                Laissez vide si pas encore noté
                            </span>
                        </div>

                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Élève</th>
                                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Note / 20</th>
                                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($eleves as $eleve)
                                        @php
                                            $noteExistante = $notesExistantes[$eleve->id]->valeur ?? null;
                                        @endphp
                                        <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-sm">
                                                        {{ strtoupper(substr($eleve->prenom, 0, 1)) }}
                                                    </div>
                                                    <span class="font-medium text-gray-800">
                                                        {{ $eleve->prenom }} {{ $eleve->nom }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="number"
                                                       step="0.5"
                                                       min="0"
                                                       max="20"
                                                       name="notes[{{ $eleve->id }}]"
                                                       value="{{ old('notes.'.$eleve->id, $noteExistante) }}"
                                                       class="w-24 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                       placeholder="—">
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($noteExistante !== null)
                                                    @php
                                                        $color = $noteExistante >= 14 ? 'bg-green-100 text-green-700' :
                                                                ($noteExistante >= 10 ? 'bg-yellow-100 text-yellow-700' :
                                                                'bg-red-100 text-red-700');
                                                    @endphp
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                                        {{ $noteExistante }} / 20
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-500">
                                                        Non noté
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-10 text-center text-gray-400">
                                                <div class="text-3xl mb-2">👥</div>
                                                <p>Aucun élève dans cette classe.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                            <a href="{{ route('enseignant.evaluations.index') }}"
                               class="text-sm text-gray-500 hover:text-gray-700">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">
                                💾 Enregistrer les notes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>