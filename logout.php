<?php
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Destroy the session
session_destroy();

// If this is an AJAX request
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
} else {
    // If it's a regular request, redirect to login page
    header("Location: index.php");
    exit;
}
?>