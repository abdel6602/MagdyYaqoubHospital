<?php

include_once("Billing.php");
class ClinicBill implements Billing {
    private float $baseAmount;
    private string $billID;
    private int $appointmentID;
    private PaymentStrategy $paymentMethod;

    public function __construct(float $baseAmount, string $billID, int $appointmentID, PaymentStrategy $paymentMethod) {
        $this->baseAmount = $baseAmount;
        $this->billID = $billID;
        $this->appointmentID = $appointmentID;
        $this->paymentMethod = $paymentMethod;
    }

    public function modifyBill(float $amount): void {
        $this->baseAmount += $amount;
        echo "Clinic Bill Modified: New Base Amount = {$this->baseAmount}\n";
    }

    public function calculateTotal(): float {
        return $this->baseAmount;
    }

    public function generateReport(string $reportType): string {
        return "Clinic Report: Bill ID: {$this->billID}, Total: {$this->calculateTotal()}";
    }

    public function processPayment(): void {
        $this->paymentMethod->processPayment($this->calculateTotal());
    }

    // getters and setters for billID and appointmentID
    public function getBillID(){
        return $this->billID;
    }

    public function getAppointmentID(){
        return $this->appointmentID;
    }
}
