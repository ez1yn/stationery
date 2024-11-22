<?php
// db_connection.php
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();

try {
    $host = 'localhost';
    $dbname = 'stationery';
    $username = 'root';  
    $password = '';     

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    header('Content-Type: application/json');
    die(json_encode([
        'success' => false,
        'error' => 'Connection failed: ' . $e->getMessage()
    ]));
}
?>

