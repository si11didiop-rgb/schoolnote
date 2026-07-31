<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Classe : {{ $classe->nom }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $classe->nom }}</h3>
                    <p class="text-sm text-gray-500">
                        {{ $classe->niveau }} — {{ $classe->annee_scolaire }} —
                        <strong>{{ $classe->afficherEffectif() }} élève(s)</strong>
                    </p>
                </div>
                <a href="{{ route('enseignant.classes.index') }}"
                   class="text-sm text-indigo-600 hover:underline">
                    ← Retour à mes classes
                </a>
            </div>

            <!-- Recherche et tri -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 mb-4">
                <form action="{{ route('enseignant.classes.show', $classe) }}" method="GET"
                      class="flex items-center space-x-4">
                    <input type="text" name="recherche" value="{{ $recherche }}"
                           placeholder="Rechercher un élève (nom ou prénom)..."
                           class="flex-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <input type="hidden" name="tri" value="{{ $tri }}">
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        🔍 Rechercher
                    </button>
                </form>

                <div class="mt-3 text-sm space-x-3 flex items-center">
                    <span class="text-gray-500">Trier par :</span>
                    <a href="{{ route('enseignant.classes.show', ['classe' => $classe, 'tri' => 'nom', 'recherche' => $recherche]) }}"
                       class="px-3 py-1 rounded-full text-xs font-semibold transition {{ $tri === 'nom' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Nom
                    </a>
                    <a href="{{ route('enseignant.classes.show', ['classe' => $classe, 'tri' => 'genre', 'recherche' => $recherche]) }}"
                       class="px-3 py-1 rounded-full text-xs font-semibold transition {{ $tri === 'genre' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Genre
                    </a>
                </div>
            </div>

            <!-- Liste des élèves -->
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Élève</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Genre</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date de naissance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($eleves as $eleve)
                            <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-sm font-semibold text-indigo-600">
                                            {{ strtoupper(substr($eleve->prenom, 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-gray-800">
                                            {{ $eleve->prenom }} {{ $eleve->nom }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($eleve->genre === 'M')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">♂ Masculin</span>
                                    @elseif ($eleve->genre === 'F')
                                        <span class="px-2 py-1 bg-pink-100 text-pink-700 text-xs font-semibold rounded-full">♀ Féminin</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $eleve->date_de_naissance?->format('d/m/Y') ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-400">
                                    <div class="text-3xl mb-2">👥</div>
                                    <p>Aucun élève trouvé.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>