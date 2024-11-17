<?php

require 'databaseConnection.php';
// Testing database connection
DatabaseConnection::getInstance()->closeConnection();

/**
 * Insert Department
 */
function insertDepartment($name)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Department (name) VALUES ('$name')";

    if ($conn->query($sql) === TRUE) {
        echo "New department created successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

/**
 * Insert Room
 */
function insertRoom($roomID, $type, $capacity, $departmentID)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Room (roomID, type, capacity, departmentID) 
            VALUES ('$roomID', '$type', $capacity, $departmentID)";

    if ($conn->query($sql) === TRUE) {
        echo "New room created successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

/**
 * Insert Staff
 */
function insertStaff($name, $level, $depart_ID, $salary, $username, $password, $loginStrategy)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Staff (name, level, depart_ID, salary, username, password, loginStrategy) 
            VALUES ('$name', '$level', $depart_ID, $salary, '$username', '$password', '$loginStrategy')";

    if ($conn->query($sql) === TRUE) {
        echo "New staff created successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

/**
 * Insert Schedule
 */
function insertSchedule($type, $startDateTime, $endDateTime, $location)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Schedule (type, startDateTime, endDateTime, location) 
            VALUES ('$type', '$startDateTime', '$endDateTime', '$location')";

    if ($conn->query($sql) === TRUE) {
        echo "New schedule created successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

/**
 * Insert Appointment
 */
function insertAppointment($appointmentID, $patientID, $doctorID, $date, $status)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Appointment (appointmentID, patientID, doctorID, date, status) 
            VALUES ('$appointmentID', $patientID, $doctorID, '$date', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "New appointment created successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

/**
 * Insert Prescription
 */
function insertPrescription($patientID, $doctorID, $dateIssued)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Prescription (patientID, doctorID, dateIssued) 
            VALUES ($patientID, $doctorID, '$dateIssued')";

    if ($conn->query($sql) === TRUE) {
        echo "New prescription created successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

/**
 * Insert Medicine to Prescription
 */
function insertPrescriptionMedicine($prescriptionID, $medicineID)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Prescription_Medicines (prescriptionID, medicineID) 
            VALUES ($prescriptionID, $medicineID)";

    if ($conn->query($sql) === TRUE) {
        echo "New medicine added to prescription successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

/**
 * Insert Donation
 */
function insertDonation($donorID, $amount, $type, $status, $paymentStrategy)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Donation (donorID, amount, type, status, paymentStrategy) 
            VALUES ($donorID, $amount, '$type', '$status', '$paymentStrategy')";

    if ($conn->query($sql) === TRUE) {
        echo "New donation created successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

/**
 * Insert Donor
 */
function insertDonor($name, $type)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Donor (name, type) VALUES ('$name', '$type')";

    if ($conn->query($sql) === TRUE) {
        echo "New donor created successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

/**
 * Insert Surgery
 */
function insertSurgery($patientID, $doctorID, $scheduleID, $type, $status, $notes)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Surgery (patientID, doctorID, scheduleID, type, status, notes) 
            VALUES ($patientID, $doctorID, $scheduleID, '$type', '$status', '$notes')";

    if ($conn->query($sql) === TRUE) {
        echo "New surgery created successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

/**
 * Insert Medicine to Surgery
 */
function insertSurgeryMedicine($surgeryID, $medicineID)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Surgery_Medicines (surgeryID, medicineID) 
            VALUES ($surgeryID, $medicineID)";

    if ($conn->query($sql) === TRUE) {
        echo "New medicine added to surgery successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

/**
 * Insert Room to Inventory
 */
function insertRoomToInventory($inventoryID, $itemID, $quantity)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Inventory_Items (inventoryID, itemID, quantity) 
            VALUES ($inventoryID, '$itemID', $quantity)";

    if ($conn->query($sql) === TRUE) {
        echo "New item added to inventory successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

/**
 * Insert Supplier
 */
function insertSupplier($supplierID, $name, $contactInfo)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Supplier (supplierID, name, contactInfo) 
            VALUES ('$supplierID', '$name', '$contactInfo')";

    if ($conn->query($sql) === TRUE) {
        echo "New supplier created successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

/**
 * Insert Supply Order
 */
function insertSupplyOrder($orderID, $supplierID, $status, $orderDate, $deliveryDate)
{
    $conn = returnConnection();
    $sql = "INSERT INTO SupplyOrder (orderID, supplierID, status, orderDate, deliveryDate) 
            VALUES ('$orderID', '$supplierID', '$status', '$orderDate', '$deliveryDate')";

    if ($conn->query($sql) === TRUE) {
        echo "New supply order created successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}
function insertMedicine($name, $type, $stock, $price, $expiryDate)
{
    $conn = returnConnection();
    $sql = "INSERT INTO Medicine (name, type, stock, price, expiryDate) 
            VALUES ('$name', '$type', $stock, $price, '$expiryDate')";

    if ($conn->query($sql) === TRUE) {
        echo "New medicine added successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}

?>
