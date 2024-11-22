<?php
session_start();  // Start the session
$user_id = $_SESSION['user_id'];  // Access user_id from session
require_once '../session_helper.php'; // Include the session helper

// Check if the user is logged in (user level check is not required here)
check_user_access();

// Page content starts here
?>

<?php
// Define the page title for this page
$page_title = "Order Confirmation";

// Include the header file
include('../userHeader.php');  // or the full path to your header file

// Page content starts here
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
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
            transition: all 0.2s ease;
        }

        .button-container button:hover {
            background-color: #f2f2f2;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
            max-width: 1000px;
            margin: 140px auto 40px;
            padding: 25px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
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

        .order-details, .user-details {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .order-details h2, .user-details h2 {
            color: #2c3e50;
            margin-top: 0;
            font-size: 18px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .item-list {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .item-card {
            padding: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin: 0;
            background-color: white;
            transition: all 0.2s ease;
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .item-card:hover {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-color: #94a3b8;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .item-detail:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #4a5568;
            min-width: 120px;
        }

        .detail-value {
            color: #2d3748;
        }
        .user-details p {
            margin: 10px 0;
            color: #64748b;
            font-size: 14px;
        }

        .user-details strong {
            color: #2c3e50;
        }

        .confirm-button {
            width: 100%;
            max-width: 200px;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            display: block;
            margin: 20px auto;
            text-align: center;
        }

        .confirm-button:hover {
            background-color: #34495e;
            transform: translateY(-1px);
        }

        .error {
            color: #dc2626;
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
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
        }
    </style>
</head>
<body>

<div class="container">
        <div class="form-header">
            <h2>Order Confirmation</h2>
        </div>
        <div class="order-details">
            <h2>Ordered Items</h2>
            <ul class="item-list" id="orderDetails"></ul>
        </div>
        <div class="user-details" id="userDetails">
            <h2>User Details</h2>
            <p><strong>Staff Name:</strong> <span id="staffName"></span></p>
            <p><strong>Services Name:</strong> <span id="serviceName"></span></p>
            <p><strong>User Level:</strong> <span id="userlevel"></span></p>
        </div>
        <button id="confirmOrderButton" class="confirm-button">Confirm Order</button>
        <div id="errorMessage" class="error"></div>

        <form id="orderForm" method="POST" action="submit_order.php" style="display: none;">
            <input type="hidden" name="staffName" id="hiddenStaffName">
            <input type="hidden" name="serviceName" id="hiddenServiceName">
            <input type="hidden" name="items" id="hiddenItems">
        </form>
    </div>

    <script>
        async function fetchUserData() {
            try {
                const response = await fetch('/stationery/fetchFunction/fetch_user_data.php');
                const contentType = response.headers.get('content-type');
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                // Check if response is actually JSON
                if (!contentType || !contentType.includes('application/json')) {
                    // If not JSON, get the text and show it for debugging
                    const text = await response.text();
                    console.error('Non-JSON response:', text);
                    throw new Error('Server returned non-JSON response');
                }

                const result = await response.json();
                
                if (!result.success) {
                    if (result.error && result.error.includes('User not logged in')) {
                        window.location.href = 'login.php';
                        return null;
                    }
                    throw new Error(result.error || 'Unknown error occurred');
                }
                
                return result.data;
            } catch (error) {
                console.error('Error:', error);
                // Show a user-friendly error message
                document.getElementById('errorMessage').textContent = 
                    'Unable to load user data. Please try refreshing the page or contact support.';
                return null;
            }
        }

        function displayOrderDetails(userData, orderedItems) {
            const orderDetailsList = document.getElementById('orderDetails');
            const errorMessage = document.getElementById('errorMessage');
            
            try {
                // Display ordered items
                if (orderedItems && orderedItems.length > 0) {
                    orderDetailsList.innerHTML = orderedItems.map(item => `
                        <li class="item-card">
                            <div class="item-detail">
                                <span class="detail-label">Item Name:</span>
                                <span class="detail-value">${item.itemName}</span>
                            </div>
                            <div class="item-detail">
                                <span class="detail-label">Quantity:</span>
                                <span class="detail-value">${item.quantity}</span>
                            </div>
                        </li>
                    `).join('');
                } else {
                    orderDetailsList.innerHTML = '<li class="item-card">No items in order</li>';
                }

                // Display user details
                if (userData) {
                    document.getElementById('staffName').textContent = userData.staffName || 'Not available';
                    document.getElementById('serviceName').textContent = userData.serviceName || 'Not available';
                    document.getElementById('userlevel').textContent = userData.userlevel || 'Not available';

                    // Update hidden form fields
                    document.getElementById('hiddenStaffName').value = userData.staffName || '';
                    document.getElementById('hiddenServiceName').value = userData.serviceName || '';
                    document.getElementById('hiddenItems').value = JSON.stringify(orderedItems);
                } else {
                    document.getElementById('userDetails').innerHTML = '<p>User data not available</p>';
                }
            } catch (error) {
                console.error('Error displaying order details:', error);
                errorMessage.textContent = 'Error displaying order details. Please try refreshing the page.';
            }
        }

        async function confirmOrder() {
            const errorMessage = document.getElementById('errorMessage');
            const confirmButton = document.getElementById('confirmOrderButton');
            
            try {
                confirmButton.disabled = true; // Prevent double submission
                
                const selectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];
                if (selectedItems.length === 0) {
                    throw new Error('No items selected for order');
                }

                const formData = new FormData();
                formData.append('staffName', document.getElementById('staffName').textContent);
                formData.append('serviceName', document.getElementById('serviceName').textContent);
                formData.append('items', JSON.stringify(selectedItems));

                const orderResponse = await fetch('/stationery/crudFuncUser/submit_order.php', {
                    method: 'POST',
                    body: formData
                });

                if (!orderResponse.ok) {
                    throw new Error(`Order submission failed: ${orderResponse.status}`);
                }

                const orderResult = await orderResponse.json();
                
                if (!orderResult.success) {
                    throw new Error(orderResult.error || 'Failed to submit order');
                }

                // Remove items from cart
                const cartResponse = await fetch('/stationery/fetchFunction/fetch_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'removeMultiple',
                        items: selectedItems
                    })
                });

                if (!cartResponse.ok) {
                    throw new Error('Failed to update cart');
                }

                const cartResult = await cartResponse.json();
                
                if (cartResult.success) {
                    localStorage.removeItem('selectedItems');
                    alert('Order submitted successfully!');
                    window.location.href = '/stationery/user/order.php';
                } else {
                    throw new Error('Failed to update cart after order submission');
                }
            } catch (error) {
                console.error('Order confirmation error:', error);
                errorMessage.textContent = error.message;
            } finally {
                confirmButton.disabled = false;
            }
        }

        window.onload = async function() {
            try {
                const selectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];
                console.log('Selected Items:', selectedItems);

                const userData = await fetchUserData();
                console.log('User Data:', userData);

                displayOrderDetails(userData, selectedItems);
                
                document.getElementById('confirmOrderButton').addEventListener('click', confirmOrder);
            } catch (error) {
                console.error('Initialization error:', error);
                document.getElementById('errorMessage').textContent = 
                    'Error initializing page. Please refresh or contact support.';
            }
        };

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