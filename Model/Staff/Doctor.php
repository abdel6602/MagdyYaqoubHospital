<?php
require_once("Staff.php");

class Doctor
{
    public $doctorID;
    public $name;
    public $specialization;
    public $appointments = []; // List of appointments
    public $surgeries = []; // List of surgeries

    public function __construct($doctorID)
    {
        if ($doctorID != "") {
            $sql = "SELECT * FROM doctor WHERE doctorID=?";
            $conn = returnConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $doctorID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $this->doctorID = $row["doctorID"];
                $this->name = $row["name"];
                $this->specialization = $row["specialization"];

                // Fetch appointments
                $appointmentSql = "SELECT * FROM appointments WHERE doctorID=?";
                $appointmentStmt = $conn->prepare($appointmentSql);
                $appointmentStmt->bind_param("i", $doctorID);
                $appointmentStmt->execute();
                $appointmentResult = $appointmentStmt->get_result();
                while ($appointmentRow = $appointmentResult->fetch_assoc()) {
                    $this->appointments[] = $appointmentRow;
                }

                // Fetch surgeries
                $surgerySql = "SELECT * FROM surgeries WHERE doctorID=?";
                $surgeryStmt = $conn->prepare($surgerySql);
                $surgeryStmt->bind_param("i", $doctorID);
                $surgeryStmt->execute();
                $surgeryResult = $surgeryStmt->get_result();
                while ($surgeryRow = $surgeryResult->fetch_assoc()) {
                    $this->surgeries[] = $surgeryRow;
                }
            }
        }
    }

    // CRUD: Create a New Doctor
    public static function createDoctor($name, $specialization)
    {
        $sql = "INSERT INTO doctor (name, specialization) VALUES (?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $specialization);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Doctor created successfully!" : "Failed to create doctor.";
    }

    // CRUD: Update Doctor Details
    public function updateDoctor($name, $specialization)
    {
        $sql = "UPDATE doctor SET name=?, specialization=? WHERE doctorID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $specialization, $this->doctorID);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->name = $name;
            $this->specialization = $specialization;
            return "Doctor updated successfully!";
        }
        return "Failed to update doctor.";
    }

    // CRUD: Delete a Doctor
    public static function deleteDoctor($doctorID)
    {
        $sql = "DELETE FROM doctor WHERE doctorID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $doctorID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Doctor deleted successfully!" : "Failed to delete doctor.";
    }

    // Method: Diagnose a Patient
    public function diagnose($patient, $diagnosis)
    {
        $sql = "INSERT INTO diagnoses (patientID, doctorID, diagnosis, diagnosisDate) VALUES (?, ?, ?, NOW())";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $patient->patientID, $this->doctorID, $diagnosis);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Patient diagnosed successfully!" : "Failed to diagnose patient.";
    }

    // Method: Write a Prescription
    public function writePrescription($patient, $medicines)
    {
        foreach ($medicines as $medicine) {
            $sql = "INSERT INTO prescriptions (patientID, doctorID, medicineName, prescriptionDate) VALUES (?, ?, ?, NOW())";
            $conn = returnConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $patient->patientID, $this->doctorID, $medicine);
            $stmt->execute();
        }
        return "Prescription written successfully!";
    }

    // Method: Schedule a Surgery
    public function scheduleSurgery($surgery, $patient)
    {
        $sql = "INSERT INTO surgeries (doctorID, patientID, surgeryType, surgeryDate) VALUES (?, ?, ?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $this->doctorID, $patient->patientID, $surgery["surgeryType"], $surgery["surgeryDate"]);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Surgery scheduled successfully!" : "Failed to schedule surgery.";
    }

    // Observer Method: Update
    public function update($subject)
    {
        $this->appointments = $subject->appointments;
    }
}
?>
