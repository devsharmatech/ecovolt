<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Bhardwaj Hospital Management System</title>
</head>

<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <h2>Welcome to EcoVolt Portal</h2>

        <p>Hello {{ $user->name }},</p>

        <p>Your account has been successfully created. Here are your login credentials:</p>

        <div style="background-color: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Account ID:</strong> {{ $user->user_code ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
        </div>

        <p>Please login and change your password immediately for security reasons.</p>

        <p>If you have any questions, please contact the administrator.</p>

        <br>
        <p>Best regards,<br>
            EcoVolt Portal Team</p>
    </div>
</body>

</html>
