<?php
class Surgery
{
    public $surgeryID;
    public $patientID;
    public $doctorID;
    public $nurseIDs = [];
    public $scheduleID;
    public $type;
    public $requiredMedicines = [];
    public $status;
    public $notes;

    // Constructor
    public function __construct($surgeryID)
    {
        if ($surgeryID != "") {
            $sql = "SELECT * FROM surgery WHERE surgeryID=?";
            $conn = returnConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $surgeryID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $this->surgeryID = $row["surgeryID"];
                $this->patientID = $row["patientID"];
                $this->doctorID = $row["doctorID"];
                $this->scheduleID = $row["scheduleID"];
                $this->type = $row["type"];
                $this->status = $row["status"];
                $this->notes = $row["notes"];
            }

            // Fetch nurse IDs
            $nurseSql = "SELECT nurseID FROM surgery_nurses WHERE surgeryID=?";
            $nurseStmt = $conn->prepare($nurseSql);
            $nurseStmt->bind_param("i", $surgeryID);
            $nurseStmt->execute();
            $nurseResult = $nurseStmt->get_result();
            while ($nurseRow = $nurseResult->fetch_assoc()) {
                $this->nurseIDs[] = $nurseRow["nurseID"];
            }

            // Fetch required medicines
            $medicineSql = "SELECT * FROM surgery_medicines WHERE surgeryID=?";
            $medicineStmt = $conn->prepare($medicineSql);
            $medicineStmt->bind_param("i", $surgeryID);
            $medicineStmt->execute();
            $medicineResult = $medicineStmt->get_result();
            while ($medicineRow = $medicineResult->fetch_assoc()) {
                $this->requiredMedicines[] = $medicineRow;
            }
        }
    }

    // CRUD Methods

    // Create Surgery
    public static function create($patientID, $doctorID, $scheduleID, $type, $status, $notes)
    {
        $sql = "INSERT INTO surgery (patientID, doctorID, scheduleID, type, status, notes) VALUES (?, ?, ?, ?, ?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiisss", $patientID, $doctorID, $scheduleID, $type, $status, $notes);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Surgery created successfully!" : "Failed to create surgery.";
    }

    // Read Surgery
    public static function read($surgeryID)
    {
        return new Surgery($surgeryID); // Fetches surgery details via constructor.
    }

    // Update Surgery
    public function update($type, $status, $notes)
    {
        $sql = "UPDATE surgery SET type=?, status=?, notes=? WHERE surgeryID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $type, $status, $notes, $this->surgeryID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Surgery updated successfully!" : "Failed to update surgery.";
    }

    // Delete Surgery
    public function delete()
    {
        $sql = "DELETE FROM surgery WHERE surgeryID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->surgeryID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Surgery deleted successfully!" : "Failed to delete surgery.";
    }

    // Business Methods

    // Schedule surgery
    public function scheduleSurgery($schedule)
    {
        $sql = "UPDATE surgery SET scheduleID=? WHERE surgeryID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $schedule->scheduleID, $this->surgeryID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Surgery scheduled successfully!" : "Failed to schedule surgery.";
    }

    // Add a required medicine
    public function addMedicine($medicine)
    {
        $sql = "INSERT INTO surgery_medicines (surgeryID, medicineID) VALUES (?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $this->surgeryID, $medicine->medicineID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Medicine added successfully!" : "Failed to add medicine.";
    }

    // Remove a required medicine
    public function removeMedicine($medicine)
    {
        $sql = "DELETE FROM surgery_medicines WHERE surgeryID=? AND medicineID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $this->surgeryID, $medicine->medicineID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Medicine removed successfully!" : "Failed to remove medicine.";
    }

    // Update surgery status
    public function updateStatus($newStatus)
    {
        $sql = "UPDATE surgery SET status=? WHERE surgeryID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newStatus, $this->surgeryID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Status updated to $newStatus!" : "Failed to update status.";
    }

    // Assign staff (doctor and nurses) to surgery
    public function assignStaff($doctor, $nurses)
    {
        $conn = returnConnection();
        
        // Update doctor assignment
        $doctorSql = "UPDATE surgery SET doctorID=? WHERE surgeryID=?";
        $doctorStmt = $conn->prepare($doctorSql);
        $doctorStmt->bind_param("ii", $doctor->staffID, $this->surgeryID);
        $doctorStmt->execute();

        // Assign nurses
        $this->nurseIDs = []; // Clear previous nurses
        $nurseSql = "INSERT INTO surgery_nurses (surgeryID, nurseID) VALUES (?, ?)";
        $nurseStmt = $conn->prepare($nurseSql);

        foreach ($nurses as $nurse) {
            $nurseStmt->bind_param("ii", $this->surgeryID, $nurse->staffID);
            $nurseStmt->execute();
            if ($nurseStmt->affected_rows > 0) {
                $this->nurseIDs[] = $nurse->staffID;
            }
        }

        return "Staff assigned successfully!";
    }
}
?>
