<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PFE Jury Composition</title>
</head>
<body>
    <p>Hello {{ $studentName }},</p>
    <p>Here is the composition of your jury for the defense of your project:</p>
    <ul>
        <li><strong>President:</strong> {{ $juryComposition['president'] }}</li>
        <li><strong>Examiner:</strong> {{ $juryComposition['examiner'] }}</li>
        <li><strong>Supervisor:</strong> {{ $juryComposition['supervisor'] }}</li>
    </ul>
    <p>Please prepare for your defense.</p>
    <p>Best regards,<br>The PFE Management Team</p>
</body>
</html>
