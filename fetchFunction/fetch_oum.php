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

$result = $conn->query("SELECT oumName FROM oum");
$oums = [];

while ($row = $result->fetch_assoc()) {
    $oums[] = $row;
}

echo json_encode($oums);
$conn->close();
?>
