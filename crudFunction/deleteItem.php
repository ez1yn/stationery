<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM item WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $result = $conn->query("SELECT MAX(id) AS max_id FROM item");
        $row = $result->fetch_assoc();
        $maxId = $row['max_id'] ? $row['max_id'] : 0; // If no items exist

        // Reset auto-increment value
        $newAutoIncrementValue = $maxId + 1;
        $conn->query("ALTER TABLE item AUTO_INCREMENT = $newAutoIncrementValue");

        echo json_encode(["success" => true, "message" => "Item deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error deleting item: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "No ID provided"]);
}

$conn->close();
?>