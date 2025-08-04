
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Reçu de paiement - {{ $user->name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #1d4ed8;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            height: 60px;
        }

        .header-text {
            text-align: right;
        }

        h1,
        h2,
        h3 {
            color: #1d4ed8;
            margin-bottom: 5px;
        }

        .section {
            margin-bottom: 25px;
        }

        .info {
            background-color: #f0f4ff;
            padding: 15px;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th,
        .table td {
            border: 1px solid #cbd5e0;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #1d4ed8;
            color: white;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-style: italic;
            font-size: 12px;
            color: #555;
        }

        /* Style pour la progression des tranches */
        .tranches {
            display: flex;
            gap: 15px;
            margin-top: 10px;
            font-size: 12px;
        }

        .tranche {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .tranche-circle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 11px;
        }

        .tranche-couvert {
            background-color: green;
            color: white;
        }

        .tranche-non-couvert {
            background-color: #ccc;
            color: #555;
        }

        .note {
            font-size: 11px;
            color: #666;
            font-style: italic;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <!-- En-tête -->
    <div class="header">
        <div>
            @if(file_exists(public_path('logos/logo.jpg')))
            <img src="{{ public_path('logos/logo.jpg') }}" alt="Logo de l'école" class="logo">
            @else
            <div style="font-weight:bold; color:#1d4ed8;">LOGO</div>
            @endif
        </div>
        <div class="header-text">
            <h1>Reçu de Paiement</h1>
            <h2>{{ $user->prenom }} {{ $user->name }}</h2>
        </div>
    </div>

    <!-- Informations personnelles -->
    <div class="section info">
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>Téléphone :</strong> {{ $user->telephone ?? 'N/A' }}</p>
        <p><strong>Filière :</strong> {{ $user->filiere->name ?? 'Non défini' }}</p>
        <p><strong>Spécialité :</strong> {{ $user->specialite->name ?? 'Non défini' }}</p>
        <p><strong>Niveau :</strong> {{ $user->niveau->name ?? 'Non défini' }}</p>
    </div>

    <!-- Résumé financier -->
    <div class="section">
        <p><strong>Total payé :</strong> {{ number_format($user->total_paye, 0, ',', ' ') }} FCFA</p>
        <p><strong>Total à payer :</strong> {{ number_format($user->total_frais, 0, ',', ' ') }} FCFA</p>
        <p><strong>Reste à payer :</strong> {{ number_format($user->frais_restant, 0, ',', ' ') }} FCFA</p>
        <p><strong>Statut global :</strong>
            @if($user->statut_paiement === 'Complet')
            <span style="color: green; font-weight: bold;"> {{ $user->statut_paiement }}</span>
            @else
            <span style="color: #d97706; font-weight: bold;"> {{ $user->statut_paiement }}</span>
            @endif
        </p>

        <!-- Suivi des tranches -->
        <p style="margin-top: 15px; font-weight: bold; color: #1d4ed8;">Suivi de la progression financière :</p>
        <div class="tranches">
            @foreach(['tranche1', 'tranche2', 'tranche3'] as $index => $tranche)
            @php
            $estCouvert = $user->aPayeTranche($tranche);
            $frais = \App\Models\Frai::first();
            $montant = $frais ? $frais->{$tranche} : 0;
            @endphp
            <div class="tranche">
                <div class="tranche-circle {{ $estCouvert ? 'tranche-couvert' : 'tranche-non-couvert' }}">
                    {{ $index + 1 }}
                </div>
                <span>{{ number_format($montant, 0, ',', ' ') }}</span>
                <span>{{ $estCouvert ? '✅' : '⭕' }}</span>
            </div>
            @endforeach
        </div>
        <p class="note">
            <strong>Note :</strong> Les tranches sont affichées à titre indicatif pour suivre la progression.
            Le paiement peut être effectué en plusieurs fois, sans obligation d'ordre.
        </p>
    </div>

    <!-- Historique des paiements -->
    <div class="section">
    <h3>Historique des paiements de {{$user->name}} {{$user->prenom}}</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Montant</th>
                <th>Mode</th>
                <th>Statut</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($paiements as $paiement)
                <tr>
                    <td>...</td>
                    <td>{{ number_format(...) }} FCFA</td>
                    <td>...</td>
                    <td>✅ Validé</td>
                    <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Aucun paiement</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

    <!-- Pied de page -->
    <div class="footer">
        Ce reçu a été généré automatiquement depuis la plateforme de gestion des paiements étudiants de l'ESCa.
    </div>
    <footer><i>🕒 Imprimé le {{ now()->format('d/m/Y - H:i:s') }}</i></footer>

</body>

</html>