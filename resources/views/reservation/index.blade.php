@extends('layouts.public')

@section('title', 'Réservation')
@section('description', 'Réservez votre table au Birlik — restaurant gastronomique.')

@section('content')

<div class="bg-birlik-black pt-20">
    <div class="py-16 md:py-24 text-center">
        <p class="text-birlik-gold uppercase tracking-widest text-xs mb-4 font-light">Table</p>
        <h1 class="font-playfair text-4xl md:text-5xl text-white font-semibold">Réservation</h1>
        <div class="w-12 h-px bg-birlik-gold mx-auto mt-6"></div>
    </div>
</div>

<div class="bg-birlik-cream min-h-[50vh] flex items-center justify-center py-24">
    <div class="text-center max-w-lg mx-auto px-4">
        <div class="font-playfair text-5xl text-birlik-gold/30 mb-8">✦</div>
        <h2 class="font-playfair text-3xl text-birlik-black mb-4">
            Réservation en ligne
        </h2>
        <div class="w-12 h-px bg-birlik-gold mx-auto mb-8"></div>
        <p class="text-gray-500 leading-relaxed mb-8">
            La réservation en ligne sera bientôt disponible.<br>
            En attendant, contactez-nous directement par téléphone ou par e-mail.
        </p>
        <div class="space-y-3 mb-10 text-sm">
            <p>
                <a href="tel:+33100000000"
                   class="text-birlik-gold hover:text-birlik-gold-light font-medium transition-colors">
                    +33 1 00 00 00 00
                </a>
            </p>
            <p>
                <a href="mailto:contact@lebirlik.fr"
                   class="text-birlik-gold hover:text-birlik-gold-light font-medium transition-colors">
                    contact@lebirlik.fr
                </a>
            </p>
        </div>
        <a href="{{ route('home') }}"
           class="inline-block border border-birlik-gold/40 text-birlik-gold hover:bg-birlik-gold hover:text-white
                  text-xs tracking-widest uppercase font-semibold px-8 py-3 transition-colors">
            ← Retour à l'accueil
        </a>
    </div>
</div>

@endsection
