<?php
session_start();  

if (!isset($_SESSION['loggedin']) || $_SESSION['userlevel'] !== 'Admin') {
    header("Location: ../index.php?error=" . urlencode("Unauthorized access. Please log in first."));
    exit;
}
?>

<?php
// Define the page title for this page
$page_title = "List of User";

// Include the header file
include('../header.php');  // or the full path to your header file

// Page content starts here
?>

!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Pending Requests</title>
        <style>
             body, html {
                margin: 0;
                padding: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f0f8ff;
                color: #333;
            }
            .header {
                background-color: #2c3e50;
                color: #fff;
                padding: 10px 50px;
                display: flex;
                flex-direction: column;
                align-items: center;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 100;
            }
            .page-title {
                text-align: center;
                color: white;
                font-size: 24px;
                font-weight: bold;
                margin: 10px 0;
                padding: 10px;
                background-color: rgba(0,0,0,0.1);
                border-radius: 5px;
                width: 100%;
                max-width: 300px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .top-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
            }
            .logo {
                max-width: 150px;
            }
            .logo img {
                width: 100%;
                height: auto;
            }
            .search-container {
                margin: 20px auto;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .search-container input[type="text"] {
                padding: 10px;
                width: 600px;
                border-radius: 20px;
                border: 1px solid #ccc;
                transition: box-shadow 0.3s;
            }
            .search-container input[type="text"]:focus {
                box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            }
            .search-container button {
                padding: 10px 20px;
                background-color: #0056b3;
                color: white;
                border: none;
                border-radius: 20px;
                cursor: pointer;
                transition: background-color 0.3s, box-shadow 0.3s;
                margin-left: 10px;
            }
            .search-container button:hover {
                background-color: #004a99;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .button-container {
                display: flex;
                justify-content: right;
                align-items: center;
            }
            .button-container button {
                margin-left: 5px;
                padding: 8px;
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 50%;
                cursor: pointer;
                transition: background-color 0.3s, box-shadow 0.3s;
            }
            .button-container button:hover {
                background-color: #f2f2f2;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            .button-container img {
                width: 20px;
                height: 20px;
            }
            .navigation {
                display: flex;
                justify-content: center;
                background-color: #2c3e50;
                width: 100%;
                padding: 10px 0;
            }
            .navigation ul {
                list-style: none;
                display: flex;
                gap: 5px;
                padding: 0;
                margin: 0;
            }
            .navigation ul li a {
                color: white;
                text-decoration: none;
                padding: 10px 15px;
                transition: background-color 0.3s;
                border-radius: 4px;
            }
            .navigation ul li a:hover {
                background-color: #032558;
            }
            .container {
                max-width: 1200px;
                margin: 150px auto 40px; /* Adjusted top margin to accommodate fixed header */
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }


            .top-controls {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin: 20px 0;
                padding: 0 20px;
            }
            .action-buttons {
                display: flex;
                gap: 10px;
            }
            .btn {
                padding: 10px 20px;
                border: none;
                border-radius: 20px;
                cursor: pointer;
                transition: background-color 0.3s, box-shadow 0.3s;
                color: white;
            }
            .register-user-btn {
                background-color: #4CAF50;
            }
            .register-user-btn:hover {
                background-color: #45a049;
            }
            .print-btn {
                background-color: #0056b3;
            }
            .print-btn:hover {
                background-color: #004a99;
            }
            .navbar {
                display: flex;
                justify-content: center;
                margin-top: 10px;
            }
            .navbar a {
                color: white;
                text-decoration: none;
                padding: 10px 20px;
                border-radius: 5px;
                transition: background-color 0.3s, transform 0.3s;
            }
            .navbar a:hover {
                background-color: #0056b3;
                transform: scale(1.05);
            }
            .container {
                max-width: 1200px;
                margin: 40px auto;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            table {
                width: 100%;
                border-collapse: collapse;
                background-color: white;
                margin-top: 20px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 16px;
                text-align: left;
            }
            th {
                background-color: #2c3e50;
                color: white;
            }
            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            tr:hover {
                background-color: #f1f1f1;
                transition: background-color 0.3s;
            }
            .action-btn {
                padding: 5px 10px;
                border: none;
                border-radius: 3px;
                cursor: pointer;
                transition: background-color 0.3s, transform 0.3s;
                margin-right: 5px;
            }
            .edit-btn {
                background-color: #FFA500;
                color: white;
            }
            .edit-btn:hover {
                background-color: #FF8C00;
            }
            .delete-btn {
                background-color: #f44336;
                color: white;
            }
            .delete-btn:hover {
                background-color: #e53935;
            }

            .pagination-container {
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 20px 0;
                gap: 15px;
            }
            
            .pagination-btn {
                padding: 8px 15px;
                background-color: #2c3e50;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s, transform 0.3s;
            }
            
            .pagination-btn:hover {
                background-color: #34495e;
                transform: scale(1.05);
            }
            
            .pagination-btn:disabled {
                background-color: #cccccc;
                cursor: not-allowed;
                transform: none;
            }
            
            .page-info {
                font-size: 14px;
                color: #666;
            }
            
            .page-size-selector {
                padding: 5px;
                border-radius: 4px;
                border: 1px solid #ddd;
                margin-left: 10px;
            }
    </style>
</head>
<body>
    <header class="header">
        <div class="top-header">
            <div class="logo">
                <a href="/stationery/admin/home.php">
                    <img src="/stationery/images/kpjlogo.jpg" alt="KPJ Logo">
                </a>
            </div>
            <div class="page-title">List of User</div>
            <div class="button-container">
                <button title="Logout" onclick="confirmLogout()">
                    <img src="/stationery/images/logout.png" alt="Logout" class="logout-icon">
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
        </nav>
    </header>

        <div class="container" style="margin-top: 8%;">
            <!-- Rest of your content remains the same -->
            <div class="top-controls">
                <div class="search-container">
                    <input type="text" id="staffSearchInput" placeholder="Search by Staff Name...">
                    <button onclick="filterUsers()">Search</button>
                </div>
                <div class="action-buttons">
                    <button class="btn register-user-btn" onclick="registerUser()">Register User</button>
                    <button class="btn print-btn" onclick="printUserList()">Print</button>
                </div>
            </div>

            <table id="userTable">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Staff Name</th>
                        <th>Services Name</th>
                        <th>User Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <div class="pagination-container">
                <button id="prevPage" class="pagination-btn" onclick="changePage(-1)">← Previous</button>
                <span class="page-info">
                    Page <span id="currentPage">1</span> of <span id="totalPages">1</span>
                    (<span id="totalRecords">0</span> records)
                </span>
                <button id="nextPage" class="pagination-btn" onclick="changePage(1)">Next →</button>
            </div>
        </div>
    <script>

        let currentPage = 1;
        let usersPerPage = 20;
        let allUsers = [];

        function loadUserData() {
            console.log('Loading user data...');
            fetch('/stationery/getFunction/getNewUser.php?nocache=' + new Date().getTime())
                .then(response => response.json())
                .then(users => {
                    console.log('Received user data:', users);
                    allUsers = users;
                    // Store the original data
                    window.originalUsers = [...users];  // Keep a copy of the original data
                    updatePaginationInfo();
                    displayCurrentPage();
                })
                .catch(error => {
                    console.error('Error loading user data:', error);
                    alert('Error loading user data. Please check the console for more details.');
                });
        }

        function filterUsers() {
            const input = document.getElementById('staffSearchInput').value.toLowerCase().trim();
            
            if (input === '') {
                // If search box is empty, restore original data
                allUsers = [...window.originalUsers];
            } else {
                // Filter the original dataset
                allUsers = window.originalUsers.filter(user => 
                    user.staffName.toLowerCase().includes(input)
                );
            }
            
            // Reset to first page with results
            currentPage = 1;
            updatePaginationInfo();
            displayCurrentPage();
        }

        function updatePaginationInfo() {
            const totalPages = Math.ceil(allUsers.length / usersPerPage);
            document.getElementById('currentPage').textContent = currentPage;
            document.getElementById('totalPages').textContent = totalPages;
            document.getElementById('totalRecords').textContent = allUsers.length;
            
            // Update button states
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = currentPage === totalPages;
        }

        function displayCurrentPage() {
            const startIndex = (currentPage - 1) * usersPerPage;
            const endIndex = startIndex + usersPerPage;
            const usersToDisplay = allUsers.slice(startIndex, endIndex);
            const tableBody = document.querySelector('#userTable tbody');
            tableBody.innerHTML = '';

            if (usersToDisplay.length === 0) {
                // Display "No users found" message spanning all columns
                const columnsCount = document.querySelectorAll('#userTable th').length;
                const noDataRow = `
                    <tr>
                        <td colspan="${columnsCount}" style="text-align: center; padding: 20px; font-style: italic; color: #666;">
                            No users found
                        </td>
                    </tr>
                `;
                tableBody.innerHTML = noDataRow;
            } else {
                // Display user data as before
                usersToDisplay.forEach(user => {
                    const row = `
                        <tr data-user-id="${user.user_id}">
                            <td>${user.user_id}</td>
                            <td>${user.username}</td>
                            <td>${user.staffName}</td>
                            <td>${user.serviceName}</td>
                            <td>${user.userlevel}</td>
                            <td>
                                <button class="action-btn edit-btn" onclick="window.location.href='/stationery/admin/userEdit.php?userId=${user.user_id}'">Edit</button>
                                <button class="action-btn delete-btn" onclick="deleteUser('${user.user_id}')">Delete</button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            }
        }

        function changePage(delta) {
            const totalPages = Math.ceil(allUsers.length / usersPerPage);
            const newPage = currentPage + delta;
            
            if (newPage >= 1 && newPage <= totalPages) {
                currentPage = newPage;
                updatePaginationInfo();
                displayCurrentPage();
            }
        }

        function deleteUser(userId) {
            if (!userId) {
                console.error('Invalid user ID:', userId);
                alert('Invalid user ID provided');
                return;
            }

            if (confirm('Are you sure you want to delete this user?')) {
                const formData = new FormData();
                formData.append('user_id', userId);

                fetch('/stationery/crudFunction/deleteUser.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove user from allUsers array
                        allUsers = allUsers.filter(user => user.user_id !== userId);
                        updatePaginationInfo();
                        displayCurrentPage();
                        alert(data.message);
                    } else {
                        throw new Error(data.error || 'Error deleting user');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting user: ' + error.message);
                });
            }
        }

        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                // Update the path to match your actual logout.php location
                fetch('../logout.php')  // Adjust this path based on your folder structure
                    .then(response => {
                        // First check if the response is ok
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text(); // Use text() instead of json() since we might get a redirect
                    })
                    .then(result => {
                        // Check if it's JSON
                        try {
                            const data = JSON.parse(result);
                            if (data.success) {
                                window.location.href = "../index.php";  // Adjust this path to your login page
                            }
                        } catch (e) {
                            // If it's not JSON, check if we were redirected
                            if (result.includes("login") || result.includes("index")) {
                                window.location.href = "../index.php";  // Adjust this path to your login page
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Even if there's an error, we should still redirect to the login page
                        window.location.href = "../index.php";  // Adjust this path to your login page
                    });
            }
        }

        function goHome() {
            window.location.href = "/stationery/admin/home.php";
        }

        function registerUser() {
            window.location.href = '/stationery/admin/registerUser.php';
        }

        
        function printUserList() {
            window.print();
        }

        // Load user data when the page loads
        window.onload = loadUserData;
    </script>
</body>
</html>