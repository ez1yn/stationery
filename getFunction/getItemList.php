<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT i.id, i.itemCode, i.itemName, c.title, i.oumName 
        FROM item i 
        LEFT JOIN category c ON i.category_id = c.category_id 
        ORDER BY i.id ASC";

$result = $conn->query($sql);
$items = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

echo json_encode($items);

$conn->close();
?>