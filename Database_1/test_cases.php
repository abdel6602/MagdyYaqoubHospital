<?php
require "Test_db.php";

/**
 * Scenario 1: Department and Room Relationship
 */
function testDepartmentAndRoom()
{
    echo "Testing Department and Room Relationship...\n";

    // Add Department
    insertDepartment("Cardiology");

    // Add Rooms linked to the department
    insertRoom("RM101", "general", 2, 1);
    insertRoom("RM102", "ICU", 1, 1);

    echo "Scenario 1 completed.\n\n";
}

/**
 * Scenario 2: Staff and Department Relationship
 */
function testStaffAndDepartment()
{
    echo "Testing Staff and Department Relationship...\n";

    // Add Staff linked to Department
    insertStaff("Dr. John Doe", "Doctor", 1, 10000, "johndoe", "password123", "Standard");
    insertStaff("Dr. Jane Smith", "Doctor", 1, 9000, "janesmith", "password123", "Standard");

    // Assign Dr. John Doe as the manager of Dr. Jane Smith
    $conn = returnConnection();
    $conn->query("UPDATE Staff SET managerID = 1 WHERE staffID = 2");
    echo "Manager assigned successfully.\n";

    echo "Scenario 2 completed.\n\n";
}

/**
 * Scenario 3: Staff and Schedule Relationship
 */
function testStaffAndSchedule()
{
    echo "Testing Staff and Schedule Relationship...\n";

    // Add Schedule
    insertSchedule("shift", "2024-11-18 08:00:00", "2024-11-18 16:00:00", "Room 101");

    // Assign the Schedule to Dr. John Doe
    $conn = returnConnection();
    $conn->query("UPDATE Staff SET shiftScheduleID = 1 WHERE staffID = 1");
    echo "Schedule assigned to staff successfully.\n";

    echo "Scenario 3 completed.\n\n";
}

/**
 * Scenario 4: Patient and Address Relationship
 */
function testPatientAndAddress()
{
    echo "Testing Patient and Address Relationship...\n";

    // Add Address
    $conn = returnConnection();
    $conn->query("INSERT INTO Address (street, city, country) VALUES ('123 Main St', 'Cairo', 'Egypt')");
    echo "Address added successfully.\n";

    // Add Patient linked to the address
    $conn->query("INSERT INTO Patient (name, age, admissionState, addressID) VALUES ('John Smith', 30, 'Admitted', 1)");
    echo "Patient added successfully.\n";

    echo "Scenario 4 completed.\n\n";
}

/**
 * Scenario 5: Prescription and Medicine Relationship
 */
function testPrescriptionAndMedicine() {
    echo "Testing Prescription and Medicine Relationship...\n";

    // Insert Medicines (if not already done)
    insertMedicine("Paracetamol", "tablet", 100, 2.5, "2025-12-31");
    insertMedicine("Ibuprofen", "tablet", 200, 3.0, "2025-11-30");

    // Insert Prescription
    insertPrescription(1, 1, "2024-11-18");

    // Add Medicines to Prescription
    insertPrescriptionMedicine(1, 1); // Add Paracetamol
    insertPrescriptionMedicine(1, 2); // Add Ibuprofen

    echo "Scenario 5 completed.\n\n";
}

/**
 * Scenario 6: Surgery and Related Entities
 */
function testSurgeryAndEntities() {
    echo "Testing Surgery and Related Entities...\n";

    // Insert Medicines (if not already done)
    insertMedicine("Paracetamol", "tablet", 100, 2.5, "2025-12-31");
    insertMedicine("Ibuprofen", "tablet", 200, 3.0, "2025-11-30");

    // Add Surgery
    insertSurgery(1, 1, 1, "Appendectomy", "scheduled", "Appendix removal");

    // Add Medicines to Surgery
    insertSurgeryMedicine(1, 1); // Add Paracetamol
    insertSurgeryMedicine(1, 2); // Add Ibuprofen

    // Add Nurses to Surgery
    $conn = returnConnection();
    $conn->query("INSERT INTO Surgery_Nurses (surgeryID, nurseID) VALUES (1, 3)");
    echo "Nurse added to surgery successfully.\n";

    echo "Scenario 6 completed.\n\n";
}


/**
 * Scenario 7: Donation and Donor Relationship
 */
function testDonationAndDonor()
{
    echo "Testing Donation and Donor Relationship...\n";

    // Add Donor
    insertDonor("John Smith", "frequent");

    // Add Donation
    insertDonation(1, 1000.50, "money", "processed", "credit_card");

    echo "Scenario 7 completed.\n\n";
}

/**
 * Scenario 8: Inventory and Items Relationship
 */
function testInventoryAndItems()
{
    echo "Testing Inventory and Items Relationship...\n";

    // Add Inventory
    $conn = returnConnection();
    $conn->query("INSERT INTO Inventory () VALUES ()");
    echo "Inventory created successfully.\n";

    // Add Inventory Items
    $conn->query("INSERT INTO InventoryItem (itemID, name, type, quantity, expiryDate) VALUES ('ITEM101', 'Syringe', 'medical', 100, '2025-01-01')");
    echo "Inventory item added successfully.\n";

    // Link Inventory to Items
    insertRoomToInventory(1, "ITEM101", 50);

    echo "Scenario 8 completed.\n\n";
}

/**
 * Scenario 9: SupplyOrder and Supplier Relationship
 */
function testSupplyOrderAndSupplier()
{
    echo "Testing SupplyOrder and Supplier Relationship...\n";

    // Add Supplier
    insertSupplier("SUP101", "Medical Supplies Co.", "123-456-7890");

    // Add Supply Order
    insertSupplyOrder("ORD001", "SUP101", "pending", "2024-11-17", "2024-11-20");

    echo "Scenario 9 completed.\n\n";
}

/**
 * Run All Test Scenarios
 */
function runAllTests()
{
    testDepartmentAndRoom();
    testStaffAndDepartment();
    testStaffAndSchedule();
    testPatientAndAddress();
    testPrescriptionAndMedicine();
    testSurgeryAndEntities();
    testDonationAndDonor();
    testInventoryAndItems();
    testSupplyOrderAndSupplier();
}

// Run the tests
runAllTests();



