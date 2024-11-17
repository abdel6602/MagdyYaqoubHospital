<?php

include_once("../../View/Billing/BillingView.php");
include_once("../../Model/Billing/ClinicBill.php");
include_once("../../Model/Billing/CreditCardPayment.php");


if (isset($_POST["viewBill"])){
    $view = new BillingView();
    $view->display_billing_details(new ClinicBill(100, 12343, 23145, new CreditCardPayment()));
}


else if(isset($_GET["pay"])){
    $view = new BillingView();
    $view->display_payment_status("Payment Successful");
}