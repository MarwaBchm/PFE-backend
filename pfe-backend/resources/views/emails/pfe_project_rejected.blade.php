<!-- resources/views/emails/pfe_project_rejected.blade.php -->
<html>
<head>
    <title>PFE Project Proposal Rejected</title>
</head>
<body>
    <p>Hello {{ $studentName }},</p>

    <p>After review, we regret to inform you that your project proposal titled <strong>"{{ $projectTitle }}"</strong> has not been approved.</p>

    <p>If you would like to make modifications or resubmit the proposal, please follow the instructions provided below.</p>

    <p>Best regards,<br>The PFE Platform Team</p>
</body>
</html>
