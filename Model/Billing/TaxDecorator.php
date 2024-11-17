<?php
require_once 'BillingDecorator.php';

class TaxDecorator extends BillingDecorator {
    private float $taxRate;

    public function __construct(Billing $billing, float $taxRate) {
        parent::__construct($billing);
        $this->taxRate = $taxRate;
    }

    public function calculateTotal(): float {
        return $this->billing->calculateTotal() * (1 + $this->taxRate);
    }

    public function generateReport(string $reportType): string {
        return $this->billing->generateReport($reportType) . " (Tax Applied: " . ($this->taxRate * 100) . "%)";
    }
}
