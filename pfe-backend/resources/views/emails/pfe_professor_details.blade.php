<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PFE Details</title>
</head>
<body>
    <p>Hello {{ $professorName }},</p>
    <p>Here are the details of the PFE project you are supervising:</p>
    <ul>
        <li><strong>Project:</strong> {{ $projectName }}</li>
        <li><strong>Date:</strong> {{ $date }}</li>
        <li><strong>Time:</strong> {{ $time }}</li>
        <li><strong>Room:</strong> {{ $room }}</li>
    </ul>
    <p>Thank you for your follow-up and preparation.</p>
    <p>Best regards,<br>The PFE Management Team</p>
</body>
</html>
