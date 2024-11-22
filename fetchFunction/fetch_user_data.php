<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Set headers for JSON response
header('Content-Type: application/json');

// Start session to access session variables
session_start();

// Check if the user is logged in by verifying session variable
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'error' => 'User not logged in'
    ]);
    exit;
}

try {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stationery";

    // Create PDO connection
    $pdo = new PDO(
        "mysql:host=$servername;dbname=$dbname;charset=utf8",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    // Get the logged-in user's ID from the session
    $user_id = $_SESSION['user_id'];

    // Prepare the query to fetch the logged-in user's data
    $stmt = $pdo->prepare("SELECT staffName, serviceName, userlevel FROM user WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the user data
    $userData = $stmt->fetch();

    if ($userData) {
        // Return the user data in the expected format
        echo json_encode([
            'success' => true,
            'data' => [
                'staffName' => $userData['staffName'],
                'serviceName' => $userData['serviceName'],
                'userlevel' => $userData['userlevel']
            ]
        ]);
    } else {
        throw new Exception('No user data found for this user');
    }

} catch (PDOException $e) {
    // Handle database errors
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database connection error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    // Handle other errors
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}