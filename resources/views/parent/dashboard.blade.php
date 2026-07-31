<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Espace Parent
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800">
                    Bonjour, {{ Auth::user()->prenom }} 👋
                </h3>
                <p class="text-gray-500 mt-1">Suivez les résultats de vos enfants.</p>
            </div>

            @forelse ($enfants as $enfant)
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-4 hover:shadow-md transition">

                    <!-- En-tête de la carte enfant -->
                    <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-xl">
                                🎓
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-lg">{{ $enfant->name }}</h3>
                                <p class="text-pink-200 text-sm">{{ $enfant->classe->nom ?? '—' }}</p>
                            </div>
                        </div>
                        <div class="text-pink-200 text-sm">
                            {{ $enfant->classe->annee_scolaire ?? '' }}
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="px-6 py-4 flex items-center space-x-4">
                        <a href="{{ route('parent.notes', $enfant) }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">
                            📝 Ses notes
                        </a>
                        <a href="{{ route('parent.bulletin', $enfant) }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">
                            📊 Son bulletin
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-gray-200 rounded-xl p-10 text-center text-gray-400">
                    <div class="text-4xl mb-2">👨‍👩‍👧</div>
                    <p>Aucun enfant rattaché à votre compte.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>