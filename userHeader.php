<?php
session_start();
require_once '../session_helper.php';
check_user_access();
$pageTitle = isset($pageTitle) ? $pageTitle : "Home";
?>

<header class="header">
    <div class="top-header">
        <div class="logo">
            <a href="/stationery/user/home.php">
                <img src="/stationery/images/kpjlogo.jpg" alt="KPJ Logo">
            </a>
        </div>

        <div class="page-title">
            <?php echo isset($page_title) ? htmlspecialchars($page_title) : "Default Title"; ?>
        </div>

        <div class="button-container">
            <button title="Logout" onclick="confirmLogout()">
                <img src="/stationery/images/logout.jpg" alt="Logout" class="logout-icon">
            </button>
            <button title="Cart" onclick="goCart()">
                <img src="/stationery/images/addcart.png" alt="Cart" class="cart-icon">
            </button>
        </div>
    </div>

    <nav class="navigation">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="order.php">Order</a></li>
            <li><a href="pending.php">Pending</a></li>
            <li><a href="history.php">History</a></li>
            <li><a href="change_password.php">Change Password</a></li>
        </ul>
    </nav>
</header>


<script>
    function confirmLogout() {
        if (confirm("Are you sure you want to logout?")) {
            window.location.href = "logout.php"; 
        }
    }

    function goCart() {
        window.location.href = "cart.php"; n
    }
</script>
