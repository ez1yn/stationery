<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode([]));
}

$result = $conn->query("SELECT category_id, title, image_path FROM category");
$categories = [];

while ($row = $result->fetch_assoc()) {
    // If no image path is set, use a default image
    if (empty($row['image_path'])) {
        $row['image_path'] = '/stationery/images/default-category.jpg';
    }
    $categories[] = $row;
}

echo json_encode($categories);
$conn->close();
?>