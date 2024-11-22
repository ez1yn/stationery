<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function logout() {
    session_unset();   
    session_destroy();  
    header("Location: ../index.php"); 
    exit;
}

function check_admin_access() {
    if (!isset($_SESSION['loggedin']) || $_SESSION['userlevel'] !== 'Admin') {
        header("Location: index.php?error=" . urlencode("Unauthorized access. Please log in first."));
        exit;
    }
}

function check_user_access() {
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../index.php?error=" . urlencode("Please log in first."));
        exit;
    }
}

function regenerate_session() {
    session_regenerate_id(true); 
}
?>
