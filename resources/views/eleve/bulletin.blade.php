<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mon bulletin
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Sélecteur de semestre -->
            <div class="mb-6 flex space-x-2">
                <a href="{{ route('eleve.bulletin', ['semestre' => 1]) }}"
                   class="px-5 py-2 rounded-lg font-medium transition {{ $semestre == 1 ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                    Semestre 1
                </a>
                <a href="{{ route('eleve.bulletin', ['semestre' => 2]) }}"
                   class="px-5 py-2 rounded-lg font-medium transition {{ $semestre == 2 ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                    Semestre 2
                </a>
            </div>

            @if (! $publie)
                <div class="bg-white border border-orange-200 rounded-xl p-6">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="text-2xl">🔒</span>
                        <h3 class="font-semibold text-gray-800">Bulletin non disponible</h3>
                    </div>
                    <p class="text-gray-600">Le bulletin du semestre {{ $semestre }} n'est pas encore disponible.</p>
                    <p class="text-sm text-gray-400 mt-1">L'administration n'a pas encore publié les bulletins pour ce semestre.</p>
                </div>

            @elseif (! $complet)
                <div class="bg-white border border-yellow-200 rounded-xl p-6">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="text-2xl">⏳</span>
                        <h3 class="font-semibold text-gray-800">Bulletin en cours de finalisation</h3>
                    </div>
                    <p class="text-gray-600">Le bulletin du semestre {{ $semestre }} n'est pas encore complet.</p>
                    <p class="text-sm text-gray-400 mt-1">Toutes les notes n'ont pas encore été saisies par les enseignants.</p>
                </div>

            @else
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                    <!-- En-tête du bulletin -->
                    <div class="bg-indigo-600 text-white p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold">{{ Auth::user()->name }}</h3>
                                <p class="text-indigo-200 text-sm mt-1">
                                    {{ Auth::user()->classe->nom ?? '—' }} — Semestre {{ $semestre }} — Année 2025-2026
                                </p>
                            </div>
                            <div class="text-right">
                                @if ($rang)
                                    <div class="bg-white/20 rounded-lg px-4 py-2 text-center">
                                        <div class="text-2xl font-bold">{{ $rang['rang'] }}<sup class="text-sm">e</sup></div>
                                        <div class="text-indigo-200 text-xs">/ {{ $rang['total'] }} élèves</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tableau des moyennes -->
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Matière</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Coefficient</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Moyenne / 20</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Appréciation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($moyennesParMatiere as $matiereId => $ligne)
                                @php
                                    $moyenneColor = $ligne['moyenne'] >= 14 ? 'text-green-600' :
                                                   ($ligne['moyenne'] >= 10 ? 'text-yellow-600' : 'text-red-600');
                                    $appreciation = $appreciations[$matiereId] ?? null;
                                @endphp
                                <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        📚 {{ $ligne['matiere'] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">
                                            Coeff. {{ $ligne['coefficient'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-lg font-bold {{ $moyenneColor }}">
                                            {{ $ligne['moyenne'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 italic">
                                        {{ $appreciation ? $appreciation->appreciation : '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-indigo-200 bg-indigo-50">
                                <td class="px-6 py-4 font-bold text-indigo-800" colspan="2">
                                    Moyenne générale
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $generalColor = $moyenneGenerale >= 14 ? 'text-green-600' :
                                                       ($moyenneGenerale >= 10 ? 'text-yellow-600' : 'text-red-600');
                                    @endphp
                                    <span class="text-2xl font-bold {{ $generalColor }}">
                                        {{ $moyenneGenerale }}
                                    </span>
                                </td>
                                <td></td>
                            </tr>
                            <tr class="border-t border-indigo-100 bg-indigo-50">
                                <td class="px-6 py-4 font-bold text-indigo-800" colspan="2">
                                    Mention
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $mention = Auth::user()->getMention($moyenneGenerale);
                                        $mentionColor = match($mention) {
                                            'Très Bien'  => 'bg-green-100 text-green-800',
                                            'Bien'       => 'bg-blue-100 text-blue-800',
                                            'Assez Bien' => 'bg-yellow-100 text-yellow-800',
                                            'Passable'   => 'bg-orange-100 text-orange-800',
                                            default      => 'bg-red-100 text-red-800',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-sm font-bold {{ $mentionColor }}">
                                        {{ $mention }}
                                    </span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Bouton téléchargement -->
                    <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                        <a href="{{ route('eleve.bulletin.pdf', ['semestre' => $semestre]) }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">
                            ⬇️ Télécharger en PDF
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>