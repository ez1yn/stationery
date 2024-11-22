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
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

try {
    // Query to fetch all services
    $query = "SELECT serviceName FROM service ORDER BY serviceName ASC";
    $result = $conn->query($query);

    // Check if any service exists
    if ($result->num_rows > 0) {
        $services = [];
        while ($row = $result->fetch_assoc()) {
            $services[] = $row['serviceName'];
        }

        // Return services as JSON
        echo json_encode(["success" => true, "services" => $services]);
    } else {
        echo json_encode(["success" => false, "message" => "No services found."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "An error occurred: " . $e->getMessage()]);
} finally {
    // Close the database connection
    $conn->close();
}
?>

