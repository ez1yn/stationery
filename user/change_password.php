<?php
require_once '../session_helper.php'; 
check_user_access();
?>

<?php
$page_title = "Change Password";
include('../userHeader.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Change Password</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
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

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .logo {
            max-width: 70px;
        }

        .logo img {
            width: 100%;
            height: auto;
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
            max-width: 600px;
            margin: 140px auto 40px;
            padding: 25px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .table-container {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #e2e8f0;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f4f6f9;
        }

        .form-container {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #edf2f7;
        }

        .form-container label {
            font-weight: 500;
            color: #334155;
            font-size: 14px;
        }

        .form-container input {
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            width: 100%;
            font-size: 14px;
            margin-top: 5px;
        }

        .btn-container {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #edf2f7;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: #2c3e50;
            color: white;
        }

        .btn-secondary {
            background-color: #f1f5f9;
            color: #475569;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .btn:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .container {
                margin: 120px 15px 40px;
                padding: 20px;
            }

            .table-container {
                margin-bottom: 20px;
            }

            .btn-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
        <!-- User Info Table -->
        <div class="table-container">
            <table>
                <tr>
                    <th>Username</th>
                    <td id="username">Loading...</td>
                </tr>
                <tr>
                    <th>Staff Name</th>
                    <td id="staffName">Loading...</td>
                </tr>
                <tr>
                    <th>Service Name</th>
                    <td id="serviceName">Loading...</td>
                </tr>
            </table>
        </div>

        <!-- Password Change Section -->
        <div class="form-container">

            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" required>

            <label for="confirmPassword">Confirm New Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <div class="btn-container">
                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="changePassword()">Change Password</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadUserData(); // Load user data on page load
        });

        // Fetch user data to display on the page (excluding password)
        function loadUserData() {
            fetch('/stationery/fetchFunction/fetch_user.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('username').textContent = data.username || '';
                    document.getElementById('staffName').textContent = data.staffName || '';
                    document.getElementById('serviceName').textContent = data.serviceName || '';
                } else {
                    alert('Error loading user data: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading user data: ' + error.message);
            });
        }

        // Change password logic
        function changePassword() {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (!newPassword || !confirmPassword) {
                alert('Please fill in all password fields');
                return;
            }

            if (newPassword !== confirmPassword) {
                alert('New passwords do not match');
                return;
            }

            const data = {
                newPassword: newPassword
            };

            fetch('/stationery/crudFuncUser/update_pass.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Password changed successfully');
                    window.location.href = '/stationery/user/home.php';
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error changing password: ' + error.message);
            });
        }

        function cancelEdit() {
            if (confirm('Are you sure you want to cancel? All changes will be lost.')) {
                window.location.href = '/stationery/admin/user.php';
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
    </script>
    </body>
</html>