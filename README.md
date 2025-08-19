CampusPay – Gestion des Frais Étudiants

CampusPay est une solution moderne pour la gestion des frais et paiements étudiants. Développée avec Laravel et Tailwind CSS, elle offre un tableau de bord intuitif et sécurisé pour simplifier la vie administrative des établissements et des étudiants.

🌐 Version en ligne : campuspay.evendeco.com

Fonctionnalités clés

Authentification sécurisée avec gestion des rôles (admin, comptable…)

Dashboard responsive avec sidebar et header adaptatifs

CRUD complet pour étudiants, filières, spécialités, niveaux et frais

Recherche et filtrage avancé des étudiants

Gestion des paiements avec calcul automatique des totaux

Pagination et affichage dynamique des listes

Pages d’erreur personnalisées et sécurité des routes par rôle

Installation rapide
git clone https://github.com/boris2442/campuspay.git
cd campuspay
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve

Utilisation

Dashboard : /admin/dashboard/project

Gestion des étudiants : /admin/students

Gestion des frais : /admin/frais

Gestion des filières, spécialités, niveaux : /admin/filieres, /admin/specialite, /admin/niveaux

Seules les routes admin sont accessibles aux utilisateurs ayant le rôle admin.

Personnalisation

Ajout facile de rôles et modules

Sidebar et header adaptatifs pour tous les écrans

Filtres et pagination sur la liste des étudiants

Page 404 stylisée

Contribuer

Les contributions sont les bienvenues ! Ouvrez une issue ou soumettez une pull request.

Auteur

Aubin Boris Simo Tsebo – Projet réalisé dans le cadre du stage DQP.