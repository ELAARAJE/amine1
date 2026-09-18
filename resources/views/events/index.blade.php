@extends('layouts.public')

@section('title', 'Événements')
@section('description', 'Soirées thématiques, menus événementiels, dégustations… Découvrez les prochains événements du Birlik.')

@section('content')

{{-- ─── Page header ─── --}}
<div class="bg-birlik-black pt-20">
    <div class="py-20 md:py-28 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(184,151,42,0.07)_0%,_transparent_65%)]"></div>
        <div class="relative z-10">
            <p class="text-birlik-gold uppercase tracking-widest text-xs mb-4 font-light">Agenda</p>
            <h1 class="font-playfair text-5xl md:text-6xl text-white font-semibold">Événements</h1>
            <div class="w-12 h-px bg-birlik-gold mx-auto mt-6"></div>
        </div>
    </div>
</div>

{{-- ─── Events list ─── --}}
<section class="bg-birlik-cream py-20 md:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @forelse($events as $event)
        <article class="group grid grid-cols-1 md:grid-cols-[280px_1fr] gap-0 bg-white shadow-sm
                        hover:shadow-lg transition-shadow duration-300 mb-8 last:mb-0 overflow-hidden">

            {{-- Image --}}
            <div class="relative overflow-hidden">
                {{--
                    TODO: Afficher l'image si présente :
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}"
                             class="w-full h-full min-h-[200px] object-cover group-hover:scale-105 transition-transform duration-500"
                             alt="{{ $event->title }}">
                    @else
                --}}
                <div class="w-full h-full min-h-[200px] bg-gradient-to-br from-stone-800 to-stone-900
                            flex flex-col items-center justify-center p-8 group-hover:opacity-90 transition-opacity">
                    <span class="font-playfair text-birlik-gold/40 italic text-sm">Le Birlik</span>
                </div>
                {{-- @endif --}}

                {{-- Date badge --}}
                <div class="absolute top-4 left-4 bg-birlik-gold text-white text-center px-3 py-2 leading-tight">
                    <div class="text-xl font-playfair font-semibold">
                        {{ $event->starts_at->format('d') }}
                    </div>
                    <div class="text-xs uppercase tracking-wider">
                        {{ $event->starts_at->translatedFormat('M Y') }}
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-8 md:p-10 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-4 mb-3">
                        <time class="text-birlik-gold text-xs tracking-widest uppercase font-light">
                            {{ $event->starts_at->translatedFormat('l d F Y') }} à {{ $event->starts_at->format('H\hi') }}
                        </time>
                    </div>
                    <h2 class="font-playfair text-2xl md:text-3xl text-birlik-black mb-4
                               group-hover:text-birlik-gold transition-colors leading-snug">
                        {{ $event->title }}
                    </h2>
                    <p class="text-gray-500 leading-relaxed text-sm md:text-base line-clamp-3">
                        {{ Str::limit($event->description, 200) }}
                    </p>
                </div>
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
                    @if($event->price)
                        <div>
                            <span class="text-xs text-gray-400 block mb-0.5">Par personne</span>
                            <span class="font-playfair text-xl text-birlik-gold font-medium">
                                {{ number_format($event->price, 2, ',', '\u{202F}') }} €
                            </span>
                        </div>
                    @else
                        <span></span>
                    @endif
                    <a href="{{ route('events.show', $event->slug) }}"
                       class="inline-flex items-center gap-2 text-xs tracking-widest uppercase font-semibold
                              text-birlik-black hover:text-birlik-gold transition-colors border-b border-transparent
                              hover:border-birlik-gold pb-0.5">
                        Découvrir
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </article>
        @empty
        <div class="text-center py-24">
            <div class="font-playfair text-4xl text-birlik-black/20 mb-4">✦</div>
            <p class="font-playfair text-2xl text-birlik-black/40 mb-3">Aucun événement à venir</p>
            <p class="text-gray-400 text-sm">Revenez bientôt pour découvrir nos prochaines soirées.</p>
            <div class="mt-8">
                <a href="{{ route('home') }}"
                   class="inline-block border border-birlik-gold/40 text-birlik-gold hover:bg-birlik-gold hover:text-white
                          text-xs tracking-widest uppercase font-semibold px-8 py-3 transition-colors">
                    Retour à l'accueil
                </a>
            </div>
        </div>
        @endforelse
    </div>
</section>

@endsection
