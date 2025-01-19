<!DOCTYPE html>
<html>
<head>
    <title>Welcome to {{ config('app.name') }}</title>
</head>
<body>
    <h1>Welcome, {{ $user->email }}!</h1>
    <p>Your account has been successfully created.</p>
    <p>Here are your login details:</p>
    <ul>
        <li><strong>Username:</strong> {{ $username }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>You can log in to your account <a href="{{ url('/login') }}">here</a>.</p>
    <p>Thank you for joining us!</p>
</body>
</html>
