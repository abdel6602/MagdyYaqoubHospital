<?php

include_once("../../View/Authentication/loginView.php");
// include_once("../../View/HomeView.php");

$auth_view = new LoginVeiw();
    
if(isset($_GET["LOGIN"])){
    $auth_view->showEmailLogin();
}

else if(isset($_POST["LOGIN"])){
    if(isset($_POST["email"]) && isset($_POST["password"])){
        $email = $_POST["email"];
        $password = $_POST["password"];
        // check credentials in database
        // if(userModel->checkCredentials($email, $password)){
        //  if(userModel->OTPEnabled()){
        //     $auth_view->showOTPAuthentication();
        //  }else{
        //   // redirect to home page
        //}
        //}
        // simulated by showing otp directly
        $auth_view->showOTPAuthentication();
    }
}

else if(isset($_POST["OTP"])){
    if(isset($_POST["OTPFIELD"])){
        $OTP = $_POST["OTPFIELD"];
        if($OTP == "1234"){
            header("Location: http://localhost/magdyyaqoubhospital/View/HomeView.php");
        }
    }
}