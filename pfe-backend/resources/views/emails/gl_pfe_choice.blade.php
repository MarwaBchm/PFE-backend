<!-- resources/views/emails/gl_pfe_choice.blade.php -->
<html>
<head>
    <title>Choisissez un PFE pour votre option GL</title>
</head>
<body>
    <p>Bonjour {{ $studentName }},</p>

    <p>Vous avez la possibilité de choisir parmi les projets de fin d'études proposés pour votre option GL.</p>

    <p>Voici la liste des PFE disponibles :</p>
    <ul>
        @foreach ($availablePFEs as $pfe)
            <li>{{ $pfe }}</li>
        @endforeach
    </ul>

    <p>Merci de faire votre choix sur la plateforme.</p>

    <p>Cordialement,<br>L’équipe de gestion des PFE</p>
</body>
</html>
