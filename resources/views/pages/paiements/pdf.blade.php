<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Liste des Paiements</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        header img {
            width: 120px;
            height: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        footer {
            text-align: right;
            font-style: italic;
            font-size: 11px;
            margin-top: 30px;
            border-top: 1px solid #aaa;
            padding-top: 8px;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('logos/logo.jpg') }}" alt="Logo">
    </header>
    <h2>Liste des Paiements</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Étudiant</th>
                <th>Montant</th>
                <th>Date de paiement</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paiements as $paiement)
            <tr>
                <td>{{ $paiement->id }}</td>
                <td>{{ $paiement->user->name ?? 'N/A' }}</td> {{-- si relation user existe --}}
                <td>{{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA</td>
                <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $paiement->statut }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <footer>🕒 Imprimé le {{ now()->format('d/m/Y - H:i:s') }}</footer>
</body>

</html>