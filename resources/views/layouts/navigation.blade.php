<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::check() ? route('dashboard') : route('welcome') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">SN</span>
                        </div>
                        <span class="font-bold text-lg text-indigo-600">SchoolNote</span>
                    </a>
                </div>

                <!-- Navigation Links selon le rôle -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex items-center">

                    @php $role = Auth::check() ? Auth::user()->role : null; @endphp

                    @if (Auth::check())
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Dashboard
                        </x-nav-link>

                        {{-- MENU ADMINISTRATEUR --}}
                        @if ($role === 'administrateur')
                            <x-nav-link :href="route('admin.classes.index')" :active="request()->routeIs('admin.classes.*')">
                                Classes
                            </x-nav-link>
                            <x-nav-link :href="route('admin.matieres.index')" :active="request()->routeIs('admin.matieres.*')">
                                Matières
                            </x-nav-link>
                            <x-nav-link :href="route('admin.comptes.index')" :active="request()->routeIs('admin.comptes.*')">
                                Comptes
                            </x-nav-link>
                            <x-nav-link :href="route('admin.affectations.index')" :active="request()->routeIs('admin.affectations.*')">
                                Affectations
                            </x-nav-link>
                        @endif

                        {{-- MENU ENSEIGNANT --}}
                        @if ($role === 'enseignant')
                            <x-nav-link :href="route('enseignant.classes.index')" :active="request()->routeIs('enseignant.classes.*')">
                                Mes classes
                            </x-nav-link>
                            <x-nav-link :href="route('enseignant.matieres.index')" :active="request()->routeIs('enseignant.matieres.*')">
                                Mes matières
                            </x-nav-link>
                            <x-nav-link :href="route('enseignant.evaluations.index')" :active="request()->routeIs('enseignant.evaluations.*')">
                                Mes évaluations
                            </x-nav-link>
                        @endif

                        {{-- MENU ELEVE --}}
                        @if ($role === 'eleve')
                            <x-nav-link :href="route('eleve.notes')" :active="request()->routeIs('eleve.notes')">
                                Mes notes
                            </x-nav-link>
                            <x-nav-link :href="route('eleve.evaluations')" :active="request()->routeIs('eleve.evaluations')">
                                Mes évaluations
                            </x-nav-link>
                            <x-nav-link :href="route('eleve.bulletin')" :active="request()->routeIs('eleve.bulletin')">
                                Mon bulletin
                            </x-nav-link>
                        @endif

                        {{-- MENU PARENT --}}
                        @if ($role === 'parent')
                            <x-nav-link :href="route('parent.dashboard')" :active="request()->routeIs('parent.dashboard')">
                                Mes enfants
                            </x-nav-link>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if (Auth::check())
                    @php
                        $badgeColors = [
                            'administrateur' => 'bg-indigo-100 text-indigo-700',
                            'enseignant'     => 'bg-green-100 text-green-700',
                            'eleve'          => 'bg-yellow-100 text-yellow-700',
                            'parent'         => 'bg-pink-100 text-pink-700',
                        ];
                        $badgeColor = $badgeColors[Auth::user()->role] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <span class="mr-3 px-3 py-1 text-xs font-semibold rounded-full {{ $badgeColor }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-gray-200 text-sm leading-4 font-medium rounded-lg text-gray-600 bg-white hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                👤 Profil
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    🚪 Se déconnecter
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                        Se connecter
                    </a>
                @endif
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if (Auth::check())
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-responsive-nav-link>

                @php $role = Auth::check() ? Auth::user()->role : null; @endphp

                {{-- MENU MOBILE ADMINISTRATEUR --}}
                @if ($role === 'administrateur')
                    <x-responsive-nav-link :href="route('admin.classes.index')" :active="request()->routeIs('admin.classes.*')">
                        Classes
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.matieres.index')" :active="request()->routeIs('admin.matieres.*')">
                        Matières
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.comptes.index')" :active="request()->routeIs('admin.comptes.*')">
                        Comptes
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.affectations.index')" :active="request()->routeIs('admin.affectations.*')">
                        Affectations
                    </x-responsive-nav-link>
                @endif

                {{-- MENU MOBILE ENSEIGNANT --}}
                @if ($role === 'enseignant')
                    <x-responsive-nav-link :href="route('enseignant.classes.index')" :active="request()->routeIs('enseignant.classes.*')">
                        Mes classes
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('enseignant.matieres.index')" :active="request()->routeIs('enseignant.matieres.*')">
                        Mes matières
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('enseignant.evaluations.index')" :active="request()->routeIs('enseignant.evaluations.*')">
                        Mes évaluations
                    </x-responsive-nav-link>
                @endif

                {{-- MENU MOBILE ELEVE --}}
                @if ($role === 'eleve')
                    <x-responsive-nav-link :href="route('eleve.notes')" :active="request()->routeIs('eleve.notes')">
                        Mes notes
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('eleve.evaluations')" :active="request()->routeIs('eleve.evaluations')">
                        Mes évaluations
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('eleve.bulletin')" :active="request()->routeIs('eleve.bulletin')">
                        Mon bulletin
                    </x-responsive-nav-link>
                @endif

                {{-- MENU MOBILE PARENT --}}
                @if ($role === 'parent')
                    <x-responsive-nav-link :href="route('parent.dashboard')" :active="request()->routeIs('parent.dashboard')">
                        Mes enfants
                    </x-responsive-nav-link>
                @endif
            @endif
        </div>

        <!-- Responsive Settings Options -->
        @if (Auth::check())
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Profil
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            Se déconnecter
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endif
    </div>
</nav>