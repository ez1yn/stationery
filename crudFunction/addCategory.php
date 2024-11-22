<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $title = trim($_POST['title']); // Trim whitespace
        
        // Check if category already exists
        $check_stmt = $conn->prepare("SELECT COUNT(*) as count FROM category WHERE title = ?");
        $check_stmt->bind_param("s", $title);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['count'] > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'A category with this name already exists. Please choose a different name.'
            ]);
            $check_stmt->close();
            $conn->close();
            exit;
        }
        $check_stmt->close();
        
        $uploadDir = '../images/categories/';
        
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $image_path = null;
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
            // Validate file extension
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($fileExtension, $allowed_extensions)) {
                throw new Exception('Invalid file type. Allowed types: jpg, jpeg, png, gif');
            }
            
            $newFileName = uniqid() . '.' . $fileExtension;
            $targetPath = $uploadDir . $newFileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $image_path = '/stationery/images/categories/' . $newFileName;
            } else {
                throw new Exception('Failed to move uploaded file');
            }
        }
        
        $stmt = $conn->prepare("INSERT INTO category (title, image_path) VALUES (?, ?)");
        if (!$stmt) {
            throw new Exception('Prepare statement failed: ' . $conn->error);
        }
        
        $stmt->bind_param("ss", $title, $image_path);
        
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true, 
                'message' => 'Category added successfully',
                'category_id' => $conn->insert_id,
                'title' => $title,
                'image_path' => $image_path
            ]);
        } else {
            throw new Exception('Error executing statement: ' . $stmt->error);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        // Delete uploaded file if it exists and there was an error
        if (isset($targetPath) && file_exists($targetPath)) {
            unlink($targetPath);
        }
        
        echo json_encode([
            'success' => false, 
            'message' => 'Error adding category: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>