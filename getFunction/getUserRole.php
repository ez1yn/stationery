<?php
header('Content-Type: application/json');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

// Create connection using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

try {
    // Query to fetch user roles
    $query = "SELECT userLevel FROM userrole"; // Adjust table and column names as needed
    $result = $conn->query($query);

    // Check if the query was successful
    if ($result === false) {
        throw new Exception("Database query failed: " . $conn->error);
    }

    // Fetch the data as an associative array
    $userLevels = [];
    while ($row = $result->fetch_assoc()) {
        $userLevels[] = $row['userLevel'];
    }

    // Return the data as JSON
    echo json_encode(['success' => true, 'userLevels' => $userLevels]);
} catch (Exception $e) {
    // Catch any exceptions and return the error message
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    // Close the database connection
    $conn->close();
}
?>
