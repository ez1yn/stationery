<?php
header('Content-Type: application/json');

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Check if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user ID from the POST data
    $userId = isset($_POST['user_id']) ? $_POST['user_id'] : null;
    
    // Log received data
    error_log("Received delete request for user_id: " . $userId);
    
    // Validate user ID
    if (empty($userId)) {
        error_log("Empty user_id received");
        echo json_encode(["error" => "User ID is required"]);
        exit;
    }
    
    // Convert to integer and validate
    $userId = filter_var($userId, FILTER_VALIDATE_INT);
    if ($userId === false || $userId <= 0) {
        error_log("Invalid user_id format: " . $_POST['user_id']);
        echo json_encode(["error" => "Invalid user ID format"]);
        exit;
    }

    // --- Step 1: Delete related records from the orderdetails table ---
    // Prepare SQL statement to delete user-related records in orderdetails table
    $delete_orderdetails_stmt = $conn->prepare("DELETE FROM orderdetails WHERE user_id = ?");
    if (!$delete_orderdetails_stmt) {
        error_log("Delete preparation failed for orderdetails: " . $conn->error);
        echo json_encode(["error" => "Error preparing delete statement for orderdetails"]);
        exit;
    }
    
    $delete_orderdetails_stmt->bind_param("i", $userId);
    
    // Execute the statement
    if (!$delete_orderdetails_stmt->execute()) {
        error_log("Error deleting orderdetails for user_id: " . $userId . " - " . $delete_orderdetails_stmt->error);
        echo json_encode(["error" => "Error deleting related records from orderdetails"]);
        exit;
    }
    
    $delete_orderdetails_stmt->close();
    error_log("Deleted related orderdetails records for user_id: " . $userId);

    // --- Step 2: Check if the user exists in the user table ---
    $check_stmt = $conn->prepare("SELECT user_id FROM user WHERE user_id = ?");
    if (!$check_stmt) {
        error_log("Check preparation failed: " . $conn->error);
        echo json_encode(["error" => "Error preparing check statement"]);
        exit;
    }
    
    $check_stmt->bind_param("i", $userId);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows === 0) {
        $check_stmt->close();
        echo json_encode(["error" => "User not found"]);
        exit;
    }
    $check_stmt->close();
    
    // --- Step 3: Delete the user from the user table ---
    $stmt = $conn->prepare("DELETE FROM user WHERE user_id = ?");
    if (!$stmt) {
        error_log("Delete preparation failed: " . $conn->error);
        echo json_encode(["error" => "Error preparing delete statement for user"]);
        exit;
    }
    
    $stmt->bind_param("i", $userId);
    
    // Execute the statement
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            error_log("User deleted successfully: " . $userId);
            echo json_encode([
                "success" => true,
                "message" => "User and related orderdetails deleted successfully",
                "userId" => $userId
            ]);
        } else {
            error_log("No rows affected when deleting user: " . $userId);
            echo json_encode(["error" => "Error deleting user: no rows affected"]);
        }
    } else {
        error_log("Error executing delete statement: " . $stmt->error);
        echo json_encode(["error" => "Error deleting user: " . $stmt->error]);
    }
    
    // Close statement
    $stmt->close();
} else {
    error_log("Invalid request method: " . $_SERVER["REQUEST_METHOD"]);
    echo json_encode(["error" => "Invalid request method"]);
}

// Close connection
$conn->close();
?>
