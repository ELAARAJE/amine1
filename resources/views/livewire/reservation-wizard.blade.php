<div class="relative">

    {{-- Loading overlay --}}
    <div wire:loading.flex
         class="fixed inset-0 z-50 items-center justify-center bg-birlik-black/60 backdrop-blur-sm">
        <div class="flex flex-col items-center gap-3">
            <svg class="animate-spin h-8 w-8 text-birlik-gold" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"/>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            <span class="text-birlik-gold text-xs tracking-widest uppercase">Chargement…</span>
        </div>
    </div>

    @if($success)
    {{-- ─── Success ─────────────────────────────────────────────────────────── --}}
    <div class="max-w-lg mx-auto px-4 py-24 text-center">
        <div class="text-birlik-gold text-5xl mb-6 font-playfair">✦</div>
        <h2 class="font-playfair text-3xl text-birlik-black mb-4">Réservation confirmée</h2>
        <div class="w-12 h-px bg-birlik-gold mx-auto mb-8"></div>
        <p class="text-gray-500 leading-relaxed mb-10">
            Votre demande de réservation a bien été enregistrée.<br>
            Notre équipe vous confirmera votre table dans les plus brefs délais.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('reservation.history') }}"
               class="inline-block bg-birlik-gold text-white text-xs tracking-widest uppercase font-semibold px-8 py-3 hover:bg-birlik-gold-light transition-colors">
                Mes réservations
            </a>
            <a href="{{ route('home') }}"
               class="inline-block border border-birlik-gold/40 text-birlik-gold text-xs tracking-widest uppercase font-semibold px-8 py-3 hover:bg-birlik-gold hover:text-white transition-colors">
                Retour à l'accueil
            </a>
        </div>
    </div>

    @else

    {{-- ─── Step indicator ─────────────────────────────────────────────────── --}}
    <div class="max-w-xl mx-auto px-4 pt-12 pb-8">
        <div class="flex items-center justify-center">
            @foreach([1 => 'Date', 2 => 'Créneau', 3 => 'Couverts', 4 => 'Récapitulatif'] as $n => $label)
                @if($n > 1)
                <div class="flex-1 max-w-[4rem] h-px {{ $step >= $n ? 'bg-birlik-gold' : 'bg-gray-300' }} mx-1"></div>
                @endif
                <div class="flex flex-col items-center gap-1.5">
                    <div @class([
                        'w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold transition-colors',
                        'bg-birlik-gold text-white'         => $step >= $n,
                        'bg-gray-100 text-gray-400 border border-gray-300' => $step < $n,
                    ])>
                        @if($step > $n)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        @else
                            {{ $n }}
                        @endif
                    </div>
                    <span class="text-xs tracking-wider uppercase {{ $step === $n ? 'text-birlik-gold font-semibold' : 'text-gray-400' }} hidden sm:block">
                        {{ $label }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ─── Booking error banner ────────────────────────────────────────────── --}}
    @if($bookingError)
    <div class="max-w-2xl mx-auto px-4 mb-6">
        <div class="bg-red-50 border border-red-200 rounded text-red-700 text-sm px-4 py-3 flex items-start gap-3">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
            {{ $bookingError }}
        </div>
    </div>
    @endif

    {{-- ─── Step 1 : Calendrier ────────────────────────────────────────────── --}}
    @if($step === 1)
    <div class="max-w-md mx-auto px-4 pb-16">
        <h2 class="font-playfair text-2xl text-birlik-black text-center mb-8">
            Choisissez une date
        </h2>

        {{-- Month navigation --}}
        <div class="flex items-center justify-between mb-6">
            <button wire:click="prevMonth"
                    @disabled(!$canGoPrev)
                    class="w-10 h-10 flex items-center justify-center border border-birlik-gold/30 text-birlik-gold hover:bg-birlik-gold hover:text-white transition-colors rounded disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-transparent disabled:hover:text-birlik-gold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <span class="font-playfair text-xl text-birlik-black">{{ $calendarLabel }}</span>
            <button wire:click="nextMonth"
                    class="w-10 h-10 flex items-center justify-center border border-birlik-gold/30 text-birlik-gold hover:bg-birlik-gold hover:text-white transition-colors rounded">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        {{-- Day-of-week headers --}}
        <div class="grid grid-cols-7 mb-2">
            @foreach(['L', 'M', 'M', 'J', 'V', 'S', 'D'] as $d)
                <div class="text-center text-xs text-gray-400 font-semibold py-1">{{ $d }}</div>
            @endforeach
        </div>

        {{-- Calendar grid --}}
        <div class="space-y-1">
            @foreach($calendarDays as $week)
            <div class="grid grid-cols-7 gap-1">
                @foreach($week as $day)
                    @if($day['isAvailable'])
                        <button
                            wire:click="selectDate('{{ $day['date'] }}')"
                            @class([
                                'relative h-10 w-full text-sm font-medium rounded transition-colors focus:outline-none focus:ring-2 focus:ring-birlik-gold/40',
                                'bg-birlik-gold text-white shadow-sm'                         => $day['isSelected'],
                                'bg-birlik-gold/10 text-birlik-gold ring-1 ring-birlik-gold'  => $day['isToday'] && !$day['isSelected'],
                                'text-birlik-black hover:bg-birlik-gold/15 hover:text-birlik-gold' => !$day['isSelected'] && !$day['isToday'],
                            ])
                        >
                            {{ $day['day'] }}
                        </button>
                    @else
                        <span @class([
                            'h-10 w-full flex items-center justify-center text-sm rounded',
                            'text-gray-300'           => $day['isCurrentMonth'],
                            'text-gray-100'           => !$day['isCurrentMonth'],
                            'line-through'            => $day['isCurrentMonth'] && !$day['isToday'],
                        ])>{{ $day['day'] }}</span>
                    @endif
                @endforeach
            </div>
            @endforeach
        </div>

        <p class="text-center text-xs text-gray-400 mt-6 italic">
            Les jours grisés sont fermés ou déjà passés.
        </p>
    </div>
    @endif

    {{-- ─── Step 2 : Créneaux ──────────────────────────────────────────────── --}}
    @if($step === 2)
    <div class="max-w-2xl mx-auto px-4 pb-16">
        <div class="flex items-center justify-between mb-8">
            <button wire:click="backToDate"
                    class="flex items-center gap-2 text-sm text-gray-500 hover:text-birlik-gold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Choisir une autre date
            </button>
            @if($formattedDate)
            <span class="font-playfair text-birlik-black text-lg">{{ $formattedDate }}</span>
            @endif
        </div>

        @forelse($slotsGrouped as $serviceLabel => $slots)
        <div class="mb-10">
            <h3 class="flex items-center gap-3 font-playfair text-xl text-birlik-black mb-5">
                <span class="w-8 h-px bg-birlik-gold flex-shrink-0"></span>
                {{ $serviceLabel }}
            </h3>
            <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                @foreach($slots as $slot)
                    @if($slot['remaining'] > 0)
                    <button
                        wire:click="selectTime('{{ $slot['time'] }}')"
                        @class([
                            'p-3 text-center border rounded transition-colors focus:outline-none focus:ring-2 focus:ring-birlik-gold/40',
                            'border-birlik-gold bg-birlik-gold text-white shadow-sm' => $selectedTime === $slot['time'],
                            'border-birlik-gold/40 text-birlik-black hover:border-birlik-gold hover:bg-birlik-gold/8' => $selectedTime !== $slot['time'],
                        ])
                    >
                        <div class="font-semibold text-base">{{ $slot['time'] }}</div>
                        <div class="text-xs mt-1 {{ $selectedTime === $slot['time'] ? 'text-white/80' : 'text-gray-500' }}">
                            {{ $slot['remaining'] }}&thinsp;place{{ $slot['remaining'] > 1 ? 's' : '' }}
                        </div>
                    </button>
                    @else
                    <div class="p-3 text-center border border-gray-200 rounded bg-gray-50 opacity-50 cursor-not-allowed">
                        <div class="font-semibold text-base text-gray-400">{{ $slot['time'] }}</div>
                        <div class="text-xs mt-1 text-gray-400">Complet</div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @empty
        <div class="text-center py-12">
            <p class="text-gray-500 mb-4">Aucun créneau disponible pour cette date.</p>
            <button wire:click="backToDate"
                    class="text-sm text-birlik-gold border border-birlik-gold/40 px-6 py-2 hover:bg-birlik-gold hover:text-white transition-colors">
                Choisir une autre date
            </button>
        </div>
        @endforelse
    </div>
    @endif

    {{-- ─── Step 3 : Couverts & commentaire ───────────────────────────────── --}}
    @if($step === 3)
    <div class="max-w-lg mx-auto px-4 pb-16">
        <div class="flex items-center justify-between mb-8">
            <button wire:click="backToSlots"
                    class="flex items-center gap-2 text-sm text-gray-500 hover:text-birlik-gold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Choisir un autre créneau
            </button>
            @if($formattedDate && $selectedTime)
            <span class="text-sm text-birlik-black font-medium">
                {{ $formattedDate }} · {{ $selectedTime }}
            </span>
            @endif
        </div>

        <h2 class="font-playfair text-2xl text-birlik-black text-center mb-10">
            Votre réservation
        </h2>

        <div class="space-y-8">
            {{-- Guests counter --}}
            <div>
                <label class="block text-sm font-semibold text-birlik-black uppercase tracking-wider mb-4">
                    Nombre de couverts
                </label>
                <div class="flex items-center gap-6">
                    <button wire:click="decrementGuests"
                            @disabled($guests <= 1)
                            class="w-12 h-12 border border-birlik-gold/40 rounded text-birlik-gold text-xl hover:bg-birlik-gold hover:text-white transition-colors disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-transparent disabled:hover:text-birlik-gold">
                        −
                    </button>
                    <span class="w-16 text-center font-playfair text-4xl text-birlik-black tabular-nums">
                        {{ $guests }}
                    </span>
                    <button wire:click="incrementGuests"
                            @disabled($guests >= $maxGuests)
                            class="w-12 h-12 border border-birlik-gold/40 rounded text-birlik-gold text-xl hover:bg-birlik-gold hover:text-white transition-colors disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-transparent disabled:hover:text-birlik-gold">
                        +
                    </button>
                    <span class="text-sm text-gray-400">/ {{ $maxGuests }} max</span>
                </div>
                @error('guests')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Comment --}}
            <div>
                <label for="comment"
                       class="block text-sm font-semibold text-birlik-black uppercase tracking-wider mb-2">
                    Commentaire
                    <span class="text-gray-400 text-xs normal-case font-normal ml-1">(facultatif)</span>
                </label>
                <p class="text-xs text-gray-400 mb-3">Allergies alimentaires, occasion spéciale, disposition de table…</p>
                <textarea
                    id="comment"
                    wire:model.lazy="comment"
                    rows="4"
                    maxlength="500"
                    placeholder="Ex : allergie aux noix, anniversaire, table près de la fenêtre…"
                    class="w-full border border-birlik-gold/30 rounded-sm px-4 py-3 text-sm text-birlik-black placeholder-gray-300 focus:outline-none focus:border-birlik-gold transition-colors resize-none"
                ></textarea>
                @error('comment')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button wire:click="goToSummary"
                        class="w-full bg-birlik-gold text-white text-sm tracking-widest uppercase font-semibold py-4 hover:bg-birlik-gold-light transition-colors">
                    Voir le récapitulatif →
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ─── Step 4 : Récapitulatif ─────────────────────────────────────────── --}}
    @if($step === 4)
    <div class="max-w-lg mx-auto px-4 pb-16">
        <button wire:click="backToDetails"
                class="flex items-center gap-2 text-sm text-gray-500 hover:text-birlik-gold transition-colors mb-8">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Modifier
        </button>

        <h2 class="font-playfair text-2xl text-birlik-black text-center mb-8">
            Récapitulatif
        </h2>

        <div class="border border-birlik-gold/30 rounded-sm divide-y divide-birlik-gold/20 mb-8">
            <div class="flex justify-between items-center px-6 py-4">
                <span class="text-xs uppercase tracking-widest text-gray-400">Date</span>
                <span class="font-medium text-birlik-black">{{ $formattedDate }}</span>
            </div>
            <div class="flex justify-between items-center px-6 py-4">
                <span class="text-xs uppercase tracking-widest text-gray-400">Heure</span>
                <span class="font-medium text-birlik-black">{{ $selectedTime }}</span>
            </div>
            <div class="flex justify-between items-center px-6 py-4">
                <span class="text-xs uppercase tracking-widest text-gray-400">Couverts</span>
                <span class="font-medium text-birlik-black">
                    {{ $guests }}&ensp;personne{{ $guests > 1 ? 's' : '' }}
                </span>
            </div>
            @if($comment)
            <div class="px-6 py-4">
                <span class="text-xs uppercase tracking-widest text-gray-400 block mb-1">Commentaire</span>
                <p class="text-sm text-birlik-black leading-relaxed">{{ $comment }}</p>
            </div>
            @endif
            <div class="flex justify-between items-center px-6 py-4 bg-birlik-gold/5">
                <span class="text-xs uppercase tracking-widest text-gray-400">Client</span>
                <span class="font-medium text-birlik-black">
                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                </span>
            </div>
        </div>

        <div class="bg-amber-50 border border-amber-200 rounded-sm px-4 py-3 mb-8 text-amber-700 text-xs leading-relaxed">
            Votre réservation sera en attente de confirmation par notre équipe.
            Vous recevrez une notification dès sa validation.
        </div>

        <button wire:click="submit"
                wire:loading.attr="disabled"
                wire:target="submit"
                class="w-full bg-birlik-gold text-white text-sm tracking-widest uppercase font-semibold py-4 hover:bg-birlik-gold-light transition-colors disabled:opacity-60 disabled:cursor-not-allowed">
            <span wire:loading.remove wire:target="submit">Confirmer la réservation</span>
            <span wire:loading wire:target="submit">Envoi en cours…</span>
        </button>
    </div>
    @endif

    @endif {{-- /success --}}
</div>
