<?php

    include_once("../../Model/Billing/ClinicBill.php");
    class PaymentView{
        public function viewPaymentScreen($bill){
            $total = $bill->calculateTotal();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
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
        .payment-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .payment-container h2 {
            margin: 0 0 20px;
            text-align: center;
        }
        .payment-container input,
        .payment-container button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .payment-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .payment-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h2>Payment Page</h2>
        <form action="process_payment.php" method="POST">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="John Doe" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="example@example.com" required>

            <label for="amount">Amount</label>
            <input type="number" id="amount" name="amount" placeholder="100.00" required>

            <label for="card">Card Number</label>
            <input type="text" id="card" name="card" placeholder="1234 5678 9012 3456" required>

            <label for="expiry">Expiry Date</label>
            <input type="month" id="expiry" name="expiry" required>

            <label for="cvv">CVV</label>
            <input type="password" id="cvv" name="cvv" placeholder="123" required>

            <button type="submit">Pay Now</button>
        </form>
    </div>
</body>
</html>
