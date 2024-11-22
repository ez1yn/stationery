<?php
// get_history_orders.php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once '../db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'error' => 'User not logged in'
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT 
            idOrder,
            user_id,
            itemName,
            quantity,
            quantitySupply,
            remarks,
            staffName,
            serviceName,
            dateRequested,
            dateDelivered,
            deliveredStatus
        FROM orderdetails 
        WHERE user_id = :user_id 
        AND deliveredStatus = 'done' 
        ORDER BY dateDelivered DESC
    ");
    
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => $orders
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>