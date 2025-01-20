<!-- resources/views/emails/pfe_encadrement_assignment.blade.php -->
<html>
<head>
    <title>PFE Encadrement Assignment Notification</title>
</head>
<body>
    <p>Dear {{ $studentName }},</p>

    <p>We are pleased to inform you that your PFE project titled <strong>"{{ $projectTitle }}"</strong> has been assigned a supervisor.</p>

    <p>The assigned supervisor is <strong>{{ $supervisorName }}</strong>.</p>

    <p>We wish you success in your project and encourage you to contact your supervisor for further steps.</p>

    <p>You can access the platform for more details here: <a href="http://localhost:5173/dashboard/home">PFE Dashboard</a></p>

    <p>Best regards,<br>PFE Management Team</p>
</body>
</html>
