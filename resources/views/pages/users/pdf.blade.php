<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Liste des etudiants</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
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

        .photo-col {
            width: 80px;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('logos/logo.jpg') }}" alt="Logo">
    </header>
    <h2>Liste des etudiants</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Email</th>
                <th>Filiere</th>
                <th>Specialite</th>
                <th>Niveau</th>
                <th>Date de Naissance</th>
                <th>Lieu de naissance</th>
                <th class="photo-col">Photo</th>

                <th>Adresse</th>
                <th>Sexe</th>
                <th>Telephone</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td class="px-6 py-4">{{ $student->id }}</td>
                {{-- <td class="px-6 py-4">{{ $student->matricule }}</td> --}}
                <td class="px-6 py-4">{{ $student->name }}</td>
                <td class="px-6 py-4">{{ $student->prenom }}</td>
                <td class="px-6 py-4">{{ $student->email }}</td>
                <td class="px-6 py-4">{{ $student->filiere->name ?? 'N/A' }}</td>
                <td class="px-6 py-4">{{ $student->specialite->name ?? 'N/A' }}</td>
                <td class="px-6 py-4">{{ $student->niveau->name ?? 'N/A' }}</td>
                <td class="px-6 py-4">{{ $student->date_naissance }}</td>
                <td class="px-6 py-4">{{ $student->lieu_de_naissance }}</td>
                <td class="photo-col">
                    @if($student->photo)
                    <img src="{{ public_path('images/students/' . $student->photo) }}"
                        alt="Photo de {{ $student->name }}"
                        style="width:60px; height:60px; border-radius:50%; display:block; margin:0 auto;">
                    @else
                    <img src="{{ public_path('images/default.jpg') }}" alt="Photo par défaut"
                        style="width:60px; height:60px; border-radius:50%; display:block; margin:0 auto;">
                    @endif
                </td>



                <td class="px-6 py-4">{{ $student->adresse }}</td>
                <td class="px-6 py-4">{{ $student->sexe }}</td>
                <td class="px-6 py-4">{{ $student->telephone }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h4 style="text-align:right; margin-top:20px;">📌 Total des étudiants : {{ $students->count() }}</h4>

    <footer>🕒 Imprimé le {{ now()->format('d/m/Y - H:i:s') }}</footer>
</body>

</html>