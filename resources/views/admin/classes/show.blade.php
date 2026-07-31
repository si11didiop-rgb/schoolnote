<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Classe : {{ $classe->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex items-center justify-between">
                <div class="text-gray-600">
                    {{ $classe->niveau }} — {{ $classe->annee_scolaire }} —
                    <strong>Effectif : {{ $classe->afficherEffectif() }} élève(s)</strong>
                </div>
                <a href="{{ route('admin.classes.index') }}" class="text-sm text-indigo-600 hover:underline">
                    ← Retour aux classes
                </a>
            </div>

            <!-- Publication des bulletins -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-gray-800 mb-3">Publication des bulletins</h3>
                <div class="flex space-x-4">

                    <!-- Semestre 1 -->
                    <form action="{{ route('admin.classes.bulletin.toggle', $classe) }}" method="POST">
                        @csrf
                        <input type="hidden" name="semestre" value="1">
                        <button type="submit"
                                class="px-4 py-2 rounded text-white {{ $classe->bulletin_s1_publie ? 'bg-red-500 hover:bg-red-600' : 'bg-green-600 hover:bg-green-700' }}">
                            {{ $classe->bulletin_s1_publie ? '🔒 Masquer Semestre 1' : '✅ Publier Semestre 1' }}
                        </button>
                    </form>

                    <!-- Semestre 2 -->
                    <form action="{{ route('admin.classes.bulletin.toggle', $classe) }}" method="POST">
                        @csrf
                        <input type="hidden" name="semestre" value="2">
                        <button type="submit"
                                class="px-4 py-2 rounded text-white {{ $classe->bulletin_s2_publie ? 'bg-red-500 hover:bg-red-600' : 'bg-green-600 hover:bg-green-700' }}">
                            {{ $classe->bulletin_s2_publie ? '🔒 Masquer Semestre 2' : '✅ Publier Semestre 2' }}
                        </button>
                    </form>
                </div>

                <div class="mt-3 text-sm text-gray-500">
                    Semestre 1 :
                    <span class="{{ $classe->bulletin_s1_publie ? 'text-green-600 font-semibold' : 'text-red-500' }}">
                        {{ $classe->bulletin_s1_publie ? 'Visible' : 'Masqué' }}
                    </span>
                    &nbsp;|&nbsp;
                    Semestre 2 :
                    <span class="{{ $classe->bulletin_s2_publie ? 'text-green-600 font-semibold' : 'text-red-500' }}">
                        {{ $classe->bulletin_s2_publie ? 'Visible' : 'Masqué' }}
                    </span>
                </div>
            </div>

            <!-- Recherche et tri -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
                <form action="{{ route('admin.classes.show', $classe) }}" method="GET" class="flex items-center space-x-4">
                    <input type="text" name="recherche" value="{{ $recherche }}"
                           placeholder="Rechercher un élève (nom ou prénom)"
                           class="flex-1 border-gray-300 rounded-md shadow-sm">
                    <input type="hidden" name="tri" value="{{ $tri }}">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Rechercher
                    </button>
                </form>

                <div class="mt-3 text-sm space-x-3">
                    <span class="text-gray-600">Trier par :</span>
                    <a href="{{ route('admin.classes.show', ['classe' => $classe, 'tri' => 'nom', 'recherche' => $recherche]) }}"
                       class="{{ $tri === 'nom' ? 'font-bold text-indigo-600' : 'text-indigo-500' }} hover:underline">
                        Nom
                    </a>
                    <a href="{{ route('admin.classes.show', ['classe' => $classe, 'tri' => 'genre', 'recherche' => $recherche]) }}"
                       class="{{ $tri === 'genre' ? 'font-bold text-indigo-600' : 'text-indigo-500' }} hover:underline">
                        Genre
                    </a>
                </div>
            </div>

            <!-- Liste des élèves -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Nom</th>
                            <th class="px-4 py-2">Prénom</th>
                            <th class="px-4 py-2">Genre</th>
                            <th class="px-4 py-2">Date de naissance</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($eleves as $eleve)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $eleve->nom }}</td>
                                <td class="px-4 py-2">{{ $eleve->prenom }}</td>
                                <td class="px-4 py-2">
                                    {{ $eleve->genre === 'M' ? 'Masculin' : ($eleve->genre === 'F' ? 'Féminin' : '—') }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $eleve->date_de_naissance?->format('d/m/Y') ?? '—' }}
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.comptes.edit', $eleve) }}"
                                       class="text-indigo-600 hover:underline">Modifier</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-gray-500">
                                    Aucun élève trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>