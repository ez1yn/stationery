<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if all required fields are set
if (!isset($_POST['itemCode'], $_POST['itemName'], $_POST['category_id'], $_POST['oumName']) ||
    empty(trim($_POST['itemCode'])) || empty(trim($_POST['itemName'])) ||
    empty(trim($_POST['category_id'])) || empty(trim($_POST['oumName']))) {
    $message = "Error: All fields are required.";
    header("Location: /stationery/admin/addItem.php?message=" . urlencode($message));
    exit();
}

$itemCode = trim($_POST['itemCode']);
$itemName = trim($_POST['itemName']);
$category_id = isset($_POST['category_id']) ? trim($_POST['category_id']) : null;
$oumName = trim($_POST['oumName']);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the item code already exists
$checkStmt = $conn->prepare("SELECT itemCode FROM item WHERE itemCode = ?");
$checkStmt->bind_param("s", $itemCode);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    $message = "Error: Item code already exists. Please use a different code.";
} else {
    // Find the first available ID (gap in sequence)
    $query = "SELECT t1.id + 1 AS gap_start
              FROM item t1
              LEFT JOIN item t2 ON t1.id + 1 = t2.id
              WHERE t2.id IS NULL
              ORDER BY t1.id
              LIMIT 1";
              
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        // Gap found, use the first available ID
        $row = $result->fetch_assoc();
        $nextId = $row['gap_start'];
    } else {
        // No gaps found, get the next sequential ID
        $query = "SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM item";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $nextId = $row['next_id'];
    }

    // Insert the new item with the determined ID
    $stmt = $conn->prepare("INSERT INTO item (id, itemCode, itemName, category_id, oumName) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $nextId, $itemCode, $itemName, $category_id, $oumName);

    if ($stmt->execute()) {
        $message = "Item registered successfully";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

if (empty($category_id)) {
    $message = "Error: Category ID is required.";
    header("Location: /stationery/admin/addItem.php?message=" . urlencode($message));
    exit();
}

$checkStmt->close();
$conn->close();

// Redirect with message
header("Location: /stationery/admin/item.php?message=" . urlencode($message));
exit();
?>