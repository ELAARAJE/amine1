@extends('layouts.public')

@section('title', 'Politique de confidentialité')
@section('description', 'Politique de confidentialité et gestion des données personnelles — Le Birlik.')

@section('content')

{{-- Page header --}}
<div class="bg-birlik-black pt-20">
    <div class="py-16 md:py-24 text-center">
        <p class="text-birlik-gold uppercase tracking-widest text-xs mb-4 font-light">RGPD</p>
        <h1 class="font-playfair text-4xl md:text-5xl text-white font-semibold">
            Politique de confidentialité
        </h1>
        <div class="w-12 h-px bg-birlik-gold mx-auto mt-6"></div>
    </div>
</div>

<div class="bg-birlik-cream py-16 md:py-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed space-y-10">

            {{-- ─────────────────────────────────────────────────────────────────────
                 TODO: Faire relire ce document par un juriste spécialisé RGPD avant
                 la mise en production. Compléter tous les champs [entre crochets].
                 ───────────────────────────────────────────────────────────────────── --}}

            <p>
                La présente politique de confidentialité explique comment [Raison sociale] collecte, utilise
                et protège les données personnelles des utilisateurs du site <strong>lebirlik.fr</strong>,
                conformément au Règlement Général sur la Protection des Données (RGPD – UE 2016/679) et
                à la loi Informatique et Libertés.
            </p>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">1. Responsable du traitement</h2>
                {{-- TODO: Compléter avec les coordonnées du responsable du traitement --}}
                <p>
                    Le responsable du traitement est :<br>
                    <strong>[Raison sociale]</strong><br>
                    [Adresse]<br>
                    E-mail : <a href="mailto:contact@lebirlik.fr" class="text-birlik-gold">contact@lebirlik.fr</a>
                </p>
                {{-- TODO: Désigner un DPO si obligatoire selon l'activité et le volume de données --}}
            </section>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">2. Données collectées</h2>
                <p>Nous collectons les données personnelles suivantes :</p>
                {{-- TODO: Vérifier et compléter selon les traitements réels --}}
                <ul class="list-disc pl-6 space-y-2 mt-3">
                    <li>
                        <strong>Création de compte</strong> : prénom, nom, adresse e-mail, numéro de téléphone,
                        mot de passe (chiffré).
                    </li>
                    <li>
                        <strong>Réservation en ligne</strong> : date, heure, nombre de convives, commentaires
                        éventuels (régimes alimentaires, allergies, occasions spéciales).
                    </li>
                    <li>
                        <strong>Navigation</strong> : données techniques (adresse IP, type de navigateur,
                        pages visitées) à des fins statistiques et de sécurité.
                    </li>
                    {{-- TODO: Ajouter tout autre traitement (newsletter, formulaire de contact, etc.) --}}
                </ul>
            </section>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">3. Finalités et bases légales</h2>
                {{-- TODO: Vérifier les bases légales appropriées --}}
                <div class="overflow-x-auto mt-3">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="border-b-2 border-birlik-gold/30">
                                <th class="text-left py-2 pr-4 text-birlik-black font-semibold">Finalité</th>
                                <th class="text-left py-2 text-birlik-black font-semibold">Base légale</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="py-3 pr-4">Gestion des comptes clients et réservations</td>
                                <td class="py-3">Exécution du contrat (art. 6.1.b RGPD)</td>
                            </tr>
                            <tr>
                                <td class="py-3 pr-4">Sécurité et lutte contre la fraude</td>
                                <td class="py-3">Intérêt légitime (art. 6.1.f RGPD)</td>
                            </tr>
                            <tr>
                                <td class="py-3 pr-4">Statistiques de fréquentation anonymisées</td>
                                <td class="py-3">Intérêt légitime (art. 6.1.f RGPD)</td>
                            </tr>
                            {{-- TODO: Ajouter les autres finalités (newsletter = consentement, etc.) --}}
                        </tbody>
                    </table>
                </div>
            </section>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">4. Durée de conservation</h2>
                {{-- TODO: Préciser les durées selon les recommandations CNIL --}}
                <ul class="list-disc pl-6 space-y-2 mt-3">
                    <li>
                        <strong>Données de compte</strong> : conservées pendant toute la durée d'activité du compte,
                        puis [X] an(s) après la dernière activité ou la suppression du compte.
                    </li>
                    <li>
                        <strong>Données de réservation</strong> : [X] an(s) à compter de la réservation,
                        pour des raisons comptables et légales.
                    </li>
                    <li>
                        <strong>Logs de connexion</strong> : [X] mois conformément aux obligations légales.
                    </li>
                </ul>
            </section>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">5. Partage des données</h2>
                {{-- TODO: Lister les sous-traitants (hébergeur, prestataire email, paiement, etc.) --}}
                <p>
                    Vos données personnelles ne sont pas vendues ni cédées à des tiers.
                    Elles peuvent être transmises aux sous-traitants strictement nécessaires au fonctionnement
                    du service (hébergement, envoi d'e-mails transactionnels), dans le cadre de contrats
                    conformes au RGPD.
                </p>
                <p>
                    Aucun transfert de données hors de l'Union européenne n'est effectué sans garanties adéquates.
                </p>
            </section>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">6. Vos droits</h2>
                <p>Conformément au RGPD, vous disposez des droits suivants :</p>
                <ul class="list-disc pl-6 space-y-2 mt-3">
                    <li><strong>Droit d'accès</strong> : obtenir une copie de vos données personnelles.</li>
                    <li><strong>Droit de rectification</strong> : corriger des données inexactes ou incomplètes.</li>
                    <li><strong>Droit à l'effacement</strong> (« droit à l'oubli ») : demander la suppression de vos données, sous réserve des obligations légales.</li>
                    <li><strong>Droit à la limitation</strong> : restreindre le traitement dans certains cas.</li>
                    <li><strong>Droit à la portabilité</strong> : recevoir vos données dans un format structuré.</li>
                    <li><strong>Droit d'opposition</strong> : vous opposer à certains traitements fondés sur l'intérêt légitime.</li>
                </ul>
                <p class="mt-4">
                    Pour exercer ces droits, contactez-nous à
                    <a href="mailto:contact@lebirlik.fr" class="text-birlik-gold">contact@lebirlik.fr</a>.
                    Vous pouvez également supprimer votre compte directement depuis
                    <a href="{{ route('profile.edit') }}" class="text-birlik-gold">votre espace personnel</a>.
                </p>
                <p>
                    En cas de litige non résolu, vous pouvez introduire une réclamation auprès de la
                    <a href="https://www.cnil.fr" class="text-birlik-gold" target="_blank" rel="noopener noreferrer">CNIL</a>
                    (Commission Nationale de l'Informatique et des Libertés).
                </p>
            </section>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">7. Cookies</h2>
                {{-- TODO: Préciser les cookies déposés et la durée de conservation --}}
                <p>
                    Ce site utilise uniquement des cookies fonctionnels de session (authentification, sécurité
                    CSRF), nécessaires au bon fonctionnement de l'application. Ces cookies ne permettent pas
                    de vous suivre sur d'autres sites et ne sont pas partagés avec des tiers.
                </p>
                {{-- TODO: Ajouter une bannière de cookies si des cookies analytiques ou marketing sont ajoutés --}}
            </section>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">8. Sécurité</h2>
                <p>
                    Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger
                    vos données contre tout accès non autorisé, perte, altération ou divulgation : chiffrement
                    des mots de passe (bcrypt), connexions chiffrées (HTTPS), accès restreint aux données.
                </p>
            </section>

            <section>
                <h2 class="font-playfair text-2xl text-birlik-black mb-4">9. Modifications</h2>
                <p>
                    Nous nous réservons le droit de modifier cette politique à tout moment. Les utilisateurs
                    seront informés des modifications substantielles par e-mail ou via une notification sur le site.
                </p>
            </section>

            <p class="text-sm text-gray-400 border-t border-gray-200 pt-6">
                {{-- TODO: Mettre à jour la date lors de chaque modification --}}
                Dernière mise à jour : [Date de mise à jour]
            </p>

        </div>
    </div>
</div>

@endsection
