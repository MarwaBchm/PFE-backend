<!-- resources/views/emails/pfe_project_not_selected.blade.php -->
<html>
<head>
    <title>PFE Project Submission Status: Not Selected</title>
</head>
<body>
    <p>Dear {{ $studentName }},</p>

    <p>We regret to inform you that your PFE project titled <strong>"{{ $projectTitle }}"</strong> has not been selected for this session.</p>

    <p>Reason: <strong>{{ $reason }}</strong></p>

    <p>We encourage you to explore other opportunities on the platform and continue engaging with us.</p>

    <p>You can access the platform for more details here: <a href="http://localhost:5173/dashboard/home">PFE Dashboard</a></p>

    <p>Best regards,<br>PFE Management Team</p>
</body>
</html>
