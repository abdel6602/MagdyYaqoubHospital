<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing</title>
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        h1 {
            text-align: center;
        }

        h2 {
            text-align: center;
        }

        .billingContainer {
            display: flex;
            justify-content: center;
        }

        .billingDetails {
            border: 1px solid black;
            padding: 10px;
            margin: 10px;
        }
        .paymentStatusBox {
            padding: 10px;
            margin: 10px;
            text-align: center;
        }
        button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<?php

// page for viewing a patient's billing 

class BillingView{
    
    public function display_billing_details($billing) {
        $total =$billing->calculateTotal();
        $surgery = $billing->getAppointmentID();
        $billID = $billing->getBillID();

        echo '<h1>Billing</h1>';
        echo '<h2>Bill Details</h2>';
        echo '<div class="billingContainer">' .
        '<div class="billingDetails">' .
            '<p>Bill ID:' . $billID .'</p>' .
            '<p>Bill Amount: '. $total .'</p>' .
            '<p>Bill Status: '. $surgery .'</p>' .
            '</div>' .
        '</div>' . 
        '<form action="http://localhost/magdyyaqoubhospital/Controllar/Billing/BillingController.php", method="GET">' . 
            '<input type="hidden" name="pay" id="1">' . 
            '<button type="submit">Make Payment</button>' . 
            '</form>';
    ;
    }

    public function display_payment_status($status) {
        if(strlen($status) == 0){
            $status = 'Sorry, Server Side Error Occurred. Please Try Again Later';
            return;
        }
        else{
            echo '<div class="paymentStatusBox">';
            echo '<h2>Payment Status</h2>';
            echo '<p style="color:green">'. $status . '</p>';
            echo '</div>';
        }
    }
}

?>

<!-- <form action="http://localhost/magdyyaqoubhospital/Controllar/Billing/BillingController.php", method="GET">
    <input type="hidden" name="pay" id="1">
    <button type="submit">Make Payment</button>
</form> -->
   
</body>

</html>