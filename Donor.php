<?php
require_once("Donation.php");

class Donor
{
    public $donorID;
    public $name;
    public $type; // First-time, frequent, regular
    public $donations = []; // List of Donation objects
    public $contactInfo; // Additional attribute for CRUD operations

    public function __construct($donorID)
    {
        if ($donorID != "") {
            $sql = "SELECT * FROM donor WHERE donorID=?";
            $conn = returnConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $donorID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $this->donorID = $row["donorID"];
                $this->name = $row["name"];
                $this->type = $row["type"];
                $this->contactInfo = $row["contactInfo"];

                // Fetch donation history
                $donationSql = "SELECT * FROM donation WHERE donorID=?";
                $donationStmt = $conn->prepare($donationSql);
                $donationStmt->bind_param("i", $donorID);
                $donationStmt->execute();
                $donationResult = $donationStmt->get_result();
                while ($donationRow = $donationResult->fetch_assoc()) {
                    $this->donations[] = new Donation($donationRow["donationID"]);
                }
            }
        }
    }

    // CRUD: Create a new Donor
    public static function createDonor($name, $type, $contactInfo)
    {
        $sql = "INSERT INTO donor (name, type, contactInfo) VALUES (?, ?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $type, $contactInfo);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Donor created successfully!" : "Failed to create donor.";
    }

    // CRUD: Read Donor (already implemented in constructor)

    // CRUD: Update Donor Information
    public function updateDonor($name, $type, $contactInfo)
    {
        $sql = "UPDATE donor SET name=?, type=?, contactInfo=? WHERE donorID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $type, $contactInfo, $this->donorID);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->name = $name;
            $this->type = $type;
            $this->contactInfo = $contactInfo; // Update local object
            return "Donor information updated successfully!";
        }
        return "Failed to update donor information.";
    }

    // CRUD: Delete Donor
    public static function deleteDonor($donorID)
    {
        $sql = "DELETE FROM donor WHERE donorID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $donorID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Donor deleted successfully!" : "Failed to delete donor.";
    }

    // Method: Make a new Donation
    public function makeDonation($donation)
    {
        if ($donation instanceof Donation) {
            $sql = "INSERT INTO donation (donorID, type, amount, description, schedule) VALUES (?, ?, ?, ?, ?)";
            $conn = returnConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "isdss",
                $this->donorID,
                $donation->type,
                $donation->amount,
                $donation->description,
                $donation->schedule
            );
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $this->donations[] = $donation; // Update local donation history
                return "Donation made successfully!";
            }
            return "Failed to make donation.";
        } else {
            throw new Exception("Invalid donation object.");
        }
    }

    // Method: Get Donation History
    public function getDonationHistory()
    {
        return $this->donations;
    }
}
?>
