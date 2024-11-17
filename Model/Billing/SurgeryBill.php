<?php
class SurgeryBill implements Billing {
    private float $baseAmount;
    private string $surgeryID;
    private array $medicines; // Medicines used during surgery
    private PaymentStrategy $paymentMethod;

    public function __construct(float $baseAmount, string $surgeryID, array $medicines, PaymentStrategy $paymentMethod) {
        $this->baseAmount = $baseAmount;
        $this->surgeryID = $surgeryID;
        $this->medicines = $medicines;
        $this->paymentMethod = $paymentMethod;
    }

    public function modifyBill(float $amount): void {
        $this->baseAmount += $amount;
        echo "Surgery Bill Modified: New Base Amount = {$this->baseAmount}\n";
    }

    public function calculateTotal(): float {
        return $this->baseAmount;
    }

    public function generateReport(string $reportType): string {
        return "Surgery Report: Surgery ID: {$this->surgeryID}, Total: {$this->calculateTotal()}";
    }

    public function processPayment(): void {
        $this->paymentMethod->processPayment($this->calculateTotal());
    }
}
