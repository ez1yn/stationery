<?php
session_start();

// Function to generate a secure token
function generateSecureToken() {
    return bin2hex(random_bytes(32));
}

// Function to validate session and token
function validateSession() {
    // Check if session token exists and matches stored token
    return isset($_SESSION['auth_token']) && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

// Function to initialize authenticated page
function initializeAuthenticatedPage() {
    if (!validateSession()) {
        // Clear any existing session data
        session_unset();
        session_destroy();
        session_start();
        header("Location: /stationery/index.php?error=" . urlencode("Please login first"));
        exit;
    }
}

// Function to check user access
function checkUserAccess($requiredLevel) {
    if (!validateSession()) {
        session_unset();
        session_destroy();
        session_start();
        header("Location: /stationery/index.php?error=" . urlencode("Please login first"));
        exit;
    }

    // Check user level
    if (!isset($_SESSION['userLevel']) || $_SESSION['userLevel'] !== $requiredLevel) {
        $errorMessage = "Unauthorized access. This page is restricted to $requiredLevel users only.";
        
        // Redirect based on actual user level
        if (isset($_SESSION['userLevel']) && $_SESSION['userLevel'] === 'Admin') {
            header("Location: /stationery/admin/home.php?error=" . urlencode($errorMessage));
        } elseif (isset($_SESSION['userLevel']) && $_SESSION['userLevel'] === 'User') {
            header("Location: /stationery/user/home.php?error=" . urlencode($errorMessage));
        } else {
            header("Location: /stationery/index.php?error=" . urlencode($errorMessage));
        }
        exit;
    }
}

// Function to initialize session with token
function initializeUserSession($userData) {
    // Start fresh session and regenerate session ID
    session_unset();
    session_regenerate_id(true);
    
    // Set session data
    $_SESSION['loggedin'] = true;
    $_SESSION['auth_token'] = generateSecureToken();
    $_SESSION['user_id'] = $userData['user_id'];
    $_SESSION['username'] = $userData['username'];
    $_SESSION['userLevel'] = $userData['userLevel'];
    $_SESSION['staffName'] = $userData['staffName'];
    $_SESSION['serviceName'] = $userData['serviceName'];
}

// Function to display error messages
function displayError() {
    if (isset($_GET['error'])) {
        echo '<div class="error-message" style="
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ef9a9a;
            border-radius: 4px;
            text-align: center;">' . htmlspecialchars($_GET['error']) . '</div>';
    }
}

// Function to check if current page is in admin directory
function isAdminPage() {
    return strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
}

// Function to check if current page is in user directory
function isUserPage() {
    return strpos($_SERVER['PHP_SELF'], '/user/') !== false;
}
?>
