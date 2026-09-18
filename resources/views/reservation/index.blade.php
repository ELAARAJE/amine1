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

<div class="bg-birlik-cream py-6">
    <livewire:reservation-wizard />
</div>

@endsection
