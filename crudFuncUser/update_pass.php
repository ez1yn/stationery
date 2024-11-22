<?php
session_start();
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

try {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['newPassword'])) {
        throw new Exception('Missing new password');
    }

    $user_id = $_SESSION['user_id'];
    $new_password = $data['newPassword'];

    // Create PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Get the current password from the database for the logged-in user
    $stmt = $pdo->prepare("SELECT password FROM user WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user) {
        throw new Exception('User not found');
    }

    // Update password in the database (Storing in plain text, no hashing)
    $update_stmt = $pdo->prepare("UPDATE user SET password = :password WHERE user_id = :user_id");
    $update_stmt->bindParam(':password', $new_password);
    $update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if (!$update_stmt->execute()) {
        throw new Exception('Failed to update password');
    }

    echo json_encode(['success' => true, 'message' => 'Password updated successfully']);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
