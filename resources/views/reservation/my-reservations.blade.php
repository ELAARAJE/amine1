@extends('layouts.public')

@section('title', 'Mes réservations')
@section('description', 'Consultez et gérez vos réservations au restaurant Le Birlik.')

@section('content')

<div class="bg-birlik-black pt-20">
    <div class="py-16 md:py-24 text-center">
        <p class="text-birlik-gold uppercase tracking-widest text-xs mb-4 font-light">Espace client</p>
        <h1 class="font-playfair text-4xl md:text-5xl text-white font-semibold">Mes réservations</h1>
        <div class="w-12 h-px bg-birlik-gold mx-auto mt-6"></div>
    </div>
</div>

<div class="bg-birlik-cream min-h-[50vh] py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">

        @if(session('success'))
        <div class="mb-8 bg-green-50 border border-green-200 rounded text-green-700 px-4 py-3 flex items-center gap-3 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="flex items-center justify-between mb-10">
            <h2 class="font-playfair text-2xl text-birlik-black">
                Bonjour, {{ auth()->user()->first_name }}
            </h2>
            <a href="{{ route('reservation.create') }}"
               class="bg-birlik-gold text-white text-xs tracking-widest uppercase font-semibold px-5 py-2.5 hover:bg-birlik-gold-light transition-colors">
                + Nouvelle réservation
            </a>
        </div>

        @forelse($reservations as $reservation)
        @php
            $isPast = \Carbon\Carbon::parse($reservation->date)
                ->setTimeFromTimeString($reservation->time)
                ->isPast();
            $canCancel = !$isPast && in_array($reservation->status, ['pending', 'confirmed']);
        @endphp

        <div class="bg-white border border-birlik-gold/20 rounded-sm mb-4 overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 px-6 py-5">

                {{-- Date badge --}}
                <div class="flex-shrink-0 w-16 text-center border-r border-birlik-gold/20 pr-5 hidden sm:block">
                    <div class="text-2xl font-playfair font-semibold text-birlik-black leading-none">
                        {{ $reservation->date->format('d') }}
                    </div>
                    <div class="text-xs text-gray-400 uppercase tracking-wider mt-1">
                        {{ $reservation->date->translatedFormat('M') }}
                    </div>
                    <div class="text-xs text-gray-300">
                        {{ $reservation->date->format('Y') }}
                    </div>
                </div>

                {{-- Details --}}
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mb-1">
                        <span class="font-playfair text-lg text-birlik-black sm:hidden">
                            {{ $reservation->date->translatedFormat('d F Y') }}
                        </span>
                        <span class="font-semibold text-birlik-black">
                            {{ \Carbon\Carbon::parse($reservation->time)->format('H\hi') }}
                        </span>
                        <span class="text-sm text-gray-500">
                            · {{ $reservation->guests }}&thinsp;couvert{{ $reservation->guests > 1 ? 's' : '' }}
                        </span>
                    </div>
                    @if($reservation->comment)
                    <p class="text-xs text-gray-400 truncate">{{ $reservation->comment }}</p>
                    @endif
                </div>

                {{-- Status badge --}}
                <div class="flex items-center gap-4 flex-shrink-0">
                    @php
                        $badgeClass = match($reservation->status) {
                            'confirmed' => 'bg-green-100 text-green-700 border-green-200',
                            'pending'   => 'bg-amber-100 text-amber-700 border-amber-200',
                            'cancelled' => 'bg-gray-100 text-gray-500 border-gray-200',
                            'refused'   => 'bg-red-100 text-red-700 border-red-200',
                            default     => 'bg-gray-100 text-gray-500 border-gray-200',
                        };
                        $badgeLabel = match($reservation->status) {
                            'confirmed' => 'Confirmée',
                            'pending'   => 'En attente',
                            'cancelled' => 'Annulée',
                            'refused'   => 'Refusée',
                            default     => $reservation->status,
                        };
                    @endphp
                    <span class="inline-block border text-xs font-semibold tracking-wider uppercase px-3 py-1 rounded-full {{ $badgeClass }}">
                        {{ $badgeLabel }}
                    </span>

                    @if($canCancel)
                    <div x-data="{ confirming: false }" class="flex items-center gap-2">
                        <button x-show="!confirming"
                                @click="confirming = true"
                                x-cloak
                                class="text-xs text-gray-400 hover:text-red-500 transition-colors border border-gray-200 hover:border-red-300 px-3 py-1 rounded">
                            Annuler
                        </button>
                        <div x-show="confirming" x-cloak class="flex items-center gap-2">
                            <span class="text-xs text-gray-500">Confirmer ?</span>
                            <form method="POST" action="{{ route('reservation.cancel', $reservation) }}">
                                @csrf
                                <button type="submit"
                                        class="text-xs font-semibold text-red-600 hover:underline">
                                    Oui
                                </button>
                            </form>
                            <button @click="confirming = false"
                                    class="text-xs text-gray-400 hover:underline">Non</button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($reservation->status === 'refused' && $reservation->rejection_reason)
            <div class="px-6 py-3 bg-red-50 border-t border-red-100 text-xs text-red-600">
                <strong>Motif :</strong> {{ $reservation->rejection_reason }}
            </div>
            @endif
        </div>
        @empty
        <div class="text-center py-20">
            <div class="font-playfair text-5xl text-birlik-gold/20 mb-6">✦</div>
            <p class="text-gray-500 mb-6">Vous n'avez aucune réservation pour le moment.</p>
            <a href="{{ route('reservation.create') }}"
               class="inline-block bg-birlik-gold text-white text-xs tracking-widest uppercase font-semibold px-8 py-3 hover:bg-birlik-gold-light transition-colors">
                Réserver une table
            </a>
        </div>
        @endforelse

        @if($reservations->hasPages())
        <div class="mt-8">
            {{ $reservations->links() }}
        </div>
        @endif

    </div>
</div>

@endsection
