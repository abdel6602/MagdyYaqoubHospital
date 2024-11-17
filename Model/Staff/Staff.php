<?php
class Staff
{
    public $staffID;
    public $name;
    public $level;
    public $depart_ID;
    public $shiftSchedule; // Assume this is a Schedule object
    public $salary;
    public $username;
    public $password;
    public $managerID; // Self-referencing
    public $loginStrategy; // Assume this is a LoginStrategy object

    public function __construct($staffID)
    {
        if ($staffID != "") {
            $sql = "SELECT * FROM staff WHERE staffID=?";
            $conn = returnConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $staffID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $this->staffID = $row["staffID"];
                $this->name = $row["name"];
                $this->level = $row["level"];
                $this->depart_ID = $row["depart_ID"];
                $this->shiftSchedule = $this->fetchSchedule($row["scheduleID"]); // Fetch related schedule
                $this->salary = $row["salary"];
                $this->username = $row["username"];
                $this->password = $row["password"];
                $this->managerID = $row["managerID"];
                $this->loginStrategy = $this->fetchLoginStrategy($row["loginStrategyID"]); // Fetch related login strategy
            }
        }
    }

    // Fetch related schedule from the database
    private function fetchSchedule($scheduleID)
    {
        $sql = "SELECT * FROM schedule WHERE scheduleID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $scheduleID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row; // Assume the schedule is returned as an associative array
        }
        return null;
    }

    // Fetch related login strategy from the database
    private function fetchLoginStrategy($strategyID)
    {
        $sql = "SELECT * FROM login_strategy WHERE strategyID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $strategyID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row; // Assume the login strategy is returned as an associative array
        }
        return null;
    }

    // CRUD Operations
    public function createStaff($staffData)
    {
        $sql = "INSERT INTO staff (name, level, depart_ID, scheduleID, salary, username, password, managerID, loginStrategyID)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssiiisssi",
            $staffData['name'],
            $staffData['level'],
            $staffData['depart_ID'],
            $staffData['scheduleID'],
            $staffData['salary'],
            $staffData['username'],
            $staffData['password'],
            $staffData['managerID'],
            $staffData['loginStrategyID']
        );
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Staff created successfully!" : "Failed to create staff.";
    }

    public function getStaffByID($staffID)
    {
        $sql = "SELECT * FROM staff WHERE staffID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $staffID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row; // Return staff data as an array
        }
        return null;
    }

    public function updateStaff($staffID, $updates)
    {
        $sql = "UPDATE staff SET name=?, level=?, depart_ID=?, scheduleID=?, salary=?, username=?, password=?, managerID=?, loginStrategyID=? WHERE staffID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssiiisssii",
            $updates['name'],
            $updates['level'],
            $updates['depart_ID'],
            $updates['scheduleID'],
            $updates['salary'],
            $updates['username'],
            $updates['password'],
            $updates['managerID'],
            $updates['loginStrategyID'],
            $staffID
        );
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Staff updated successfully!" : "Failed to update staff.";
    }

    public function deleteStaff($staffID)
    {
        $sql = "DELETE FROM staff WHERE staffID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $staffID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Staff deleted successfully!" : "Failed to delete staff.";
    }

    // Methods
    public function updateShift($scheduleID)
    {
        $this->shiftSchedule = $this->fetchSchedule($scheduleID);
        $sql = "UPDATE staff SET scheduleID=? WHERE staffID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $scheduleID, $this->staffID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Shift schedule updated!" : "Failed to update shift schedule.";
    }

    public function logActivity($activity)
    {
        $sql = "INSERT INTO activity_log (staffID, activity, timestamp) VALUES (?, ?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $timestamp = date("Y-m-d H:i:s");
        $stmt->bind_param("iss", $this->staffID, $activity, $timestamp);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Activity logged!" : "Failed to log activity.";
    }

    public function login($loginStrategyID)
    {
        if ($this->loginStrategy['strategyID'] == $loginStrategyID) {
            return "Login successful!";
        }
        return "Login failed. Invalid strategy.";
    }
}
?>
