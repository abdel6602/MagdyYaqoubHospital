<?php

class Patient
{
    public $patientID;
    public $name;
    public $age;
    public $medicalHistory = []; // List of medical history strings
    public $admissionState;
    public $addressID; // Self-referenced
    public $observers = []; // List of attached observers
    public $bills = []; // List of associated bills
    public $prescriptions = []; // List of prescriptions

    public function __construct($patientID)
    {
        if ($patientID != "") {
            $sql = "SELECT * FROM patient WHERE patientID=?";
            $conn = returnConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $patientID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $this->patientID = $row["patientID"];
                $this->name = $row["name"];
                $this->age = $row["age"];
                $this->admissionState = $row["admissionState"];
                $this->addressID = $row["addressID"];

                // Fetch medical history
                $historySql = "SELECT historyEntry FROM medical_history WHERE patientID=?";
                $historyStmt = $conn->prepare($historySql);
                $historyStmt->bind_param("s", $patientID);
                $historyStmt->execute();
                $historyResult = $historyStmt->get_result();
                while ($historyRow = $historyResult->fetch_assoc()) {
                    $this->medicalHistory[] = $historyRow["historyEntry"];
                }

                // Fetch bills
                $billsSql = "SELECT * FROM bills WHERE patientID=?";
                $billsStmt = $conn->prepare($billsSql);
                $billsStmt->bind_param("s", $patientID);
                $billsStmt->execute();
                $billsResult = $billsStmt->get_result();
                while ($billRow = $billsResult->fetch_assoc()) {
                    $this->bills[] = $billRow;
                }

                // Fetch prescriptions
                $prescriptionSql = "SELECT * FROM prescriptions WHERE patientID=?";
                $prescriptionStmt = $conn->prepare($prescriptionSql);
                $prescriptionStmt->bind_param("s", $patientID);
                $prescriptionStmt->execute();
                $prescriptionResult = $prescriptionStmt->get_result();
                while ($prescriptionRow = $prescriptionResult->fetch_assoc()) {
                    $this->prescriptions[] = $prescriptionRow;
                }
            }
        }
    }

    // CRUD: Create a new Patient
    public static function createPatient($name, $age, $admissionState, $addressID)
    {
        $sql = "INSERT INTO patient (name, age, admissionState, addressID) VALUES (?, ?, ?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siss", $name, $age, $admissionState, $addressID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Patient created successfully!" : "Failed to create patient.";
    }

    // CRUD: Update Patient Information (already exists in `updateData` method)

    // CRUD: Delete a Patient
    public static function deletePatient($patientID)
    {
        $sql = "DELETE FROM patient WHERE patientID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $patientID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Patient deleted successfully!" : "Failed to delete patient.";
    }

    // CRUD: Read Patient (already implemented in constructor)

    // Existing Method: Schedule an Appointment
    public function scheduleAppointment($appointment)
    {
        $sql = "INSERT INTO appointments (patientID, doctorID, appointmentDate) VALUES (?, ?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $this->patientID, $appointment["doctorID"], $appointment["appointmentDate"]);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Appointment scheduled!" : "Failed to schedule appointment.";
    }

    // Existing Method: Receive Treatment
    public function receiveTreatment($treatmentDetails)
    {
        $sql = "INSERT INTO treatments (patientID, treatmentDetails, treatmentDate) VALUES (?, ?, NOW())";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $this->patientID, $treatmentDetails);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Treatment received!" : "Failed to record treatment.";
    }

    // Existing Method: Update Medical History
    public function updateMedicalHistory($newHistory)
    {
        $sql = "INSERT INTO medical_history (patientID, historyEntry) VALUES (?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $this->patientID, $newHistory);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Medical history updated!" : "Failed to update history.";
    }

    // Existing Method: Get Bills
    public function getBills()
    {
        return $this->bills;
    }

    // Existing Method: Add a Bill
    public function addBill($bill)
    {
        $sql = "INSERT INTO bills (patientID, amount, billDate) VALUES (?, ?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sds", $this->patientID, $bill["amount"], $bill["billDate"]);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Bill added!" : "Failed to add bill.";
    }

    // Existing Observer Methods: Attach an Observer
    public function attach($observer)
    {
        $this->observers[] = $observer;
    }

    // Existing Observer Methods: Detach an Observer
    public function detach($observer)
    {
        $this->observers = array_filter($this->observers, function ($obs) use ($observer) {
            return $obs !== $observer;
        });
    }

    // Existing Observer Methods: Notify Observers
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}
?>
