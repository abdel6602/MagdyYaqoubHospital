<?php
class Schedule
{
    public $scheduleID;
    public $type;
    public $startDateTime;
    public $endDateTime;
    public $location;
    public $scheduleStrategy;
    public $surgeries = [];
    public $doctors = [];

    public function __construct($scheduleID)
    {
        $conn = returnConnection();
        $sql = "SELECT * FROM schedule WHERE scheduleID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $scheduleID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $this->scheduleID = $row["scheduleID"];
            $this->type = $row["type"];
            $this->startDateTime = $row["startDateTime"];
            $this->endDateTime = $row["endDateTime"];
            $this->location = $row["location"];
            $this->scheduleStrategy = $row["scheduleStrategy"];
        }

        // Fetch associated surgeries
        $sql = "SELECT * FROM surgery WHERE scheduleID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $scheduleID);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $this->surgeries[] = $row;
        }

        // Fetch associated doctors
        $sql = "SELECT staffID FROM schedule_staff WHERE scheduleID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $scheduleID);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $this->doctors[] = $row["staffID"];
        }
    }

    // Method to assign a schedule to staff
    public function assignToStaff($staff)
    {
        $sql = "INSERT INTO schedule_staff (scheduleID, staffID) VALUES (?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $this->scheduleID, $staff->staffID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Staff assigned to schedule." : "Failed to assign staff.";
    }

    // Method to update schedule dates
    public function updateSchedule($start, $end)
    {
        $sql = "UPDATE schedule SET startDateTime=?, endDateTime=? WHERE scheduleID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $start, $end, $this->scheduleID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Schedule updated." : "Failed to update schedule.";
    }

    // Method to cancel schedule
    public function cancelSchedule()
    {
        $sql = "DELETE FROM schedule WHERE scheduleID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $this->scheduleID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Schedule cancelled." : "Failed to cancel schedule.";
    }

    // CRUD methods
    public static function create($type, $startDateTime, $endDateTime, $location, $scheduleStrategy)
    {
        $sql = "INSERT INTO schedule (type, startDateTime, endDateTime, location, scheduleStrategy) VALUES (?, ?, ?, ?, ?)";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $type, $startDateTime, $endDateTime, $location, $scheduleStrategy);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Schedule created successfully." : "Failed to create schedule.";
    }

    public static function read($scheduleID)
    {
        $sql = "SELECT * FROM schedule WHERE scheduleID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $scheduleID);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function update($scheduleID, $type, $startDateTime, $endDateTime, $location, $scheduleStrategy)
    {
        $sql = "UPDATE schedule SET type=?, startDateTime=?, endDateTime=?, location=?, scheduleStrategy=? WHERE scheduleID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $type, $startDateTime, $endDateTime, $location, $scheduleStrategy, $scheduleID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Schedule updated successfully." : "Failed to update schedule.";
    }

    public static function delete($scheduleID)
    {
        $sql = "DELETE FROM schedule WHERE scheduleID=?";
        $conn = returnConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $scheduleID);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Schedule deleted successfully." : "Failed to delete schedule.";
    }
}
?>
