<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.html"); 
    exit;
}

// Get the ordered item codes from the request
$itemCodes = isset($_GET['itemCodes']) ? explode(',', $_GET['itemCodes']) : [];

if (empty($itemCodes)) {
    echo json_encode(['error' => 'No item codes provided']);
    exit;
}

require_once "config.php"; // Include database connection

// Prepare a statement to fetch item details
$placeholders = implode(',', array_fill(0, count($itemCodes), '?'));
$sql = "SELECT itemCode, itemName, category, oum FROM items WHERE itemCode IN ($placeholders)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param(str_repeat('s', count($itemCodes)), ...$itemCodes);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    // Return item details as JSON
    echo json_encode($items);
} else {
    echo json_encode(['error' => 'Failed to prepare SQL statement']);
}

$stmt->close();
$conn->close();
?>