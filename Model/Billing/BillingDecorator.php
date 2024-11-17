<?php
abstract class BillingDecorator implements Billing {
    protected Billing $billing; // The wrapped Billing object

    public function __construct(Billing $billing) {
        $this->billing = $billing;
    }

    // Set a new Billing object dynamically
    public function setBilling(Billing $billing): void {
        $this->billing = $billing;
    }

    public function calculateTotal(): float {
        return $this->billing->calculateTotal();
    }

    public function generateReport(string $reportType): string {
        return $this->billing->generateReport($reportType);
    }

    public function processPayment(): void {
        $this->billing->processPayment();
    }
}
