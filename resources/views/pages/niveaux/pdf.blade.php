<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des niveaux</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 30px;
        }

        img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        footer {
            margin-top: 40px;
            font-size: 10px;
            text-align: right;
            color: #555;
        }

        h4 {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('logos/logo.jpg') }}" alt="Logo">
    </header>

    <h2>📘 Liste des niveaux de l'École Supérieure La Canadienne</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Date de création</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($niveaux as $niveau)
                <tr>
                    <td>{{ $niveau->id }}</td>
                    <td>{{ $niveau->name }}</td>
                    <td>{{ $niveau->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>📌 Total des niveaux : {{ $niveaux->count() }}</h4>

    <footer>
        <i>🕒 Imprimé le {{ now()->format('d/m/Y - H:i:s') }}</i>
        </footer>
</body>

</html>
