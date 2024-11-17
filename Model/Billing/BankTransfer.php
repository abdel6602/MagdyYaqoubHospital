<?php
class BankTransfer implements PaymentStrategy {
    public function processPayment(float $amount): void {
        echo "Processing bank transfer of: {$amount}\n";
    }
}
