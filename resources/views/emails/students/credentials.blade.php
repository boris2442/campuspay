<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Accès à votre espace étudiant</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f6f9fc;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            background-color: #ffffff;
            margin: 30px auto;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        header img {
            max-height: 80px;
        }

        h1 {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 22px;
        }

        p {
            line-height: 1.6;
            font-size: 15px;
        }

        .credentials {
            background-color: #e9f5ff;
            border: 1px solid #b6d4fe;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 15px;
            font-weight: bold;
            color: #004085;
        }

        a.button {
            display: inline-block;
            background-color: #007bff;
            color: #fff !important;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #999;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <img src="{{ public_path('logos/logo.jpg') }}" alt="Logo Ecole Supérieure La Canadienne" />
        </header>

        <h1>Bienvenue {{ $user->prenom }} {{ $user->name }}</h1>

        <p>Vous avez été enregistré dans notre système en tant qu'étudiant(e) à l'<strong>École Supérieure La
                Canadienne</strong>.</p>

        <p>Vous pouvez dès à présent accéder à votre espace personnel pour :</p>
        <ul>
            <li>📌 Consulter vos informations académiques</li>
            <li>💸 Suivre l’état de vos paiements (tranches, soldes, etc.)</li>
        </ul>

        <p>Voici vos identifiants :</p>

        <div class="credentials">
            Email : {{ $user->email }}<br>
            Mot de passe : {{ $password }}
        </div>

        <p>Pour accéder à votre espace, cliquez sur le bouton ci-dessous :</p>

        <a href="{{ route('login') }}" class="button">Accéder à mon espace</a>

        <footer>
            &copy; {{ date('Y') }} École Supérieure La Canadienne - Tous droits réservés.
        </footer>
    </div>
</body>

</html>