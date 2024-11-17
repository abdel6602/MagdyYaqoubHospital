<?php
require_once "Staff.php"; // Import the parent class

class Nurse extends Staff
{
    public $nurseID;
    public $assignedPatients = [];
    public $ICUStatus;
    public $surgeries = [];

    public function __construct($staffID)
    {
        parent::__construct($staffID); // Initialize parent class (Staff)
        
        // Fetch Nurse-specific attributes if necessary
        $sql = "SELECT ICUStatus FROM nurse WHERE staffID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $staffID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $this->ICUStatus = $row["ICUStatus"];
        }

        // Fetch Surgeries assigned to Nurse
        $sql = "SELECT * FROM surgery_nurse WHERE nurseID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $staffID);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $this->surgeries[] = $row["surgeryID"];
        }
    }

    // Create method for adding a nurse
    public function createNurse($nurseData)
    {
        $sql = "INSERT INTO nurse (ICUStatus) VALUES (?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $nurseData['ICUStatus']);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Nurse added!" : "Failed to add nurse.";
    }

    // Read method for fetching a nurse by nurseID
    public function getNurseByID($nurseID)
    {
        $sql = "SELECT * FROM nurse WHERE nurseID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $nurseID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row; // Return nurse data as an array
        }
        return null; // No nurse found
    }

    // Update method for updating a nurse's ICU status
    public function updateNurseICUStatus($nurseID, $ICUStatus)
    {
        $sql = "UPDATE nurse SET ICUStatus=? WHERE nurseID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $ICUStatus, $nurseID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Nurse ICU status updated!" : "Failed to update ICU status.";
    }

    // Delete method for deleting a nurse by nurseID
    public function deleteNurse($nurseID)
    {
        // First, delete associated records like surgeries or patients
        $sql = "DELETE FROM nurse WHERE nurseID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $nurseID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Nurse deleted!" : "Failed to delete nurse.";
    }

    // Check vitals for surgeries
    public function checkVitals($patient, $vitals)
    {
        $sql = "INSERT INTO vitals (patientID, vitals) VALUES (?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $patient->patientID, json_encode($vitals));
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Vitals checked!" : "Failed to check vitals.";
    }

    // Report critical case for ICU
    public function reportCriticalCase($patient)
    {
        $report = "Patient " . $patient->patientID . " is in critical condition.";
        $sql = "INSERT INTO icu_report (patientID, report) VALUES (?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $patient->patientID, $report);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? $report : "Failed to report critical case.";
    }

    // Daily checkup for patients
    public function dailyCheckup($patients)
    {
        foreach ($patients as $patient) {
            $sql = "UPDATE patient SET status=? WHERE patientID=?";
            $conn = returnConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", "Checked", $patient->patientID);
            $stmt->execute();
        }
        return "Daily checkup completed!";
    }

    // Assist doctor
    public function assistDoctor($doctor)
    {
        $sql = "UPDATE doctor SET assistantNurseID=? WHERE doctorID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $this->nurseID, $doctor->doctorID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Assisted doctor!" : "Failed to assist doctor.";
    }

    // Update method based on subject
    public function update($subject)
    {
        $sql = "INSERT INTO update_log (subject, nurseID) VALUES (?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $subject, $this->nurseID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Update recorded!" : "Failed to record update.";
    }

    // Manage medicine
    public function manageMedicine($medicines)
    {
        foreach ($medicines as $medicine) {
            $sql = "UPDATE medicine SET stock=? WHERE medicineID=?";
            $conn = returnConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $medicine->stock, $medicine->medicineID);
            $stmt->execute();
        }
        return "Medicines managed!";
    }

    // Request medicine
    public function requestMedicine($medicine)
    {
        $sql = "INSERT INTO medicine_request (medicineID, nurseID) VALUES (?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $medicine->medicineID, $this->nurseID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Medicine requested!" : "Failed to request medicine.";
    }
}
?>
