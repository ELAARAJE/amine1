@extends('layouts.public')

@section('title', 'Mentions légales')
@section('description', 'Mentions légales du site Le Birlik — restaurant gastronomique.')

@section('content')

{{-- Page header --}}
<div class="bg-birlik-black pt-20">
    <div class="py-16 md:py-24 text-center">
        <p class="text-birlik-gold uppercase tracking-widest text-xs mb-4 font-light">Informations légales</p>
        <h1 class="font-playfair text-4xl md:text-5xl text-white font-semibold">Mentions légales</h1>
        <div class="w-12 h-px bg-birlik-gold mx-auto mt-6"></div>
    </div>
</div>

<div class="bg-birlik-cream py-16 md:py-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed space-y-10">

            {{-- ─────────────────────────────────────────────────────────────────────
                 TODO: Compléter les informations ci-dessous avec les vraies données
                 juridiques du restaurant Le Birlik avant la mise en ligne.
                 ───────────────────────────────────────────────────────────────────── --}}

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">1. Éditeur du site</h2>
                {{-- TODO: Remplacer par la raison sociale, forme juridique, capital, RCS, SIREN --}}
                <p>
                    Le site <strong>lebirlik.fr</strong> est édité par la société <strong>[Raison sociale]</strong>,
                    [Forme juridique] au capital de [Montant] €, immatriculée au Registre du Commerce et des Sociétés
                    de [Ville] sous le numéro [SIREN/RCS].
                </p>
                {{-- TODO: Adresse du siège social --}}
                <p>
                    Siège social : [Adresse complète du restaurant]<br>
                    Téléphone : [Numéro de téléphone]<br>
                    E-mail : <a href="mailto:contact@lebirlik.fr" class="text-birlik-gold">contact@lebirlik.fr</a>
                </p>
                {{-- TODO: Numéro de TVA si applicable --}}
                <p>Numéro de TVA intracommunautaire : [FR XX XXX XXX XXX]</p>
                {{-- TODO: Nom du directeur de la publication --}}
                <p>Directeur de la publication : [Nom du responsable légal]</p>
            </section>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">2. Hébergement</h2>
                {{-- TODO: Informations sur l'hébergeur (Hostinger) --}}
                <p>
                    Ce site est hébergé par :<br>
                    <strong>Hostinger International Ltd</strong><br>
                    61 Lordou Vironos Street, 6023 Larnaca, Chypre<br>
                    <a href="https://www.hostinger.fr" class="text-birlik-gold" target="_blank" rel="noopener noreferrer">www.hostinger.fr</a>
                </p>
            </section>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">3. Propriété intellectuelle</h2>
                {{-- TODO: Vérifier et compléter selon les besoins --}}
                <p>
                    L'ensemble du contenu de ce site (textes, photographies, illustrations, logos, vidéos) est la
                    propriété exclusive de [Raison sociale], sauf mention contraire. Toute reproduction,
                    représentation, modification, publication ou adaptation, totale ou partielle, de l'un
                    quelconque des éléments du site, quel que soit le moyen ou le procédé utilisé, est interdite
                    sans l'autorisation écrite préalable de [Raison sociale].
                </p>
            </section>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">4. Responsabilité</h2>
                <p>
                    [Raison sociale] s'efforce d'assurer au mieux de ses possibilités l'exactitude et la mise à
                    jour des informations diffusées sur ce site. Cependant, [Raison sociale] ne peut garantir
                    l'exactitude, la précision ou l'exhaustivité des informations mises à disposition sur ce site.
                </p>
                <p>
                    [Raison sociale] décline toute responsabilité pour toute imprécision, inexactitude ou omission
                    portant sur des informations disponibles sur ce site et pour tout dommage résultant d'une
                    intrusion frauduleuse d'un tiers ayant entraîné une modification des informations mises à
                    disposition sur ce site.
                </p>
            </section>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">5. Cookies</h2>
                {{-- TODO: Détailler les cookies utilisés (session, analytics, etc.) --}}
                <p>
                    Ce site peut utiliser des cookies de session nécessaires au bon fonctionnement de
                    l'application. Pour plus d'informations sur la gestion de vos données personnelles et
                    l'utilisation des cookies, veuillez consulter notre
                    <a href="{{ route('legal.privacy') }}" class="text-birlik-gold">politique de confidentialité</a>.
                </p>
            </section>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">6. Droit applicable et juridiction compétente</h2>
                <p>
                    Les présentes mentions légales sont régies par la loi française. En cas de litige, les
                    tribunaux français seront seuls compétents.
                </p>
                {{-- TODO: Préciser le tribunal compétent si nécessaire --}}
            </section>

            <p class="text-sm text-gray-400 border-t border-gray-200 pt-6">
                {{-- TODO: Mettre à jour la date lors de chaque modification --}}
                Dernière mise à jour : [Date de mise à jour]
            </p>

        </div>
    </div>
</div>

@endsection
