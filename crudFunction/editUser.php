<?php
session_start();

// Enable error reporting for development
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// Set JSON header
header('Content-Type: application/json');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Handle GET request to retrieve user data
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET["userId"])) {
        echo json_encode(["success" => false, "error" => "User ID is required."]);
        exit();
    }

    $userId = sanitize_input($_GET["userId"]);

    $sql = "SELECT user_id, username, staffName, serviceName, userlevel FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(["success" => false, "error" => "Prepare statement failed: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("s", $userId);
    
    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "error" => "Query execution failed: " . $stmt->error]);
        exit();
    }

    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();

    if ($userData) {
        echo json_encode([
            "success" => true,
            "data" => $userData
        ]);
    } else {
        echo json_encode(["success" => false, "error" => "User not found"]);
    }

    $stmt->close();
} 
// Handle POST request to update user data
elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["success" => false, "error" => "Invalid JSON data"]);
        exit();
    }

    // Validate required fields
    $requiredFields = ['userId', 'username', 'staffName', 'serviceName', 'userlevel'];
    foreach ($requiredFields as $field) {
        if (!isset($input[$field]) || empty(trim($input[$field]))) {
            echo json_encode(["success" => false, "error" => "Missing required field: $field"]);
            exit();
        }
    }

    $userId = sanitize_input($input['userId']);
    $username = sanitize_input($input['username']);
    $staffName = sanitize_input($input['staffName']);
    $serviceName = sanitize_input($input['serviceName']);
    $userlevel = sanitize_input($input['userlevel']);

    if (!empty($input['password'])) {
        $sql = "UPDATE user SET username = ?, staffName = ?, serviceName = ?, userlevel = ?, password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $password = password_hash($input['password'], PASSWORD_DEFAULT);
        $stmt->bind_param("ssssss", $username, $staffName, $serviceName, $userlevel, $password, $userId);
    } else {
        $sql = "UPDATE user SET username = ?, staffName = ?, serviceName = ?, userlevel = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $staffName, $serviceName, $userlevel, $userId);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User updated successfully"]);
    } else {
        echo json_encode(["success" => false, "error" => "Update failed: " . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>