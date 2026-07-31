<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes évaluations
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center space-x-2">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Mes évaluations</h3>
                    <p class="text-sm text-gray-500">
                        {{ $evaluationsAVenir->count() }} à venir —
                        {{ $evaluationsPassees->count() }} passée(s)
                    </p>
                </div>
                <a href="{{ route('enseignant.evaluations.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">
                    ➕ Planifier une évaluation
                </a>
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
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Matière</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Classe</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
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
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                            {{ $evaluation->enseigner->matiere->nom }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                                            {{ $evaluation->enseigner->classe->nom }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-800">{{ $evaluation->titre }}</td>
                                    <td class="px-6 py-4 text-gray-500 text-sm">{{ $evaluation->type }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('enseignant.notes.edit', $evaluation) }}"
                                               class="text-sm text-green-600 hover:text-green-700 font-medium">
                                                📝 Notes
                                            </a>
                                            <a href="{{ route('enseignant.evaluations.edit', $evaluation) }}"
                                               class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                                ✏️ Modifier
                                            </a>
                                            <form action="{{ route('enseignant.evaluations.destroy', $evaluation) }}"
                                                  method="POST" class="inline"
                                                  onsubmit="return confirm('Supprimer cette évaluation ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-sm text-red-500 hover:text-red-600 font-medium">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                        Aucune évaluation à venir.
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
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Matière</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Classe</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($evaluationsPassees as $evaluation)
                                <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $evaluation->date_evaluation->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                            {{ $evaluation->enseigner->matiere->nom }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                                            {{ $evaluation->enseigner->classe->nom }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-800">{{ $evaluation->titre }}</td>
                                    <td class="px-6 py-4 text-gray-500 text-sm">{{ $evaluation->type }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('enseignant.notes.edit', $evaluation) }}"
                                               class="text-sm text-green-600 hover:text-green-700 font-medium">
                                                📝 Notes
                                            </a>
                                            <a href="{{ route('enseignant.evaluations.edit', $evaluation) }}"
                                               class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                                ✏️ Modifier
                                            </a>
                                            <form action="{{ route('enseignant.evaluations.destroy', $evaluation) }}"
                                                  method="POST" class="inline"
                                                  onsubmit="return confirm('Supprimer cette évaluation ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-sm text-red-500 hover:text-red-600 font-medium">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                        Aucune évaluation passée.
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