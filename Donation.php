<?php

class Donation
{
    public $donationID;
    public $donorID;
    public $type; // Money, equipment, or medicine
    public $frequency; // One-time or regular
    public $amount;
    public $description;
    public $schedule; // Delivery schedule
    public $status; // In-progress, completed
    public $paymentStrategy; // PaymentStrategy instance
    public $observers = []; // List of observers for the Observer pattern

    public function __construct($donationID)
    {
        if ($donationID != "") {
            $sql = "SELECT * FROM donation WHERE donationID=?";
            $conn = returnConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $donationID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $this->donationID = $row["donationID"];
                $this->donorID = $row["donorID"];
                $this->type = $row["type"];
                $this->frequency = $row["frequency"];
                $this->amount = $row["amount"];
                $this->description = $row["description"];
                $this->schedule = $row["schedule"];
                $this->status = $row["status"];
            }
        }
    }

    // CRUD: Create a new Donation
    public static function createDonation($donorID, $type, $frequency, $amount, $description, $schedule)
    {
        $sql = "INSERT INTO donation (donorID, type, frequency, amount, description, schedule, status) VALUES (?, ?, ?, ?, ?, ?, 'in-progress')";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssds", $donorID, $type, $frequency, $amount, $description, $schedule);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Donation created successfully!" : "Failed to create donation.";
    }

    // CRUD: Update Donation Details
    public function updateDonation($type, $frequency, $amount, $description, $schedule, $status)
    {
        $sql = "UPDATE donation SET type=?, frequency=?, amount=?, description=?, schedule=?, status=? WHERE donationID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsisi", $type, $frequency, $amount, $description, $schedule, $status, $this->donationID);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->type = $type;
            $this->frequency = $frequency;
            $this->amount = $amount;
            $this->description = $description;
            $this->schedule = $schedule;
            $this->status = $status;
            return "Donation updated successfully!";
        }
        return "Failed to update donation.";
    }

    // CRUD: Delete a Donation
    public static function deleteDonation($donationID)
    {
        $sql = "DELETE FROM donation WHERE donationID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $donationID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Donation deleted successfully!" : "Failed to delete donation.";
    }

    // Method: Process Donation using a Payment Strategy
    public function processDonation($strategy, $amount)
    {
        if ($strategy instanceof PaymentStrategy) {
            $result = $strategy->processPayment($amount);
            return $result ? "Donation processed successfully!" : "Failed to process donation.";
        } else {
            throw new Exception("Invalid payment strategy.");
        }
    }

    // Method: Schedule Equipment Delivery
    public function scheduleEquipmentDelivery($equipmentDetails, $deliveryDate)
    {
        $sql = "INSERT INTO equipment_deliveries (donationID, equipmentDetails, deliveryDate) VALUES (?, ?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $this->donationID, $equipmentDetails, $deliveryDate);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->logActivity("Scheduled equipment delivery: $equipmentDetails on $deliveryDate");
            return "Equipment delivery scheduled successfully!";
        }
        return "Failed to schedule equipment delivery.";
    }

    // Method: Generate Invoice
    public function generateInvoice()
    {
        $invoice = "Invoice for Donation ID: $this->donationID\n";
        $invoice .= "Donor ID: $this->donorID\n";
        $invoice .= "Type: $this->type\n";
        $invoice .= "Amount: $$this->amount\n";
        $invoice .= "Description: $this->description\n";
        $invoice .= "Schedule: $this->schedule\n";
        $invoice .= "Status: $this->status\n";
        return $invoice;
    }

    // Observer Methods: Attach an Observer
    public function attach($observer)
    {
        $this->observers[] = $observer;
    }

    // Observer Methods: Detach an Observer
    public function detach($observer)
    {
        $this->observers = array_filter($this->observers, function ($obs) use ($observer) {
            return $obs !== $observer;
        });
    }

    // Observer Methods: Notify Observers
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}
?>
