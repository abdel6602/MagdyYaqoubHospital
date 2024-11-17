<?php
require_once "Staff.php";

class Admin extends Staff
{
    public function __construct($staffID)
    {
        parent::__construct($staffID); // Initialize parent class (Staff)
    }


    // Create Admin (Example if an admin user needs to be added)
    public static function create($username, $password)
    {
        $sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Admin created successfully!" : "Failed to create admin.";
    }

    // Read Admin (Fetch admin by username)
    public static function read($username)
    {
        $sql = "SELECT * FROM admin WHERE username=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Update Admin (Example if password needs to be updated)
    public static function update($username, $newPassword)
    {
        $sql = "UPDATE admin SET password=? WHERE username=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $newPassword, $username);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Admin updated successfully!" : "Failed to update admin.";
    }

    // Delete Admin
    public static function delete($username)
    {
        $sql = "DELETE FROM admin WHERE username=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Admin deleted successfully!" : "Failed to delete admin.";
    }

    // Business Methods

    // Register Patient
    public function registerPatient($patient, $department)
    {
        $sql = "INSERT INTO patient_department (patientID, departmentID) VALUES (?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $patient->patientID, $department->departmentID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Patient registered successfully!" : "Failed to register patient.";
    }

    // Manage Logs
    public function manageLogs()
    {
        $sql = "SELECT * FROM logs";
        $conn = returnConnection();
        $result = $conn->query($sql);

        $logs = [];
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }

        return $logs;
    }

    // Dismiss Patient
    public function dismissPatient($patient, $department, $doctor)
    {
        $sql = "DELETE FROM patient_department WHERE patientID=? AND departmentID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $patient->patientID, $department->departmentID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $logSql = "INSERT INTO logs (message, doctorID, patientID) VALUES (?, ?, ?)";
            $logStmt = $conn->prepare($logSql);
            $message = "Patient dismissed from department.";
            $logStmt->bind_param("sii", $message, $doctor->doctorID, $patient->patientID);
            $logStmt->execute();
            return "Patient dismissed successfully!";
        } else {
            return "Failed to dismiss patient.";
        }
    }

    // Schedule Appointment
    public function scheduleAppointment($appointment)
    {
        $sql = "INSERT INTO appointments (scheduleID, patientID, doctorID, departmentID) VALUES (?, ?, ?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $appointment->scheduleID, $appointment->patientID, $appointment->doctorID, $appointment->departmentID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Appointment scheduled successfully!" : "Failed to schedule appointment.";
    }

    // Generate Report
    public function generateReport($reportType)
    {
        $sql = "";
        switch ($reportType) {
            case "patient":
                $sql = "SELECT * FROM patients";
                break;
            case "department":
                $sql = "SELECT * FROM departments";
                break;
            case "appointment":
                $sql = "SELECT * FROM appointments";
                break;
            default:
                return "Invalid report type.";
        }

        $conn = returnConnection();
        $result = $conn->query($sql);

        $report = [];
        while ($row = $result->fetch_assoc()) {
            $report[] = $row;
        }

        return $report;
    }
}
?>
