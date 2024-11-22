<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Update Request</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            min-width: 1200px;
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
            width: 95%;
            max-width: 800px;
            margin: 150px auto 40px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #2c3e50;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-control:disabled {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-update {
            background-color: #2196F3;
            color: white;
        }
        .btn-cancel {
            background-color: #dc3545;
            color: white;
        }
        .btn:hover {
            transform: scale(1.05);
        }
        .btn-update:hover {
            background-color: #1976D2;
        }
        .btn-cancel:hover {
            background-color: #c82333;
        }
        .status-select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            width: 100%;
        }
        .message {
            padding: 8px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            min-width: 300px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .success {
            background-color: #f8fafc;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
            <div class="page-title">List of Item</div>
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
    <div id="overlay" class="overlay">
        <div class="spinner">Loading...</div>
    </div>

        <div id="successMessage" class="message success"></div>
        <div id="errorMessage" class="message error"></div>
        
        <form id="updateForm">
            <div class="form-group">
                <label for="orderId">Order ID</label>
                <input type="text" id="orderId" class="form-control" disabled>
            </div>
            <div class="form-group">
                <label for="staffName">Staff Name</label>
                <input type="text" id="staffName" class="form-control" disabled>
            </div>
            <div class="form-group">
                <label for="itemName">Item Name</label>
                <input type="text" id="itemName" class="form-control" disabled>
            </div>
            <div class="form-group">
                <label for="quantityRequest">Quantity Requested</label>
                <input type="number" id="quantityRequest" class="form-control" disabled>
            </div>
            <div class="form-group">
                <label for="quantitySupply">Quantity Supply*</label>
                <input type="number" id="quantitySupply" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea id="remarks" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="servicesName">Services Name</label>
                <input type="text" id="servicesName" class="form-control" disabled>
            </div>
            <div class="form-group">
                <label for="dateRequested">Date Requested</label>
                <input type="text" id="dateRequested" class="form-control" disabled>
            </div>
            <div class="form-group">
                <label for="dateSupply">Date Supply*</label>
                <input type="date" id="dateSupply" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="status">Status*</label>
                <select id="status" class="status-select" required>
                    <option value="Pending">Pending</option>
                    <option value="Done">Done</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
            <div class="button-group">
                <button type="button" class="btn btn-cancel" onclick="goBack()">Cancel</button>
                <button type="submit" class="btn btn-update">Update</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the order ID from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const orderId = urlParams.get('id');
            
            // Try to get order data from localStorage
            const orderData = JSON.parse(localStorage.getItem('orderData'));
            
            if (orderData) {
                // If we have data in localStorage, use it
                populateForm(orderData);
            } else if (orderId) {
                // If no localStorage data but we have an ID, fetch from server
                fetchOrderDetails(orderId);
            } else {
                // No data available
                showError('No order data found');
                setTimeout(() => {
                    window.location.href = 'aPending.html';
                }, 2000);
            }
        });


        function fetchOrderDetails(orderId) {
            // Simulate fetching data from server (replace with actual API call)
            fetch(`/stationery/fetchFunction/fetch_order_details.php?id=${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        populateForm(data.order);
                    } else {
                        showError('Failed to load order details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Error loading order details');
                });
        }

        // Update the populateForm function to handle dates properly
        function populateForm(order) {
            document.getElementById('orderId').value = order.orderId;
            document.getElementById('staffName').value = order.staffName;
            document.getElementById('itemName').value = order.itemName;
            document.getElementById('quantityRequest').value = order.quantity;
            document.getElementById('quantitySupply').value = order.quantityS || '';
            document.getElementById('remarks').value = order.remarks || '';
            document.getElementById('servicesName').value = order.servicesName;
            document.getElementById('dateRequested').value = order.dateR;
            
            // Format the date supply if it exists
            if (order.dateS) {
                const dateSupply = new Date(order.dateS);
                document.getElementById('dateSupply').value = dateSupply.toISOString().split('T')[0];
            }
            
            document.getElementById('status').value = order.status;
        }


        document.getElementById('updateForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                orderId: document.getElementById('orderId').value,
                quantitySupply: document.getElementById('quantitySupply').value,
                remarks: document.getElementById('remarks').value,
                dateSupply: document.getElementById('dateSupply').value,
                status: document.getElementById('status').value
            };

            updateOrder(formData);
        });

        function showSuccess(message) {
            const successDiv = document.getElementById('successMessage');
            const overlay = document.getElementById('overlay');
            
            // Hide overlay if it was showing
            overlay.style.display = 'none';
            
            // Show success message
            successDiv.textContent = message;
            successDiv.style.display = 'block';
            
            // Hide error message if it was showing
            document.getElementById('errorMessage').style.display = 'none';
            
            // Automatically hide after 3 seconds
            setTimeout(() => {
                successDiv.style.display = 'none';
            }, 3000);
        }

        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            const overlay = document.getElementById('overlay');
            
            // Hide overlay if it was showing
            overlay.style.display = 'none';
            
            // Show error message
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            
            // Hide success message if it was showing
            document.getElementById('successMessage').style.display = 'none';
            
            // Automatically hide after 3 seconds
            setTimeout(() => {
                errorDiv.style.display = 'none';
            }, 3000);
        }

        function updateOrder(formData) {
            document.getElementById('overlay').style.display = 'block';
            
            fetch('/stationery/crudFunction/update_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess('Request item status has been updated successfully');
                    localStorage.removeItem('orderData'); // Clear the stored data
                    
                    setTimeout(() => {
                        window.location.href = '/stationery/admin/supply.php';
                    }, 2000);
                } else {
                    showError(data.error || 'Failed to update order');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('An error occurred while updating the order');
            });
        }

        // Update form submission handler to prevent double submission
        document.getElementById('updateForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Disable submit button to prevent double submission
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            
            const formData = {
                orderId: document.getElementById('orderId').value,
                quantitySupply: document.getElementById('quantitySupply').value,
                remarks: document.getElementById('remarks').value,
                dateSupply: document.getElementById('dateSupply').value,
                status: document.getElementById('status').value
            };

            updateOrder(formData);
        });

        function goBack() {
            window.location.href = '/stationery/admin/request.php';
        }

        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "aHome2.html";
            }
        }

        function goHome() {
            window.location.href = "aHome2.html";
        }

        window.addEventListener('beforeunload', function() {
            localStorage.removeItem('orderData');
        });
    </script>
</body>
</html>