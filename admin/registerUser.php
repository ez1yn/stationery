<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Register User</title>
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
            max-width: 550px;
            margin: 140px auto 40px;
            padding: 25px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .form-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #edf2f7;
        }

        .form-header h2 {
            font-size: 22px;
            margin: 0 0 5px 0;
            color: #2c3e50;
        }

        .form-header p {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #334155;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 85%;
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s ease;
            background-color: #fff;
            color: #334155;
            padding-right: 35px;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #2c3e50;
            box-shadow: 0 0 0 2px rgba(44, 62, 80, 0.1);
            outline: none;
        }

        .form-group .icon {
            position: absolute;
            right: 10px;
            top: 35px;
            color: #94a3b8;
            font-size: 14px;
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

            .navigation ul {
                flex-wrap: wrap;
                justify-content: center;
            }

            .btn-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        .form-group input:hover,
        .form-group select:hover {
            border-color: #94a3b8;
        }

        .form-group label::after {
            content: "*";
            color: #dc2626;
            margin-left: 4px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="top-header">
            <div class="logo">
                <a href="aHome2.html">
                    <img src="/stationery/images/kpjlogo.jpg" alt="KPJ Logo">
                </a>
            </div>
            <div class="page-title">Register New User</div>
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

    <div class="container">
        <div class="form-header">
            <h2>Register New User</h2>
            <p>Fill in the user details below</p>
        </div>

        <form id="registerUserForm">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <i class="fas fa-user icon"></i>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <i class="fas fa-lock icon"></i>
        </div>

        <div class="form-group">
            <label for="staffName">Staff Name</label>
            <input type="text" id="staffName" name="staffName" required>
            <i class="fas fa-id-badge icon"></i>
        </div>

        <div class="form-group">
            <label for="serviceName">Service Name</label>
            <select id="serviceName" name="serviceName" required>
                <option value="">Select a Service</option>
            </select>
            <i class="fas fa-hospital icon"></i>
        </div>

        <div class="form-group">
            <label for="userlevel">User Level</label>
            <select id="userlevel" name="userlevel" required>
                <option value="">Select user level</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select>
            <i class="fas fa-users-cog icon"></i>
        </div>

        <div class="btn-container">
            <button type="button" class="btn btn-secondary" onclick="cancelRegistration()">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="registerNewUser()">Register User</button>
        </div>
    </form>


    <script>
       document.addEventListener('DOMContentLoaded', function() {
            // Fetch the list of services from the backend
            fetch('/stationery/getFunction/getService.php')
                .then(response => response.json())
                .then(data => {
                    const serviceSelect = document.getElementById('serviceName');
                    if (data.success) {
                        // Populate the service dropdown with the fetched services
                        data.services.forEach(service => {
                            const option = document.createElement('option');
                            option.value = service;
                            option.textContent = service;
                            serviceSelect.appendChild(option);
                        });
                    } else {
                        alert('Error fetching service names: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error fetching services:', error);
                    alert('An error occurred while loading services.');
                });
        });

        function registerNewUser() {
            const form = document.getElementById('registerUserForm');
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            // Validate form data
            if (!data.username || !data.password || !data.staffName || !data.serviceName || !data.userlevel) {
                alert('Please fill in all required fields.');
                return;
            }

            // Sending data to the backend
            fetch('/stationery/crudFunction/addUser.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);  // Log the response to the console
                if (data.success) {
                    alert(data.message);  // Display success message
                    window.location.href = '/stationery/admin/user.php';  // Redirect to user management page
                } else {
                    alert(data.message || 'Registration failed');  // Display error message
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while registering the user.');  // Display generic error message
            });
        }



        function cancelRegistration() {
            if (confirm('Are you sure you want to cancel? All entered data will be lost.')) {
                window.location.href = '/stationery/admin/user.php';
            }
        }

        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                fetch('logout.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Logout successful!");
                            window.location.href = "index.html";
                        } else {
                            alert("Logout failed. Please try again.");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("An error occurred during logout.");
                    });
            }
        }

        function goHome() {
            window.location.href = "home.php";
        }
    </script>
</body>
</html>