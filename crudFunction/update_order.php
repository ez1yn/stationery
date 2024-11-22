<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

try {
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);
             
    if (!$data) {
        throw new Exception('No data received');
    }        

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement
    $sql = "UPDATE orderdetails SET 
            quantitySupply = ?,
            remarks = ?,
            dateDelivered = ?,
            deliveredStatus = ?
            WHERE idOrder = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("isssi", 
        $data['quantitySupply'],
        $data['remarks'],
        $data['dateSupply'],
        $data['status'],
        $data['orderId']
    );

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Request item status has been updated successfully']);
    } else {
        throw new Exception("Error executing statement: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
}
?>