<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

try {
    // Get the logged-in staff name
    $staffName = $_SESSION['staffName'];

    // Query to get orders for the logged-in staff
    $orderSql = "SELECT o.idOrder, o.dateRequested, o.dateDelivered, o.deliveredStatus, 
                        o.itemName, o.quantity, o.quantitySupply, o.serviceName, 
                        o.staffName, o.remarks
                 FROM orderdetails o 
                 WHERE o.staffName = ?
                 ORDER BY o.dateRequested DESC";
    
    $stmt = $conn->prepare($orderSql);
    $stmt->bind_param("s", $staffName);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = [
            'idOrder' => $row['idOrder'],
            'dateRequested' => $row['dateRequested'],
            'dateDelivered' => $row['dateDelivered'],
            'deliveredStatus' => $row['deliveredStatus'],
            'itemName' => $row['itemName'],
            'quantity' => $row['quantity'],
            'quantitySupply' => $row['quantitySupply'],
            'serviceName' => $row['serviceName'],
            'staffName' => $row['staffName'],
            'remarks' => $row['remarks']
        ];
    }
    $stmt->close();

    // Debug output
    error_log("Orders data: " . print_r($orders, true));
    
    echo json_encode(['success' => true, 'data' => $orders]);

} catch (Exception $e) {
    error_log("Error in order.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    $conn->close();
}
?>