
# Stage Project DQP

Projet Laravel complet pour la gestion des frais, étudiants, filières, spécialités, niveaux et paiements.

## Fonctionnalités principales

- Authentification sécurisée et gestion des rôles (admin, comptable, etc.)
- Tableau de bord responsive avec sidebar et header adaptatifs
- CRUD complet pour étudiants, filières, spécialités, niveaux et frais
- Filtrage et recherche avancée des étudiants (nom, email, sexe, année de naissance)
- Gestion des paiements et affichage du total (somme en bas de tableau)
- Pagination et affichage dynamique des listes
- Pages d’erreur personnalisées (404, etc.)
- Sécurité des routes selon le rôle utilisateur (middleware)
- Personnalisation facile du design (Blade + Tailwind CSS)

## Prérequis

- PHP >= 8.1
- Composer
- Node.js & npm
- Base de données MySQL/MariaDB

## Structure du projet

- `app/Http/Controllers/` : Contrôleurs principaux (User, Frais, Niveau, Filiere, Specialite, etc.)
- `resources/views/` : Vues Blade (dashboard, users, paiements, notFound, etc.)
- `routes/web.php` : Définition des routes avec middleware de rôle
- `public/images/` : Photos des étudiants et images diverses
- `database/migrations/` : Migrations pour toutes les tables du projet

## Installation

1. Cloner le projet
2. Installer les dépendances :
   ```bash
   composer install
   npm install
   ```
3. Configurer le fichier `.env` (base de données, mail, etc.)
4. Lancer les migrations :
   ```bash
   php artisan migrate
   ```
5. Compiler les assets :
   ```bash
   npm run dev
   ```
6. Démarrer le serveur :
   ```bash
   php artisan serve
   ```

## Utilisation

- Accès au dashboard : `/admin/dashboard/project`
- Gestion des étudiants : `/admin/students`
- Gestion des frais : `/admin/frais`
- Gestion des filières, spécialités, niveaux : `/admin/filieres`, `/admin/specialite`, `/admin/niveaux`
- Seules les routes admin sont accessibles aux utilisateurs ayant le rôle `admin`.

## Personnalisation

- Sidebar et header adaptatifs pour tous les écrans
- Page 404 stylisée dans `resources/views/pages/notFound/pageNotFound.blade.php`
- Filtres et pagination sur la liste des étudiants
- Possibilité d’ajouter des rôles ou des modules facilement

## Contribuer

Les contributions sont les bienvenues !  
Merci de soumettre vos pull requests ou d’ouvrir une issue pour toute suggestion.

## Auteur

Projet réalisé par boris2442 dans le cadre du stage DQP.

---

N’hésite pas à adapter ce README selon tes besoins spécifiques ou à ajouter des instructions pour l’installation en production, la gestion des rôles, etc.# campuspay
