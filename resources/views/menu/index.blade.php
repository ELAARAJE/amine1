@extends('layouts.public')

@section('title', 'Notre carte')
@section('description', 'Découvrez la carte du Birlik : entrées, plats, desserts et boissons élaborés avec des produits de saison.')

@section('content')

{{-- ─── Page header ─── --}}
<div class="bg-birlik-black pt-20">
    <div class="py-20 md:py-28 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(184,151,42,0.07)_0%,_transparent_65%)]"></div>
        <div class="relative z-10">
            <p class="text-birlik-gold uppercase tracking-widest text-xs mb-4 font-light">Le Birlik</p>
            <h1 class="font-playfair text-5xl md:text-6xl text-white font-semibold">Notre carte</h1>
            <div class="w-12 h-px bg-birlik-gold mx-auto mt-6"></div>
        </div>
    </div>
</div>

{{-- ─── Menu content ─── --}}
<div class="bg-birlik-cream py-20 md:py-28">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @forelse($categories as $category)
        <section class="mb-20 last:mb-0">
            {{-- Category title --}}
            <div class="text-center mb-12">
                <h2 class="font-playfair text-3xl md:text-4xl text-birlik-black">
                    {{ $category->name }}
                </h2>
                <div class="flex items-center justify-center gap-6 mt-4">
                    <span class="flex-1 max-w-[100px] h-px bg-birlik-gold/40"></span>
                    <span class="text-birlik-gold text-lg">✦</span>
                    <span class="flex-1 max-w-[100px] h-px bg-birlik-gold/40"></span>
                </div>
            </div>

            {{-- Dishes --}}
            <div class="divide-y divide-birlik-black/8">
                @forelse($category->dishes as $dish)
                <div class="py-6 first:pt-0">
                    <div class="flex items-start justify-between gap-6">
                        <div class="flex-1">
                            <h3 class="font-playfair text-lg md:text-xl text-birlik-black mb-1">
                                {{ $dish->name }}
                            </h3>
                            @if($dish->description)
                                <p class="text-gray-500 text-sm leading-relaxed mb-3">
                                    {{ $dish->description }}
                                </p>
                            @endif
                            @if(!empty($dish->allergens))
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($dish->allergens as $allergen)
                                        <span class="text-xs text-birlik-gold/80 bg-birlik-gold/8 border border-birlik-gold/20 px-2 py-0.5 rounded-sm">
                                            {{ $allergen }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="flex-shrink-0 text-right">
                            <span class="font-playfair text-xl text-birlik-gold font-medium whitespace-nowrap">
                                {{ number_format($dish->price, 2, ',', '\u{202F}') }} €
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                    <p class="text-gray-400 text-sm italic text-center py-4">Plats à venir…</p>
                @endforelse
            </div>
        </section>
        @empty
            <p class="text-center text-gray-400 italic py-16">La carte sera bientôt disponible.</p>
        @endforelse

    </div>
</div>

{{-- ─── Reservation CTA ─── --}}
<section class="bg-birlik-cream-dark py-16 border-t border-birlik-black/5">
    <div class="text-center">
        <p class="text-gray-500 text-sm mb-5">
            Envie de découvrir notre carte autour d'une table ?
        </p>
        <a href="{{ route('reservation.create') }}"
           class="inline-block bg-birlik-gold hover:bg-birlik-gold-light text-white
                  text-xs tracking-widest2 uppercase font-semibold px-10 py-4
                  transition-colors duration-300">
            Réserver une table
        </a>
    </div>
</section>

@endsection
