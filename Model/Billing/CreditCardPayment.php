<?php

require_once 'PaymentStrategy.php';
class CreditCardPayment implements PaymentStrategy {
    public function processPayment(float $amount): void {
        echo "Processing credit card payment of: {$amount}\n";
    }
}
