<!DOCTYPE html>
<html>
<head>
    <title>EcoVolt Verification</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e1e1e1; border-radius: 10px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <h1 style="color: #1976D2;">EcoVolt</h1>
            <p style="font-size: 18px; font-weight: bold;">Verify Your Account</p>
        </div>
        
        <p>Hello,</p>
        <p>Thank you for joining ecoVolt. To complete your registration and access your portal, please use the following one-time password (OTP):</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #1976D2; border: 2px dashed #1976D2; padding: 10px 20px; border-radius: 5px;">
                {{ $otp }}
            </span>
        </div>
        
        <p>This code is valid for 10 minutes. Please do not share it with anyone.</p>
        
        <p>Best regards,<br>The ecoVolt Team</p>
        
        <hr style="margin-top: 30px;">
        <p style="font-size: 12px; color: #999; text-align: center;">EcoVolt - Intelligent Energy Solutions</p>
    </div>
</body>
</html>
