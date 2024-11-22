<?php
require_once '../session_helper.php';
check_user_access();
?>

<?php
$page_title = "History Order";
include("../userHeader.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>history</title>
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
            max-width: 150px;
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

        .pending-order {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 20px;
            padding: 15px;
            transition: all 0.2s ease;
        }

        .pending-order:hover {
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-color: #94a3b8;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 10px;
        }

        .order-items {
            margin-top: 15px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .item-details {
            flex-grow: 1;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            background-color: #fef3c7;
            color: #92400e;
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
            <h2>Your Order History</h2>
        </div>
        <div id="historyOrders">
            <!-- Completed orders will be loaded here -->
        </div>
    </div>

    <script>
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

        function goCart() {
            window.location.href = "/stationery/user/cart.php";
        }

        function fetchHistoryOrders() {
            const historyOrdersContainer = document.getElementById('historyOrders');
            historyOrdersContainer.innerHTML = '<p style="text-align: center;">Loading orders...</p>';

            fetch('/stationery/getFunction/getHistoryOrder.php', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Cache-Control': 'no-cache'
                },
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(result => {
                    console.log('Received data:', result);
                    
                    if (!result.success) {
                        throw new Error(result.error || 'Failed to fetch orders');
                    }
                    
                    const orders = result.data;
                    
                    if (!Array.isArray(orders) || orders.length === 0) {
                        historyOrdersContainer.innerHTML = '<p style="text-align: center;">No completed orders found.</p>';
                        return;
                    }

                    historyOrdersContainer.innerHTML = orders.map(order => {
                        // Format dates
                        const requestedDate = order.dateRequested ? new Date(order.dateRequested).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }) : 'N/A';

                        const deliveredDate = order.dateDelivered ? new Date(order.dateDelivered).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }) : 'N/A';

                        return `
                            <div class="pending-order">
                                <div class="order-header">
                                    <div>
                                        <h3>Order #${order.idOrder || 'N/A'}</h3>
                                        <p>Requested on: ${requestedDate}</p>
                                    </div>
                                    <span class="status-badge" style="background-color: #dcfce7; color: #3730a3;">
                                        Done
                                    </span>
                                </div>
                                <div class="order-items">
                                    <div class="order-item">
                                        <div class="item-details">
                                            <h4>${order.itemName || 'Unnamed Item'}</h4>
                                            <p>Service: ${order.serviceName || 'N/A'}</p>
                                            <p>Staff: ${order.staffName || 'N/A'}</p>
                                            <p>Remarks: ${order.remarks || 'None'}</p>
                                        </div>
                                        <div class="quantity">
                                            <p>Requested: ${order.quantity || '0'}</p>
                                            <p>Supply: ${order.quantitySupply || '0'}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="delivery-info">
                                    <p>Delivered on: ${deliveredDate}</p>
                                </div>
                            </div>
                        `;
                    }).join('');
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    historyOrdersContainer.innerHTML = `
                        <div style="text-align: center; color: red; padding: 20px;">
                            <p>Error loading history orders: ${error.message}</p>
                            <p>Please try again later or contact support if the problem persists.</p>
                        </div>`;
                });
        }

        window.onload = function() {
            fetchHistoryOrders();
        };
    </script>
</body>
</html>