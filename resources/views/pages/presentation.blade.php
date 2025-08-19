
@extends('layouts.users.layout-user')

@section('content')

<section class="max-w-4xl mx-auto py-12 px-4 ">
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
            <a href="{{ url('/dashboard') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-white dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                Dashboard
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border  dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-white text-red-500">
                    Déconnexion
                </button>
            </form>
            @else
            <a href="{{ route('login') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-red-400 border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                Log in
            </a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-white">
                Register
            </a>
            @endif
            @endauth
        </nav>
        @endif
    </header>

    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-6 text-blue-700">CampusPay : La plateforme moderne de
        gestion scolaire et
        financière
    </h1>
    <p class="mb-6 text-lg">
        <strong>CampusPay</strong> est une solution complète dédiée aux établissements d’enseignement pour simplifier la
        gestion administrative, académique et financière des étudiants. Grâce à une interface intuitive et des outils
        puissants, CampusPay accompagne les écoles, universités et instituts dans leur transformation digitale.
    </p>

    <h2 class="text-2xl font-semibold mt-8 mb-4 text-blue-600">Fonctionnalités principales</h2>
    <ul class="list-disc pl-8 mb-6 text-lg space-y-2">
        <li><strong>Gestion centralisée des étudiants :</strong> inscription, suivi du parcours, gestion des niveaux,
            filières et spécialités.</li>
        <li><strong>Suivi des paiements :</strong> gestion des frais de scolarité par tranche, historique des paiements,
            relances automatiques.</li>
        <li><strong>Tableau de bord dynamique :</strong> statistiques en temps réel, graphiques d’évolution, indicateurs
            clés de performance.</li>
        <li><strong>Rapports automatisés :</strong> génération de rapports financiers, export PDF/Excel, synthèses par
            filière ou niveau.</li>
        <li><strong>Gestion des utilisateurs :</strong> rôles (administrateur, étudiant), sécurité renforcée, gestion
            des accès.</li>
        <li><strong>Notifications & alertes :</strong> rappels de paiement, annonces importantes, communication interne.
        </li>
        <li><strong>Archivage & historique :</strong> conservation sécurisée des données, accès rapide à l’historique
            des transactions.</li>
    </ul>

    <h2 class="text-2xl font-semibold mt-8 mb-4 text-blue-600">Pourquoi choisir CampusPay ?</h2>
    <ul class="list-disc pl-8 mb-6 text-lg space-y-2">
        <li><strong>Gain de temps :</strong> automatisation des tâches répétitives et réduction des erreurs humaines.
        </li>
        <li><strong>Accessibilité :</strong> plateforme accessible 24h/24, sur ordinateur, tablette et mobile.</li>
        <li><strong>Sécurité :</strong> protection des données sensibles, conformité RGPD, sauvegardes régulières.</li>
        <li><strong>Support dédié :</strong> assistance technique réactive, documentation complète, mises à jour
            régulières.</li>
        <li><strong>Personnalisation :</strong> adaptation aux besoins spécifiques de chaque établissement.</li>
    </ul>

    <h2 class="text-2xl font-semibold mt-8 mb-4 text-blue-600">Sécurité & Confidentialité</h2>
    <p class="mb-6 text-lg">
        CampusPay met un point d’honneur à la sécurité des données : toutes les informations sont chiffrées, les accès
        sont contrôlés, et des audits réguliers sont réalisés pour garantir la confidentialité des utilisateurs.
    </p>

    <h2 class="text-2xl font-semibold mt-8 mb-4 text-blue-600">Questions fréquentes (FAQ)</h2>
    <div class="mb-8">
        <p class="font-semibold">CampusPay est-il adapté à tous les types d’établissements ?</p>
        <p class="mb-4">Oui, la plateforme est conçue pour s’adapter aux écoles, universités, instituts et centres de
            formation de toutes tailles.</p>
        <p class="font-semibold">Comment les étudiants accèdent-ils à leur espace personnel ?</p>
        <p class="mb-4">Chaque étudiant dispose d’un accès sécurisé pour consulter ses informations, ses paiements et
            recevoir des notifications.</p>
        <p class="font-semibold">Peut-on exporter les données ?</p>
        <p class="mb-4">Oui, tous les rapports peuvent être exportés en PDF ou Excel pour faciliter le traitement et
            l’archivage.</p>
        <p class="font-semibold">Comment obtenir une démonstration ?</p>
        <p>Contactez-nous via le formulaire de contact pour planifier une démo personnalisée.</p>
    </div>

    <h2 class="text-2xl font-semibold mt-8 mb-4 text-blue-600">Témoignages</h2>
    <blockquote class="border-l-4 border-blue-400 pl-4 italic mb-4">
        « CampusPay a révolutionné la gestion de notre établissement. Les paiements sont suivis en temps réel et les
        rapports sont clairs et précis. »<br>
        <span class="font-semibold">— Directeur d’école</span>
    </blockquote>
    <blockquote class="border-l-4 border-blue-400 pl-4 italic mb-4">
        « Grâce à CampusPay, je peux suivre mes paiements et recevoir des rappels facilement. »<br>
        <span class="font-semibold">— Étudiant</span>
    </blockquote>

    <div class="mt-10">
        <a href="{{ url('/') }}"
            class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition duration-300">
            Retour à l’accueil
        </a>
    </div>
</section>
 <!-- TypewriterJS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/typewriter-effect@2.18.0/dist/core.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

    <script src="{{ asset('js/particles-config.js') }}"></script>
@endsection