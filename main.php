<?php
require_once 'Model/Billing/Billing.php';
require_once 'Model/Billing/BillingDecorator.php';
require_once 'Model/Billing/TaxDecorator.php';
require_once 'Model/Billing/DiscountDecorator.php';
require_once 'Model/Billing/InsuranceDecorator.php';
require_once 'Model/Billing/SurgeryBill.php';
require_once 'Model/Billing/CreditCardPayment.php';

$surgeryBill = new SurgeryBill(1000, "S123", ["Antibiotic", "Painkiller"], new CreditCardPayment());

// Modify the bill
$surgeryBill->modifyBill(200); // Add $200
$surgeryBill->modifyBill(-50); // Subtract $50

// Apply decorators
$decoratedBill = new TaxDecorator($surgeryBill, 0.1); // Add 10% tax
$decoratedBill = new InsuranceDecorator($decoratedBill, 20); // Apply 20% insurance coverage

// Generate the report
echo $decoratedBill->generateReport("Detailed") . "\n";

// Process payment
$decoratedBill->processPayment();
