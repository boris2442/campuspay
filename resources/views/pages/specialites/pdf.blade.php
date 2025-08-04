<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Liste des Filières</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            margin: 30px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header img {
            width: 120px;
            height: auto;
        }

        h2 {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 25px;
            font-size: 20px;
            text-transform: uppercase;
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

        .total {
            font-weight: bold;
            margin-top: 10px;
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

    <h2>Liste des Specialites</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($specialites as $specialite)
            <tr>
                <td>{{ $specialite->id }}</td>
                <td>{{ $specialite->name }}</td>
                <td>{{ $specialite->description ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">📌 Total filières : {{ $specialites->count() }}</p>

    <footer>
        🕒 Imprimé le {{ now()->format('d/m/Y - H:i:s') }}
    </footer>
</body>

</html>