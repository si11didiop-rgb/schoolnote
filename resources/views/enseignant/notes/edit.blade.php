<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Saisie des notes — {{ $evaluation->titre }}
            </h2>
            <a href="{{ route('enseignant.evaluations.index') }}"
               class="text-sm text-indigo-600 hover:underline">
                ← Retour aux évaluations
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Infos évaluation -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 mb-6">
                <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                    <span>📚 <strong>{{ $evaluation->enseigner->matiere->nom }}</strong></span>
                    <span>🏫 <strong>{{ $evaluation->enseigner->classe->nom }}</strong></span>
                    <span>📅 <strong>{{ \Carbon\Carbon::parse($evaluation->date_evaluation)->format('d/m/Y') }}</strong></span>
                    <span>🕐 <strong>{{ substr($evaluation->heure_debut, 0, 5) }} – {{ substr($evaluation->heure_fin, 0, 5) }}</strong></span>
                    <span>📝 <strong>{{ $evaluation->type }}</strong></span>
                    <span>📆 <strong>Semestre {{ $evaluation->semestre }}</strong></span>
                </div>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('enseignant.notes.update', $evaluation) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <div class="bg-indigo-600 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-white font-bold text-lg">
                            ✏️ {{ $eleves->count() }} élève(s) — Notes sur 20
                        </h3>
                        <span class="text-indigo-200 text-sm">Par pas de 0.5</span>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @foreach ($eleves as $eleve)
                            @php
                                $noteExistante         = $notesExistantes[$eleve->id] ?? null;
                                $appreciationExistante = $appreciationsExistantes[$eleve->id] ?? null;
                            @endphp

                            <div class="p-5">
                                <!-- Ligne élève + note -->
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-600">
                                            {{ strtoupper(substr($eleve->prenom, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $eleve->nom }} {{ $eleve->prenom }}</p>
                                            @if ($noteExistante)
                                                <p class="text-xs text-gray-400">Note actuelle : {{ $noteExistante->valeur }}/20</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <input
                                            type="number"
                                            name="notes[{{ $eleve->id }}]"
                                            value="{{ $noteExistante ? $noteExistante->valeur : '' }}"
                                            min="0" max="20" step="0.5"
                                            placeholder="—"
                                            class="w-24 text-center border border-gray-300 rounded-lg px-3 py-2 text-lg font-semibold focus:border-indigo-500 focus:ring-indigo-500"
                                        />
                                        <span class="text-gray-400 font-medium">/ 20</span>
                                    </div>
                                </div>

                                <!-- Appréciation -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">
                                        Appréciation (optionnelle — visible sur le bulletin)
                                    </label>
                                    <textarea
                                        name="appreciations[{{ $eleve->id }}]"
                                        rows="2"
                                        maxlength="500"
                                        placeholder="Ex : Bon travail, des progrès encourageants..."
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 resize-none"
                                    >{{ $appreciationExistante ? $appreciationExistante->appreciation : '' }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                        <a href="{{ route('enseignant.evaluations.index') }}"
                           class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                            Annuler
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                            💾 Enregistrer les notes et appréciations
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>