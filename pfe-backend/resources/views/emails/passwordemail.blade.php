<!DOCTYPE html>
<html>
<head>
    <title>Welcome to GradMastery</title>
</head>
<body>
    <p>Hello {{ $userType }},</p>
    <p>Welcome to GradMastery! Here are the details of your submission:</p>
    <ul>
        <li><strong>Subject:</strong> Generate a password</li>
        <li><strong>Selected Types:</strong> Student, Professor, Enterprise</li>
    </ul>
    <p><strong>Your temporary password is:</strong> {{ $temporaryPassword }}</p>
    <p><i>(Please change it after logging in.)</i></p>
    <p>You can access the platform here: <a href="http://localhost:5173/dashboard/home">http://localhost:5173/dashboard/home</a></p>
    <p>This email was sent on {{ $dateTime }}</p>
    <p>Best regards,</p>
    <p>GradMastery Team</p>
</body>
</html>
