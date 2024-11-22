<?php
// Start the session to get session data (e.g., logged-in user)
session_start();

// Include the session helper to check user access (ensure user is logged in)
require_once '../session_helper.php';

// Check if the user is logged in (the session 'loggedin' flag should be set)
check_user_access();  // This will redirect to login if not logged in

// Database connection parameters (adjust to your actual database configuration)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for any connection errors
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Get the logged-in user's staff name (this could be another unique session variable)
$staffName = $_SESSION['staffName'];  // Assuming staffName is stored in the session

// Query to get the user details from the 'user' table
$sql = "SELECT username, staffName, serviceName FROM user WHERE staffName = ? LIMIT 1";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $staffName);  // Bind staffName as a parameter to prevent SQL injection
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists in the database
if ($result->num_rows > 0) {
    // Fetch the user data
    $userData = $result->fetch_assoc();
    
    // Return the user data as a JSON response
    echo json_encode([
        'success' => true,
        'username' => $userData['username'],
        'staffName' => $userData['staffName'],
        'serviceName' => $userData['serviceName']
    ]);
} else {
    // If no user found, return an error
    echo json_encode(['success' => false, 'error' => 'User not found']);
}

// Close the database connection
$stmt->close();
$conn->close();
?>
