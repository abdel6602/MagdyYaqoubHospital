<?php
interface Billing {
    public function calculateTotal(): float; // Calculate the total cost
    public function generateReport(string $reportType): string; // Generate a billing report
    public function processPayment(): void; // Process payment
}
