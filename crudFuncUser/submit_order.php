<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

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
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Get POST data
    $staffName = $_POST['staffName'];
    $serviceName = $_POST['serviceName'];
    $items = json_decode($_POST['items'], true);
    
    // Get user_id from session (NOT from POST data)
    $user_id = $_SESSION['user_id'];  // Use the user_id from the session

    // Insert orders into orderdetails table
    $stmt = $pdo->prepare("
        INSERT INTO orderdetails (
            user_id,
            itemName,
            quantity,
            quantitySupply,
            remarks,
            staffName,
            serviceName,
            dateRequested,
            deliveredStatus
        ) VALUES (
            ?, ?, ?, 0, '', ?, ?, NOW(), 'Order'
        )
    ");
    
    $insertedOrders = [];
    foreach ($items as $item) {
        $stmt->execute([
            $user_id,  // Use the session user_id here
            $item['itemName'],
            $item['quantity'],
            $staffName,
            $serviceName
        ]);
        $insertedOrders[] = $pdo->lastInsertId();
    }
    
    echo json_encode([
        'success' => true,
        'orderIds' => $insertedOrders,
        'message' => 'Order submitted successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
