<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Get JSON input and decode it
$data = json_decode(file_get_contents('php://input'), true);

// Get staffName from session
$staffName = $_SESSION['staffName'];
$itemName = $data['itemName'];
$quantity = $data['quantity'];

// First check if item already exists in cart
$checkSql = "SELECT quantity FROM cart WHERE staffName = ? AND itemName = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ss", $staffName, $itemName);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    // Item exists, update quantity
    $row = $result->fetch_assoc();
    $newQuantity = $row['quantity'] + $quantity;
    
    $updateSql = "UPDATE cart SET quantity = ? WHERE staffName = ? AND itemName = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("iss", $newQuantity, $staffName, $itemName);
    
    if ($updateStmt->execute()) {
        echo json_encode(["success" => true, "message" => "Cart updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating cart"]);
    }
    $updateStmt->close();
} else {
    // Item doesn't exist, insert new record
    $insertSql = "INSERT INTO cart (staffName, itemName, quantity) VALUES (?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("ssi", $staffName, $itemName, $quantity);
    
    if ($insertStmt->execute()) {
        echo json_encode(["success" => true, "message" => "Item added to cart successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error adding item to cart"]);
    }
    $insertStmt->close();
}

$checkStmt->close();
$conn->close();
?>