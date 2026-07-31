<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bulletin de {{ $enfant->name }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('parent.dashboard') }}"
                   class="text-sm text-indigo-600 hover:underline">
                    ← Retour
                </a>

                <div class="flex space-x-2">
                    <a href="{{ route('parent.bulletin', ['enfant' => $enfant, 'semestre' => 1]) }}"
                       class="px-5 py-2 rounded-lg font-medium transition {{ $semestre == 1 ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                        Semestre 1
                    </a>
                    <a href="{{ route('parent.bulletin', ['enfant' => $enfant, 'semestre' => 2]) }}"
                       class="px-5 py-2 rounded-lg font-medium transition {{ $semestre == 2 ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                        Semestre 2
                    </a>
                </div>
            </div>

            @if (! $publie)
                <!-- Bulletin pas encore autorisé par l'admin -->
                <div class="bg-white border border-orange-200 rounded-xl p-6">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="text-2xl">🔒</span>
                        <h3 class="font-semibold text-gray-800">Bulletin non disponible</h3>
                    </div>
                    <p class="text-gray-600">Le bulletin du semestre {{ $semestre }} n'est pas encore disponible.</p>
                    <p class="text-sm text-gray-400 mt-1">L'administration n'a pas encore publié les bulletins pour ce semestre.</p>
                </div>

            @elseif (! $complet)
                <!-- Bulletin autorisé mais notes incomplètes -->
                <div class="bg-white border border-yellow-200 rounded-xl p-6">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="text-2xl">⏳</span>
                        <h3 class="font-semibold text-gray-800">Bulletin en cours de finalisation</h3>
                    </div>
                    <p class="text-gray-600">Le bulletin du semestre {{ $semestre }} n'est pas encore complet.</p>
                    <p class="text-sm text-gray-400 mt-1">Toutes les notes n'ont pas encore été saisies par les enseignants.</p>
                </div>

            @else
                <!-- Bulletin complet et publié -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                    <!-- En-tête du bulletin -->
                    <div class="bg-gradient-to-r from-pink-500 to-pink-600 text-white p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold">{{ $enfant->name }}</h3>
                                <p class="text-pink-200 text-sm mt-1">
                                    {{ $enfant->classe->nom ?? '—' }} — Semestre {{ $semestre }} — Année 2025-2026
                                </p>
                            </div>
                            <div class="text-right">
                                @if ($rang)
                                    <div class="bg-white/20 rounded-lg px-4 py-2 text-center">
                                        <div class="text-2xl font-bold">{{ $rang['rang'] }}<sup class="text-sm">e</sup></div>
                                        <div class="text-pink-200 text-xs">/ {{ $rang['total'] }} élèves</div>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($moyennesParMatiere as $ligne)
                                @php
                                    $moyenneColor = $ligne['moyenne'] >= 14 ? 'text-green-600' :
                                                   ($ligne['moyenne'] >= 10 ? 'text-yellow-600' : 'text-red-600');
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
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-pink-200 bg-pink-50">
                                <td class="px-6 py-4 font-bold text-pink-800" colspan="2">
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
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>