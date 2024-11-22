<?php
require_once '../session_helper.php';
check_user_access();
?>

<?php
$page_title = "List Orders";
include("../userHeader.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
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
            max-width: 900px;
            margin: 140px auto 40px;
            padding: 25px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
        }

        .tab {
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .tab.active {
            background-color: #2c3e50;
            color: white;
            border-color: #2c3e50;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .order-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
            transition: all 0.2s ease;
        }

        .order-card:hover {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .order-details {
            margin-top: 15px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background-color: #e0e7ff;
            color: #166534;
        }

        .status-completed {
            background-color: #dcfce7;
            color: #3730a3;
        }

        .item-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(800px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .item-card {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .error-message {
            text-align: center;
            color: #dc2626;
            padding: 20px;
            background-color: #fef2f2;
            border-radius: 6px;
            margin: 20px 0;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #6b7280;
        }

        @media (max-width: 768px) {
            .container {
                margin: 120px 15px 40px;
                padding: 15px;
            }

            .tabs {
                flex-wrap: wrap;
            }

            .tab {
                flex: 1 1 auto;
                text-align: center;
            }

            .item-grid {
                grid-template-columns: 1fr;
            }
        }

        
    </style>
</head>
<body>

    <div class="container">
        <div id="ordersList"></div>
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

        // Tab switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Update active tab
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // Update active content
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                document.getElementById(`${tab.dataset.tab}Orders`).classList.add('active');
            });
        });

        // Format date
        function formatDate(dateString) {
            const options = { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            return new Date(dateString).toLocaleDateString('en-US', options);
        }

        // Get status badge class
        function getStatusBadgeClass(status) {
            switch(status.toLowerCase()) {
                case 'pending':
                    return 'status-pending';
                case 'approved':
                    return 'status-approved';
                case 'done':
                    return 'status-completed';
                default:
                    return 'status-pending';
            }
        }

       // Create order card HTML with click handler
       function createOrderCard(order) {
            const status = order.deliveredStatus.toLowerCase();
            let clickHandler = '';
            
            if (status === 'pending') {
                clickHandler = 'onclick="window.location.href=\'uPending.html\'"';
            } else if (status === 'done') {
                clickHandler = 'onclick="window.location.href=\'uHistory.html\'"';
            }

            return `
                <div class="order-card" ${clickHandler} style="cursor: pointer;">
                    <div class="order-header">
                        <div>
                            <h3>Order #${order.idOrder}</h3>
                            <p>Requested: ${formatDate(order.dateRequested)}</p>
                        </div>
                        <span class="status-badge ${getStatusBadgeClass(order.deliveredStatus)}">
                            ${order.deliveredStatus}
                        </span>
                    </div>
                    <div class="order-details">
                        <div class="item-grid">
                            <div class="item-card">
                                <h4>${order.itemName}</h4>
                                <p><strong>Quantity:</strong> ${order.quantity}</p>
                                <p><strong>Supply:</strong> ${order.quantitySupply}</p>
                                <p><strong>Service:</strong> ${order.serviceName}</p>
                                <p><strong>Staff:</strong> ${order.staffName}</p>
                                <p><strong>Remarks:</strong> ${order.remarks || 'None'}</p>
                            </div>
                        </div>
                    </div>
                    ${order.dateDelivered ? `
                        <div class="delivery-info">
                            <p><strong>Delivered:</strong> ${formatDate(order.dateDelivered)}</p>
                        </div>
                    ` : ''}
                </div>
            `;
        }

        // Replace the fetchOrders function in your order.html with this updated version
        async function fetchOrders() {
            const container = document.getElementById('ordersList');
            container.innerHTML = '<div class="loading">Loading orders...</div>';

            try {
                const response = await fetch('/stationery/fetchFunction/fetch_order.php'); // Change this line
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                
                if (!result.success) {
                    throw new Error(result.error || 'Failed to fetch orders');
                }

                const orders = result.data;

                if (!Array.isArray(orders) || orders.length === 0) {
                    container.innerHTML = '<p style="text-align: center;">No orders found.</p>';
                    return;
                }

                container.innerHTML = orders.map(order => {
                    const safeOrder = {
                        idOrder: order.idOrder || 'N/A',
                        dateRequested: order.dateRequested || new Date().toISOString(),
                        deliveredStatus: order.deliveredStatus || 'Pending',
                        itemName: order.itemName || 'N/A',
                        quantity: order.quantity || 0,
                        quantitySupply: order.quantitySupply || 0,
                        serviceName: order.serviceName || 'N/A',
                        staffName: order.staffName || 'N/A',
                        remarks: order.remarks || 'None',
                        dateDelivered: order.dateDelivered || null
                    };
                    return createOrderCard(safeOrder);
                }).join('');
            } catch (error) {
                console.error('Error:', error);
                container.innerHTML = `
                    <div class="error-message">
                        <p>Error loading orders: ${error.message}</p>
                        <p>Please try again later or contact support if the problem persists.</p>
                    </div>
                `;
            }
        }

          // Initialize page
        window.onload = function() {
            fetchOrders();
        };
    </script>
</body>
</html> 