<?php
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }

    $category = isset($_GET['category']) ? $_GET['category'] : null;

    // Modified query to include category title
    $sql = "SELECT i.itemCode, i.itemName, i.oumName, c.title 
            FROM item i 
            LEFT JOIN category c ON i.category_id = c.category_id";
    
    if ($category) {
        $sql .= " WHERE c.title = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param("s", $category);
    } else {
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }
    }

    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    $items = [];

    while ($row = $result->fetch_assoc()) {
        $items[] = [
            'itemCode' => $row['itemCode'],
            'itemName' => $row['itemName'],
            'title' => $row['title'], // Category title
            'oumName' => $row['oumName']
        ];
    }

    $response = [
        'status' => 'success',
        'items' => $items,
        'category' => $category,
        'itemCount' => count($items)
    ];

    echo json_encode($response);

} catch (Exception $e) {
    $error_response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
    echo json_encode($error_response);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>