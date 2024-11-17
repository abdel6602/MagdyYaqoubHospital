<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f4f4;
}
.login-container {
    background: #fff;
    padding: 50px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}
.login-container h2 {
    text-align: center;
    margin-bottom: 20px;
}
.login-container input,
.login-container button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.login-container button {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}
.login-container button:hover {
    background-color: #45a049;
}
.otp-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}
.otp-container h2 {
    text-align: center;
    margin-bottom: 20px;
}
.otp-container input,
.otp-container button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.otp-container button {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}
.otp-container button:hover {
    background-color: #45a049;
}
    </style>

</head>
<body>
<?php

class LoginVeiw{
    public function showEmailLogin(){
        echo '<div class="login-container">'; 
        echo '<h2>Login</h2>';
        echo '<form action="http://localhost/magdyyaqoubhospital/Controllar/Authentication/AuthenticationController.php" method="POST">';
        echo '<input type="hidden" name="LOGIN">';
        echo '<label for="email">Email</label>';
        echo '<input type="email" id="email" name="email" placeholder="example@example.com" required>';
        echo '<label for="password">Password</label>';
        echo '<input type="password" id="password" name="password" placeholder="Enter your password" required>';
        echo '<button type="submit">Login</button>';
        echo '</form>';
        echo '</div>';
    }

    public function showOTPAuthentication() {
        echo '<div class="otp-container">';
        echo '<h2>Enter OTP</h2>';
        echo '<form action="http://localhost/magdyyaqoubhospital/Controllar/Authentication/AuthenticationController.php" method="POST">';
        echo '<input type="hidden" name="OTP">';
        echo '<input type="number" name="OTPFIELD" placeholder="Enter the OTP sent to your email" required>';
        echo '<button type="submit">Verify OTP</button>';
        echo '</form>';
        echo '</div>';
    }
}

?>
    
</body>
</html>
