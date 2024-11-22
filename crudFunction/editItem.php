<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start output buffering
ob_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Function to fetch item data
function getItemData($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM item WHERE id = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return null;
    }
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        return null;
    }
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

// Handle GET request to fetch item data
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $item = getItemData($conn, $id);
    if ($item) {
        error_log("Item found: " . json_encode($item));
        echo json_encode(["success" => true, "data" => $item]);
    } else {
        error_log("Item not found for ID: " . $id);
        echo json_encode(["success" => false, "message" => "Item not found"]);
    }
}
// Handle POST request to update item
// Handle POST request to update item
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $itemCode = $data['itemCode'];  // Add itemCode here
    $itemName = $data['itemName'];
    $title = $data['title'];
    $oumName = $data['oumName'];

    // Update the SQL query to include itemCode
    $stmt = $conn->prepare("UPDATE item SET itemCode = ?, itemName = ?, title = ?, oumName = ? WHERE id = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
    } else {
        $stmt->bind_param("ssssi", $itemCode, $itemName, $title, $oumName, $id);  // Add itemCode here

        if ($stmt->execute()) {
            $updatedItem = getItemData($conn, $id);
            echo json_encode(["success" => true, "message" => "Item updated successfully", "data" => $updatedItem]);
        } else {
            error_log("Execute failed: " . $stmt->error);
            echo json_encode(["success" => false, "message" => "Error updating item: " . $stmt->error]);
        }

        $stmt->close();
    }
}


$conn->close();

// End output buffering and flush output
ob_end_flush();
?>