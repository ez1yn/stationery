<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Get the ID and new category name from POST data
$id = $_POST['id'] ?? 0;
$title = $_POST['title'] ?? '';

if (empty($title) || $id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit;
}

// Prepare and bind
$stmt = $conn->prepare("UPDATE category SET title = ? WHERE id = ?");
$stmt->bind_param("si", $title, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Category updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>