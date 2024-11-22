<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// For GET requests (fetching cart items)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getCart') {
    getCart($conn);
    exit;
}

// For POST requests (adding, updating, removing items)
$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'] ?? '';

switch ($action) {
    case 'updateItem':
        updateCartItem($conn, $data);
        break;
    case 'removeItem':
        removeCartItem($conn, $data);
        break;
    case 'removeMultiple':
        $staffName = $_SESSION['staffName'];
        $items = $data['items'] ?? [];
        $success = removeMultipleItems($conn, $staffName, $items);
        echo json_encode(['success' => $success]);
        break;
    default:
        echo json_encode(['error' => 'Invalid action']);
}

function getCart($conn) {
    $staffName = $_SESSION['staffName'];
    $sql = "SELECT * FROM cart WHERE staffName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $staffName);
    $stmt->execute();
    $result = $stmt->get_result();
    $cartItems = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($cartItems);
    $stmt->close();
}

function updateCartItem($conn, $data) {
    $staffName = $_SESSION['staffName'];
    $itemName = $data['itemName'];
    $quantityChange = (int)$data['quantity'];

    // Get current quantity
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE staffName = ? AND itemName = ?");
    $stmt->bind_param("ss", $staffName, $itemName);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentItem = $result->fetch_assoc();

    if ($currentItem) {
        $newQuantity = max(0, $currentItem['quantity'] + $quantityChange);

        if ($newQuantity > 0) {
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE staffName = ? AND itemName = ?");
            $stmt->bind_param("iss", $newQuantity, $staffName, $itemName);
            $stmt->execute();
            echo json_encode(['success' => true]);
        } else {
            // If quantity would be 0 or less, remove the item
            removeCartItem($conn, ['itemName' => $itemName]);
        }
    } else {
        echo json_encode(['error' => 'Item not found']);
    }
    $stmt->close();
}

function removeCartItem($conn, $data) {
    $staffName = $_SESSION['staffName'];
    $itemName = $data['itemName'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE staffName = ? AND itemName = ?");
    $stmt->bind_param("ss", $staffName, $itemName);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to remove item']);
    }
    $stmt->close();
}

function removeMultipleItems($conn, $staffName, $items) {
    $success = true;
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        foreach ($items as $item) {
            $stmt = $conn->prepare("DELETE FROM cart WHERE staffName = ? AND itemName = ?");
            $stmt->bind_param("ss", $staffName, $item['itemName']);
            if (!$stmt->execute()) {
                throw new Exception("Failed to remove item: " . $item['itemName']);
            }
            $stmt->close();
        }
        
        // If all deletions successful, commit transaction
        $conn->commit();
        return true;
    } catch (Exception $e) {
        // If any deletion fails, rollback all changes
        $conn->rollback();
        return false;
    }
}

$conn->close();
?>