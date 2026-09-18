@extends('layouts.public')

@section('title', $event->title)
@section('description', Str::limit($event->description, 160))

@section('content')

{{-- ─── Hero with event image ─── --}}
<div class="bg-birlik-black pt-20">
    <div class="relative py-24 md:py-36 overflow-hidden">
        {{--
            TODO: Afficher l'image si présente :
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}"
                     class="absolute inset-0 w-full h-full object-cover opacity-25"
                     alt="{{ $event->title }}">
            @endif
        --}}
        <div class="absolute inset-0 bg-gradient-to-b from-birlik-black/60 via-birlik-black/40 to-birlik-black/90"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(184,151,42,0.07)_0%,_transparent_65%)]"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 text-center">
            <div class="inline-block bg-birlik-gold text-white text-xs tracking-widest uppercase font-semibold px-4 py-2 mb-6">
                Événement
            </div>
            <time class="block text-birlik-gold/80 text-sm mb-4">
                {{ $event->starts_at->translatedFormat('l d F Y') }} à {{ $event->starts_at->format('H\hi') }}
            </time>
            <h1 class="font-playfair text-4xl md:text-6xl text-white font-semibold leading-tight mb-6">
                {{ $event->title }}
            </h1>
            <div class="w-12 h-px bg-birlik-gold mx-auto"></div>
        </div>
    </div>
</div>

{{-- ─── Event detail ─── --}}
<section class="bg-birlik-cream py-20 md:py-28">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Meta bar --}}
        <div class="flex flex-wrap items-center gap-x-8 gap-y-3 mb-12 pb-8 border-b border-birlik-black/10">
            <div>
                <span class="text-xs text-gray-400 uppercase tracking-wider block mb-0.5">Date</span>
                <span class="text-birlik-black font-medium text-sm">
                    {{ $event->starts_at->translatedFormat('d F Y') }}
                </span>
            </div>
            <div>
                <span class="text-xs text-gray-400 uppercase tracking-wider block mb-0.5">Heure</span>
                <span class="text-birlik-black font-medium text-sm">
                    {{ $event->starts_at->format('H\hi') }}
                </span>
            </div>
            @if($event->price)
            <div>
                <span class="text-xs text-gray-400 uppercase tracking-wider block mb-0.5">Tarif</span>
                <span class="text-birlik-gold font-playfair font-semibold text-lg">
                    {{ number_format($event->price, 2, ',', '\u{202F}') }} € / personne
                </span>
            </div>
            @endif
        </div>

        {{-- Description --}}
        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed mb-16">
            {!! nl2br(e($event->description)) !!}
        </div>

        {{-- CTA --}}
        <div class="bg-birlik-black text-white p-10 text-center">
            <p class="font-playfair text-2xl mb-2">Réservez votre place</p>
            <p class="text-white/50 text-sm mb-7">
                Les places sont limitées — réservez dès maintenant pour ne pas manquer cet événement.
            </p>
            <a href="{{ route('reservation.create') }}"
               class="inline-block bg-birlik-gold hover:bg-birlik-gold-light text-white
                      text-xs tracking-widest2 uppercase font-semibold px-10 py-4
                      transition-colors duration-300">
                Réserver une table
            </a>
        </div>

        {{-- Back link --}}
        <div class="mt-12 text-center">
            <a href="{{ route('events.index') }}"
               class="text-xs tracking-widest uppercase text-birlik-black/40 hover:text-birlik-gold transition-colors">
                ← Tous les événements
            </a>
        </div>
    </div>
</section>

@endsection
