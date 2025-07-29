<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Reçu de paiement - </title>
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
    </style>
</head>

<body>

    <div class="header">
        <!-- Logo de l'école -->
        <div>
            <img src="{{ public_path('logos/logo.jpg')}}" alt="Logo de l'école" class='logo'>
        </div>

        <!-- Texte à droite -->
        <div class="header-text">
            <h1>Reçu de Paiement</h1>
            <h2>{{ $user->prenom }} {{ $user->name }}</h2>
        </div>
    </div>

    <div class="section info">
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>Téléphone :</strong> {{ $user->telephone ?? 'N/A' }}</p>
        <p><strong>Filière :</strong> {{ $user->filiere->name ?? 'Non défini' }}</p>
        <p><strong>Spécialité :</strong> {{ $user->specialite->name ?? 'Non défini' }}</p>
        <p><strong>Niveau :</strong> {{ $user->niveau->name ?? 'Non défini' }}</p>
    </div>

    <div class="section">
        <p><strong>Total payé :</strong> {{ number_format($totalPaye, 0, ',', ' ') }} FCFA</p>
        <p><strong>Total à payer :</strong> {{ number_format($totalFrais, 0, ',', ' ') }} FCFA</p>
        <p><strong>Reste à payer :</strong> {{ number_format($fraisRestant, 0, ',', ' ') }} FCFA</p>
        <p><strong>Statut global :</strong>
            @if($statutGlobal === 'Complet')
            <span style="color: green;">{{ $statutGlobal }}</span>
            @else
            <span style="color: orange;">{{ $statutGlobal }}</span>
            @endif
        </p>
    </div>

    <div class="section">
        <h3>Historique des paiements</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Tranche</th>
                    <th>Montant</th>
                    <th>Mode de paiement</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paiements as $paiement)
                <tr>
                    <td>{{ ucfirst($paiement->tranche_paye) }}</td>
                    <td>{{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}</td>
                    <td>
                        @if($paiement->statut === 'valide')
                        Validé
                        @elseif($paiement->statut === 'en_attente')
                        En attente
                        @else
                        Rejeté
                        @endif
                    </td>
                    <td>{{ $paiement->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Ce reçu a été généré automatiquement depuis la plateforme de gestion des paiements étudiants de l'ESCa.
    </div>
    <footer><i>🕒 Imprimé le {{ now()->format('d/m/Y - H:i:s') }}</i></footer>
</body>

</html>