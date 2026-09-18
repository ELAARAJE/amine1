<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Le Birlik') — Restaurant gastronomique</title>
    <meta name="description" content="@yield('description', 'Le Birlik, restaurant gastronomique. Réservez votre table en ligne et découvrez notre carte.')">

    <!-- Fonts: Playfair Display + Lato -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,400i,500,600,700&family=lato:300,400,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-lato antialiased bg-birlik-cream text-birlik-black">

    {{-- ─── Header ─── --}}
    <header
        x-data="{ open: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 60 })"
        class="fixed top-0 left-0 right-0 z-50"
    >
        <div
            :class="scrolled ? 'bg-birlik-black/95 shadow-lg backdrop-blur-sm' : 'bg-transparent'"
            class="transition-all duration-400"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">

                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex-shrink-0">
                        <span class="font-playfair text-2xl font-bold text-birlik-gold tracking-widest2 uppercase">
                            Le Birlik
                        </span>
                    </a>

                    {{-- Desktop navigation --}}
                    <nav class="hidden md:flex items-center gap-8">
                        <a href="{{ route('home') }}"
                           class="text-white/80 hover:text-birlik-gold transition-colors text-xs tracking-widest uppercase font-light
                                  {{ request()->routeIs('home') ? 'text-birlik-gold' : '' }}">
                            Accueil
                        </a>
                        <a href="{{ route('menu') }}"
                           class="text-white/80 hover:text-birlik-gold transition-colors text-xs tracking-widest uppercase font-light
                                  {{ request()->routeIs('menu') ? 'text-birlik-gold' : '' }}">
                            Menu
                        </a>
                        <a href="{{ route('events.index') }}"
                           class="text-white/80 hover:text-birlik-gold transition-colors text-xs tracking-widest uppercase font-light
                                  {{ request()->routeIs('events.*') ? 'text-birlik-gold' : '' }}">
                            Événements
                        </a>
                        <a href="{{ route('reservation.create') }}"
                           class="bg-birlik-gold hover:bg-birlik-gold-light text-white text-xs tracking-widest uppercase font-semibold px-5 py-2.5 transition-colors">
                            Réserver
                        </a>
                        @auth
                            <a href="{{ route('reservation.history') }}"
                               class="text-white/80 hover:text-birlik-gold transition-colors text-xs tracking-widest uppercase font-light
                                      {{ request()->routeIs('reservation.history') ? 'text-birlik-gold' : '' }}">
                                Mes réservations
                            </a>
                            <a href="{{ route('dashboard') }}"
                               class="text-white/80 hover:text-birlik-gold transition-colors text-xs tracking-widest uppercase font-light">
                                Mon compte
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="text-white/80 hover:text-birlik-gold transition-colors text-xs tracking-widest uppercase font-light">
                                Mon compte
                            </a>
                        @endauth
                    </nav>

                    {{-- Mobile hamburger --}}
                    <button @click="open = !open"
                            class="md:hidden text-white p-2 focus:outline-none"
                            aria-label="Ouvrir le menu">
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Mobile navigation --}}
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="md:hidden bg-birlik-black/95 border-t border-white/10 pb-6"
                     x-cloak>
                    <nav class="flex flex-col pt-4 px-4 space-y-1">
                        <a href="{{ route('home') }}"
                           class="text-white/80 hover:text-birlik-gold py-3 text-sm tracking-widest uppercase font-light border-b border-white/5">
                            Accueil
                        </a>
                        <a href="{{ route('menu') }}"
                           class="text-white/80 hover:text-birlik-gold py-3 text-sm tracking-widest uppercase font-light border-b border-white/5">
                            Menu
                        </a>
                        <a href="{{ route('events.index') }}"
                           class="text-white/80 hover:text-birlik-gold py-3 text-sm tracking-widest uppercase font-light border-b border-white/5">
                            Événements
                        </a>
                        @auth
                            <a href="{{ route('reservation.history') }}"
                               class="text-white/80 hover:text-birlik-gold py-3 text-sm tracking-widest uppercase font-light border-b border-white/5
                                      {{ request()->routeIs('reservation.history') ? 'text-birlik-gold' : '' }}">
                                Mes réservations
                            </a>
                            <a href="{{ route('dashboard') }}"
                               class="text-white/80 hover:text-birlik-gold py-3 text-sm tracking-widest uppercase font-light border-b border-white/5">
                                Mon compte
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="text-white/80 hover:text-birlik-gold py-3 text-sm tracking-widest uppercase font-light border-b border-white/5">
                                Mon compte
                            </a>
                        @endauth
                        <div class="pt-3">
                            <a href="{{ route('reservation.create') }}"
                               class="block text-center bg-birlik-gold text-white text-sm tracking-widest uppercase font-semibold py-3">
                                Réserver une table
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    {{-- ─── Main content ─── --}}
    <main>
        @yield('content')
    </main>

    {{-- ─── Footer ─── --}}
    <footer class="bg-birlik-black text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-16">

                {{-- Address --}}
                <div>
                    <h3 class="font-playfair text-lg text-birlik-gold mb-5 tracking-wide">Le Birlik</h3>
                    <address class="not-italic text-white/60 text-sm leading-loose">
                        {{-- TODO: Replace with actual restaurant address --}}
                        123 Rue de la Gastronomie<br>
                        75001 Paris<br>
                        <br>
                        <a href="tel:+33100000000"
                           class="hover:text-birlik-gold transition-colors">
                            +33 1 00 00 00 00
                        </a><br>
                        <a href="mailto:contact@lebirlik.fr"
                           class="hover:text-birlik-gold transition-colors">
                            contact@lebirlik.fr
                        </a>
                    </address>
                </div>

                {{-- Opening hours (dynamic from DB) --}}
                <div>
                    <h3 class="font-playfair text-lg text-birlik-gold mb-5 tracking-wide">Horaires</h3>
                    @if(isset($footerOpeningHours) && $footerOpeningHours->isNotEmpty())
                        <dl class="text-sm space-y-1.5">
                            @foreach($footerDayNames as $dayNum => $dayLabel)
                                @php
                                    $services = $footerOpeningHours->get($dayNum, collect());
                                    $openServices = $services->filter(fn($s) => $s->is_open);
                                @endphp
                                <div class="flex justify-between gap-3">
                                    <dt class="text-white/70 w-24 flex-shrink-0">{{ $dayLabel }}</dt>
                                    <dd class="text-right">
                                        @if($openServices->isEmpty())
                                            <span class="text-white/30 italic text-xs">Fermé</span>
                                        @else
                                            <span class="text-white/80">
                                                @foreach($openServices as $service)
                                                    {{ substr($service->start_time, 0, 5) }}–{{ substr($service->end_time, 0, 5) }}@if(!$loop->last) &amp; @endif
                                                @endforeach
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    @else
                        <p class="text-white/40 text-sm italic">Horaires bientôt disponibles</p>
                    @endif
                </div>

                {{-- Links --}}
                <div>
                    <h3 class="font-playfair text-lg text-birlik-gold mb-5 tracking-wide">Informations</h3>
                    <ul class="text-sm space-y-2.5">
                        <li>
                            <a href="{{ route('menu') }}"
                               class="text-white/60 hover:text-birlik-gold transition-colors">
                                Notre carte
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('events.index') }}"
                               class="text-white/60 hover:text-birlik-gold transition-colors">
                                Événements
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reservation.create') }}"
                               class="text-white/60 hover:text-birlik-gold transition-colors">
                                Réserver une table
                            </a>
                        </li>
                        <li class="pt-2 border-t border-white/10">
                            <a href="{{ route('legal.mentions') }}"
                               class="text-white/40 hover:text-white/70 transition-colors text-xs">
                                Mentions légales
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('legal.privacy') }}"
                               class="text-white/40 hover:text-white/70 transition-colors text-xs">
                                Politique de confidentialité
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-14 pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4 text-white/30 text-xs">
                <p>© {{ date('Y') }} Le Birlik — Tous droits réservés</p>
                <p class="italic font-playfair">L'abus d'alcool est dangereux pour la santé. À consommer avec modération.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
