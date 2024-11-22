

<header class="header">
    <div class="top-header">
        <div class="logo">
            <a href="/stationery/admin/home.php">
                <img src="/stationery/images/kpjlogo.jpg" alt="KPJ Logo">
            </a>
        </div>

        <div class="page-title">
            <?php echo isset($page_title) ? htmlspecialchars($page_title) : "Home"; ?>
        </div>

        <div class="button-container">
            <button title="Logout" onclick="confirmLogout()">
                <img src="/stationery/images/logout.jpg" alt="Logout" class="logout-icon">
            </button>
            <button title="Home" onclick="goHome()">
                    <img src="/stationery/images/home.png" alt="Home" class="home-icon">
            </button>
        </div>
    </div>

    <nav class="navigation">
        <ul>
            <li><a href="request.php">List of Requests Items</a></li>
            <li><a href="supply.php">List of Supplied Items</a></li>
            <li><a href="item.php">List of Stationary Item</a></li>
            <li><a href="category.php">Categories of Stationary</a></li>
            <li><a href="user.php">User Management</a></li>
        </ul>
</header>