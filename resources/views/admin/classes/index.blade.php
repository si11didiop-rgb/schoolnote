<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des classes
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

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Liste des classes</h3>
                    <p class="text-sm text-gray-500">{{ $classes->count() }} classe(s) au total</p>
                </div>
                <a href="{{ route('admin.classes.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">
                    ➕ Ajouter une classe
                </a>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Niveau</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Année scolaire</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Effectif</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classes as $classe)
                            <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $classe->nom }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                                        {{ $classe->niveau }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $classe->annee_scolaire }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                        {{ $classe->afficherEffectif() }} élève(s)
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.classes.show', $classe) }}"
                                           class="text-sm text-green-600 hover:text-green-700 font-medium">
                                            👥 Élèves
                                        </a>
                                        <a href="{{ route('admin.classes.edit', $classe) }}"
                                           class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                            ✏️ Modifier
                                        </a>
                                        <form action="{{ route('admin.classes.destroy', $classe) }}"
                                              method="POST" class="inline"
                                              onsubmit="return confirm('Supprimer cette classe ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-sm text-red-500 hover:text-red-600 font-medium">
                                                🗑️ Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                    <div class="text-4xl mb-2">🏫</div>
                                    <p>Aucune classe pour le moment.</p>
                                    <a href="{{ route('admin.classes.create') }}" class="text-indigo-600 hover:underline text-sm mt-1 inline-block">
                                        Créer la première classe →
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>