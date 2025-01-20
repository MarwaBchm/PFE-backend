<!-- resources/views/emails/pfe_project_needs_update.blade.php -->
<html>
<head>
    <title>PFE Project Proposal Needs Update</title>
</head>
<body>
    <p>Dear {{ $studentName }},</p>

    <p>We have reviewed your project proposal titled <strong>"{{ $projectTitle }}"</strong>.</p>

    <p>We require additional information to proceed with your project proposal. Please update the necessary details.</p>

    <p>Please take the necessary actions accordingly.</p>

    <p>You can access the platform for more details here: <a href="http://localhost:5173/dashboard/home">PFE Dashboard</a></p>

    <p>Best regards,<br>The PFE Platform Team</p>
</body>
</html>
