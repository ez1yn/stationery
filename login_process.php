<?php
session_start();
require_once 'session_helper.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];  

    $stmt = $conn->prepare("SELECT user_id, username, password, userlevel, staffName, serviceName FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if ($password === $row['password']) {
            regenerate_session();  

            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['userlevel'] = $row['userlevel'];
            $_SESSION['staffName'] = $row['staffName'];
            $_SESSION['serviceName'] = $row['serviceName'];

            if ($row['userlevel'] === 'Admin') {
                header("Location: /stationery/admin/home.php");
            } else {
                header("Location: /stationery/user/home.php");
            }
            exit;
        } else {
            header("Location: index.php?error=" . urlencode("Invalid username or password"));
            exit;
        }
    } else {
        header("Location: index.php?error=" . urlencode("Invalid username or password"));
        exit;
    }

    $stmt->close();
}
$conn->close();
?>
