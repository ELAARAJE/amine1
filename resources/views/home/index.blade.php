@extends('layouts.public')

@section('title', 'Accueil')
@section('description', 'Le Birlik — restaurant gastronomique. Vivez une expérience culinaire d\'exception. Réservez votre table en ligne.')

@section('content')

{{-- ─── Hero ─── --}}
<section class="relative h-screen flex items-center justify-center overflow-hidden bg-birlik-black">

    {{--
        TODO: Remplacer le dégradé ci-dessous par la photo du restaurant :
        <img src="{{ asset('images/hero.jpg') }}" class="absolute inset-0 w-full h-full object-cover opacity-40" alt="">
    --}}
    <div class="absolute inset-0 bg-gradient-to-br from-stone-900 via-birlik-black to-stone-800"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(184,151,42,0.08)_0%,_transparent_70%)]"></div>

    {{-- Decorative frame --}}
    <div class="absolute inset-8 md:inset-16 border border-birlik-gold/15 pointer-events-none"></div>

    {{-- Hero content --}}
    <div class="relative z-10 text-center px-6 max-w-3xl">
        <p class="text-birlik-gold uppercase tracking-widest3 text-xs mb-8 font-light">
            Restaurant gastronomique
        </p>
        <h1 class="font-playfair text-6xl md:text-8xl text-white font-semibold mb-6 leading-none">
            Le Birlik
        </h1>
        <div class="w-12 h-px bg-birlik-gold mx-auto mb-8"></div>
        <p class="text-white/60 text-lg font-light mb-12 leading-relaxed">
            Une expérience culinaire d'exception,<br class="hidden sm:block">
            entre tradition et créativité
        </p>
        <a href="{{ route('reservation.create') }}"
           class="inline-block bg-birlik-gold hover:bg-birlik-gold-light text-white
                  text-xs tracking-widest2 uppercase font-semibold px-10 py-4
                  transition-colors duration-300">
            Réserver une table
        </a>
        <div class="mt-6">
            <a href="{{ route('menu') }}"
               class="text-white/40 hover:text-birlik-gold text-xs tracking-widest uppercase transition-colors">
                Découvrir la carte →
            </a>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/30 animate-bounce">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</section>

{{-- ─── Présentation ─── --}}
<section class="bg-birlik-cream py-24 md:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div>
                <p class="text-birlik-gold uppercase tracking-widest text-xs mb-4 font-light">Notre histoire</p>
                <h2 class="font-playfair text-4xl md:text-5xl text-birlik-black mb-6 leading-tight">
                    L'art de la table,<br>réinventé
                </h2>
                <div class="w-12 h-px bg-birlik-gold mb-8"></div>
                <div class="text-gray-600 space-y-4 text-base leading-relaxed">
                    <p>
                        Au cœur de Paris, le Birlik est un restaurant gastronomique qui invite
                        ses convives à une expérience sensorielle unique, où chaque plat raconte
                        une histoire de terroir et de passion.
                    </p>
                    <p>
                        Notre chef, fidèle aux grands classiques de la cuisine française, sublime
                        les produits de saison avec une touche de modernité et d'audace, pour offrir
                        une carte en perpétuelle évolution.
                    </p>
                    <p>
                        Du déjeuner en tête-à-tête au dîner de prestige, chaque moment au Birlik
                        se transforme en souvenir impérissable.
                    </p>
                </div>
                <div class="mt-10 flex gap-6">
                    <a href="{{ route('menu') }}"
                       class="inline-block border border-birlik-gold text-birlik-gold hover:bg-birlik-gold hover:text-white
                              text-xs tracking-widest uppercase font-semibold px-7 py-3 transition-colors duration-300">
                        Notre carte
                    </a>
                    <a href="{{ route('reservation.create') }}"
                       class="inline-block text-birlik-black hover:text-birlik-gold text-xs tracking-widest uppercase
                              font-semibold py-3 transition-colors duration-300 self-center">
                        Réserver →
                    </a>
                </div>
            </div>

            {{-- Decorative image placeholder --}}
            <div class="relative">
                {{--
                    TODO: Remplacer par une photo du restaurant :
                    <img src="{{ asset('images/restaurant.jpg') }}" class="w-full h-96 object-cover" alt="Le Birlik">
                --}}
                <div class="w-full h-96 bg-gradient-to-br from-stone-800 to-stone-900 flex items-center justify-center">
                    <span class="font-playfair text-birlik-gold/30 text-2xl italic">Photo du restaurant</span>
                </div>
                {{-- Decorative offset border --}}
                <div class="absolute -bottom-4 -right-4 w-full h-full border-2 border-birlik-gold/20 -z-10"></div>
            </div>
        </div>
    </div>
</section>

{{-- ─── Prochains événements ─── --}}
@if($upcomingEvents->isNotEmpty())
<section class="bg-birlik-cream-dark py-24 md:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-birlik-gold uppercase tracking-widest text-xs mb-4 font-light">Agenda</p>
            <h2 class="font-playfair text-4xl md:text-5xl text-birlik-black">Prochains événements</h2>
            <div class="w-12 h-px bg-birlik-gold mx-auto mt-6"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($upcomingEvents as $event)
            <article class="bg-white group hover:shadow-xl transition-shadow duration-300">
                {{--
                    TODO: Afficher l'image si présente :
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-48 object-cover" alt="{{ $event->title }}">
                    @else
                --}}
                <div class="w-full h-48 bg-gradient-to-br from-stone-800 to-stone-900 flex items-center justify-center overflow-hidden">
                    <span class="font-playfair text-birlik-gold/30 italic text-sm">Image à venir</span>
                </div>
                {{-- @endif --}}

                <div class="p-6">
                    <time class="text-birlik-gold text-xs tracking-widest uppercase font-light block mb-3">
                        {{ $event->starts_at->translatedFormat('d F Y') }}
                    </time>
                    <h3 class="font-playfair text-xl text-birlik-black mb-3 group-hover:text-birlik-gold transition-colors leading-snug">
                        {{ $event->title }}
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-5 line-clamp-3">
                        {{ Str::limit($event->description, 120) }}
                    </p>
                    <div class="flex items-center justify-between">
                        @if($event->price)
                            <span class="text-birlik-gold font-semibold text-sm">
                                {{ number_format($event->price, 2, ',', ' ') }} €
                            </span>
                        @else
                            <span class="text-white/0 text-sm">—</span>
                        @endif
                        <a href="{{ route('events.show', $event->slug) }}"
                           class="text-xs tracking-widest uppercase font-semibold text-birlik-black
                                  hover:text-birlik-gold transition-colors border-b border-birlik-black/20
                                  hover:border-birlik-gold pb-0.5">
                            En savoir plus →
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('events.index') }}"
               class="inline-block border border-birlik-black/30 hover:border-birlik-gold text-birlik-black hover:text-birlik-gold
                      text-xs tracking-widest uppercase font-semibold px-8 py-3 transition-colors duration-300">
                Voir tous les événements
            </a>
        </div>
    </div>
</section>
@endif

{{-- ─── CTA Réservation ─── --}}
<section class="bg-birlik-black py-24 md:py-32 relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(184,151,42,0.06)_0%,_transparent_70%)]"></div>
    <div class="relative z-10 text-center max-w-2xl mx-auto px-4">
        <p class="text-birlik-gold uppercase tracking-widest text-xs mb-4 font-light">Réservation</p>
        <h2 class="font-playfair text-4xl md:text-5xl text-white mb-6 leading-tight">
            Prêt à vivre<br>l'expérience ?
        </h2>
        <div class="w-12 h-px bg-birlik-gold mx-auto mb-8"></div>
        <p class="text-white/50 mb-10 leading-relaxed">
            Réservez votre table en quelques clics et préparez-vous à une soirée inoubliable.
        </p>
        <a href="{{ route('reservation.create') }}"
           class="inline-block bg-birlik-gold hover:bg-birlik-gold-light text-white
                  text-xs tracking-widest2 uppercase font-semibold px-12 py-4
                  transition-colors duration-300">
            Réserver une table
        </a>
    </div>
</section>

@endsection
