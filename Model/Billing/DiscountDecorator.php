<?php
class DiscountDecorator extends BillingDecorator {
    private float $discount;

    public function __construct(Billing $billing, float $discount) {
        parent::__construct($billing);
        $this->discount = $discount;
    }

    public function calculateTotal(): float {
        return max(0, $this->billing->calculateTotal() - $this->discount);
    }

    public function generateReport(string $reportType): string {
        return $this->billing->generateReport($reportType) . " (Discount Applied: {$this->discount})";
    }
}
