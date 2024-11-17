<?php
interface PaymentStrategy {
    public function processPayment(float $amount): void;
}
