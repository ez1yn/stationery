<?php
// Prevent ANY output before headers
ob_start();

// Disable error display for security reasons
ini_set('display_errors', 0);
error_reporting(0);

// Set JSON headers
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

// Function to send JSON response and exit
function sendJsonResponse($success, $data = null, $error = null) {
    ob_clean(); // Clear any output buffering
    echo json_encode([
        'success' => $success,
        'data' => $data,
        'error' => $error
    ]);
    exit;
}

try {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stationery";

    $pdo = new PDO(
        "mysql:host=$servername;dbname=$dbname;charset=utf8",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

    // Start session and get user_id
    session_start();

    if (!isset($_SESSION['user_id'])) {
        sendJsonResponse(false, null, 'User not authenticated');
    }

    $user_id = $_SESSION['user_id']; // Fetch user_id from session

    // Prepare and execute query
    $stmt = $pdo->prepare("
        SELECT 
            idOrder,
            itemName,
            quantity,
            quantitySupply,
            remarks,
            staffName,
            serviceName,
            DATE_FORMAT(dateRequested, '%Y-%m-%d %H:%i:%s') as dateRequested,
            DATE_FORMAT(dateDelivered, '%Y-%m-%d %H:%i:%s') as dateDelivered,
            deliveredStatus
        FROM orderdetails 
        WHERE user_id = ? 
        AND deliveredStatus = 'pending'
        ORDER BY dateRequested DESC
    ");

    $stmt->execute([$user_id]);
    $orders = $stmt->fetchAll();

    if (empty($orders)) {
        // Send response indicating no orders, without an error
        sendJsonResponse(true, null, 'No pending orders');
    } else {
        // Send success response with orders data
        sendJsonResponse(true, $orders);
    }

} catch (PDOException $e) {
    sendJsonResponse(false, null, 'Database error: ' . $e->getMessage());
} catch (Exception $ei) {
    sendJsonResponse(false, null, 'Server error: ' . $ei->getMessage());
}
?>
