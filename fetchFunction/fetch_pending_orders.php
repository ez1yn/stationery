<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Modified query to fetch both pending and order status
    $sql = "SELECT idOrder, user_id, staffName, itemName, quantity, quantitySupply,
            remarks, serviceName, dateRequested, dateDelivered, deliveredStatus
            FROM orderdetails
            WHERE deliveredStatus IN ('Pending', 'Order')
            ORDER BY dateRequested DESC";
    
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception("SQL Error: " . $conn->error);
    }
    
    $orders = [];
    while($row = $result->fetch_assoc()) {
        $orders[] = [
            'orderId' => $row['idOrder'],
            'userId' => $row['user_id'],
            'staffName' => $row['staffName'],
            'itemName' => $row['itemName'],
            'quantity' => $row['quantity'],
            'quantityS' => $row['quantitySupply'],
            'remarks' => $row['remarks'],
            'servicesName' => $row['serviceName'],
            'dateR' => $row['dateRequested'],
            'dateS' => $row['dateDelivered'],
            'status' => $row['deliveredStatus']
        ];
    }
    
    echo json_encode(['success' => true, 'data' => $orders]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>