<?php
// Basic security headers
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Cache-Control: private, max-age=300'); // 5 minute cache

// Error handling function
function sendError($message, $code = 500) {
    http_response_code($code);
    echo json_encode(['error' => $message]);
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

try {
    // Create connection with error handling
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Set charset to ensure proper encoding
    $conn->set_charset("utf8mb4");

    // Configure MySQL session for better performance
    $conn->query("SET SESSION sql_mode = 'STRICT_TRANS_TABLES'");
    $conn->query("SET SESSION group_concat_max_len = 1000000");

    // Get and validate year parameter
    $year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
    
    if ($year < 2000 || $year > 2100) {
        throw new Exception("Invalid year parameter");
    }

    // Prepare the SQL query with optimized date handling
    $sql = "SELECT 
                idOrder,
                staffName,
                serviceName,
                itemName,
                quantity,
                quantitySupply,
                remarks,
                DATE_FORMAT(dateRequested, '%Y-%m-%d') as dateRequested,
                DATE_FORMAT(dateDelivered, '%Y-%m-%d') as dateDelivered,
                deliveredStatus
            FROM orderdetails 
            WHERE deliveredStatus IN ('Done', 'done', 'DONE')
                AND YEAR(dateDelivered) = ?
            ORDER BY dateDelivered DESC, idOrder DESC";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Query preparation failed: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("i", $year);
    
    // Execute with error handling
    if (!$stmt->execute()) {
        throw new Exception("Query execution failed: " . $stmt->error);
    }

    // Get results
    $result = $stmt->get_result();
    
    // Initialize array for results
    $orders = array();
    
    // Fetch results
    while ($row = $result->fetch_assoc()) {
        // Ensure all fields are properly handled
        $orders[] = array(
            'idOrder' => $row['idOrder'] ?? '',
            'staffName' => $row['staffName'] ?? '',
            'serviceName' => $row['serviceName'] ?? '',
            'itemName' => $row['itemName'] ?? '',
            'quantity' => $row['quantity'] ?? '',
            'quantitySupply' => $row['quantitySupply'] ?? '',
            'remarks' => $row['remarks'] ?? '',
            'dateRequested' => $row['dateRequested'] ?? '',
            'dateDelivered' => $row['dateDelivered'] ?? '',
            'deliveredStatus' => $row['deliveredStatus'] ?? ''
        );
    }

    // Close statement
    $stmt->close();
    
    // Send successful response
    echo json_encode($orders);

} catch (Exception $e) {
    // Log error (in production, you should use proper error logging)
    error_log("Error in fetch_completed_orders.php: " . $e->getMessage());
    
    // Send error response
    sendError("An error occurred while fetching the data");
} finally {
    // Close connection if it exists
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}

?>