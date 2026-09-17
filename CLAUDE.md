# Le Birlik — Site du restaurant gastronomique

## Contexte

Site web pour le restaurant gastronomique **Le Birlik** (domaine cible : `nomduresto.fr`).
Le site présente le restaurant, son menu et ses événements, permet aux clients de créer
un compte et de réserver une table en ligne avec disponibilités en temps réel, et fournit
un back-office pour que l'équipe valide/gère les réservations.

## Stack technique

- **Framework** : Laravel (dernière version stable)
- **Base de données** : MySQL
- **Templates** : Blade
- **CSS** : Tailwind CSS
- **Interactivité** : Livewire (composants dynamiques, ex. calendrier de disponibilités en temps réel)
- **Authentification** : Laravel Breeze (stack Blade)
- **Back-office / admin** : Filament (gestion et validation des réservations)
- **Hébergement cible** : Hostinger mutualisé (PHP 8.2+, accès SSH, cron)

## Conventions du projet

- **Code** (noms de variables, classes, méthodes, commentaires, commits) : **en anglais**.
- **Interface utilisateur** (texte affiché, libellés, messages, emails) : **en français**.
- **Dates** : affichées au **format français** (`d/m/Y`, ex. `17/09/2026`), via les helpers
  Carbon/Laravel localisés (`->translatedFormat('d F Y')` etc.).
- **Locale application** : `fr` (`config/app.php` → `locale` / `fallback_locale`).
- **Fuseau horaire** : `Europe/Paris` (`config/app.php` → `timezone`).
- Respecter les conventions Laravel standard (PSR-12, arrays/collections idiomatiques,
  Form Requests pour la validation, Policies pour les autorisations).

## Fonctionnalités principales

### Pages publiques
- Accueil (présentation du restaurant, mise en avant)
- Menu (plats, prix, catégories)
- Événements (soirées spéciales, menus événementiels)

### Comptes clients
- Inscription / connexion (Laravel Breeze)
- Espace client : historique et suivi des réservations

### Réservation
- Formulaire de réservation avec **disponibilités en temps réel** (Livewire)
- Gestion des créneaux, capacité des tables, contraintes horaires du service

### Back-office (Filament)
- Validation / refus des réservations par l'équipe du restaurant
- Gestion du menu, des événements et des créneaux disponibles
- Vue d'ensemble des réservations (calendrier / liste)

## Notes de développement

- Toujours privilégier les composants Livewire pour les interactions nécessitant du temps
  réel côté réservation (mise à jour des disponibilités sans rechargement de page).
- Les validations de formulaires métier (réservation, contact) doivent renvoyer des messages
  d'erreur en français.
- Prévoir les migrations et seeders pour les données de démonstration (menu, événements,
  créneaux) afin de faciliter les tests locaux.
- Le déploiement final se fait sur un hébergement mutualisé Hostinger : éviter les
  dépendances nécessitant des extensions PHP non standards ou un accès root serveur.
