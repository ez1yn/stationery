<?php
header('Content-Type: application/json');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

try {
    // Create connection with PDO for better error handling
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get the category_id from POST data
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    
    if ($category_id <= 0) {
        throw new Exception('Invalid category ID provided.');
    }

    // Begin transaction
    $conn->beginTransaction();
    
    // First check if the category exists
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM category WHERE category_id = ?");
    $checkStmt->execute([$category_id]);
    $exists = $checkStmt->fetchColumn();
    
    if (!$exists) {
        throw new Exception('Category not found.');
    }
    
    // First delete all items associated with this category
    $deleteItemsStmt = $conn->prepare("DELETE FROM item WHERE category_id = ?");
    $deleteItemsStmt->execute([$category_id]);
    
    // Then delete the category
    $deleteCategoryStmt = $conn->prepare("DELETE FROM category WHERE category_id = ?");
    $deleteCategoryStmt->execute([$category_id]);
    
    // Commit transaction
    $conn->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Category and associated items deleted successfully.'
    ]);
    
} catch (PDOException $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>