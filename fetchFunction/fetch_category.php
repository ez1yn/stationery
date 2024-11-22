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
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Simple query to get all categories
    $sql = "SELECT * FROM category";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    $categories = [];
    while ($row = $result->fetch_assoc()) {
        // Ensure image_path has a default value if it's null
        if (empty($row['image_path'])) {
            $row['image_path'] = '/stationery/images/default-category.jpg';
        }
        $categories[] = $row;
    }

    echo json_encode([
        'status' => 'success',
        'categories' => $categories,
        'count' => count($categories)
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>