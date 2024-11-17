<?php
class InsuranceDecorator extends BillingDecorator {
    private float $coveragePercentage;

    public function __construct(Billing $billing, float $coveragePercentage) {
        parent::__construct($billing);
        $this->coveragePercentage = $coveragePercentage;
    }

    public function calculateTotal(): float {
        return $this->billing->calculateTotal() * (1 - $this->coveragePercentage / 100);
    }

    public function generateReport(string $reportType): string {
        return $this->billing->generateReport($reportType) . " (Insurance Coverage: {$this->coveragePercentage}%)";
    }
}
