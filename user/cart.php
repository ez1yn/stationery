<?php
require_once '../session_helper.php';
check_user_access();
?>

<?php
$page_title = "Cart";
include("../userHeader.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blue Cart Page</title>
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

        .search-container {
            flex-grow: 1;
            margin: 0 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .search-container input[type="text"] {
            padding: 8px 12px;
            width: 300px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .search-container button {
            padding: 8px 16px;
            background-color: #2c3e50;
            color: white;
            border: 1px solid white;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 10px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .search-container button:hover {
            background-color: #34495e;
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

        .cart-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .cart-items {
            flex-grow: 1;
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 10px;
            transition: all 0.2s ease;
        }

        .cart-item:hover {
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-color: #94a3b8;
        }

        .item-details {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }

        .item-info {
            margin-left: 20px;
        }

        .item-info h3 {
            margin: 0;
            color: #2c3e50;
            font-size: 16px;
        }

        .item-info p {
            color: #64748b;
            font-size: 14px;
            margin: 5px 0;
        }

        .quantity {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity button {
            padding: 6px 12px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quantity button:hover {
            background-color: #34495e;
        }

        .order-summary {
            width: 300px;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .order-summary h2 {
            color: #2c3e50;
            margin-top: 0;
            font-size: 18px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
            color: #64748b;
            font-size: 14px;
        }

        .checkout-button {
            width: 100%;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .checkout-button:hover {
            background-color: #34495e;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .container {
                margin: 120px 15px 40px;
                padding: 20px;
            }

            .cart-container {
                flex-direction: column;
            }

            .order-summary {
                width: auto;
            }

            .navigation ul {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        .quantity button {
        padding: 6px 12px;
        background-color: #2c3e50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
        margin: 0 5px;
        }

        .quantity button:hover {
            background-color: #34495e;
        }

        .quantity button.delete-btn {
            background-color: #dc3545;
        }

        .quantity button.delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-header">
            <h2>Your Cart Items</h2>
        </div>
        <div class="cart-container">
            <div class="cart-items" id="cartItems">
                <!-- Cart items will be dynamically added here -->
            </div>
            <div class="order-summary">
                <h2>Order Summary</h2>
                <div class="summary-item">
                    <span>Total Selected Items:</span>
                    <span id="totalItems">0</span>
                </div>
                <button class="checkout-button" onclick="placeOrder()">Place Order</button>
            </div>
        </div>
    </div>

   <script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeCart();
    });

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

    function goHistory() {
        window.location.href = "/stationery/user/history.php";
    }

    function goPending() {
        window.location.href = "/stationery/user/pending.php";
    }

    function initializeCart() {
        fetch('/stationery/fetchFunction/fetch_cart.php?action=getCart', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }
            displayCartItems(data);
        })
        .catch(error => console.error('Error fetching cart:', error));
    }

    function displayCartItems(cartItems) {
        const cartItemsContainer = document.getElementById('cartItems');
        const totalItemsElement = document.getElementById('totalItems');

        // Calculate total items
        const totalItems = cartItems.reduce((sum, item) => sum + parseInt(item.quantity), 0);
        totalItemsElement.textContent = totalItems;

        if (cartItems.length === 0) {
            cartItemsContainer.innerHTML = '<p>No items in cart.</p>';
            return;
        }

        // Generate HTML for cart items
        const cartHTML = cartItems.map(item => `
            <div class="cart-item">
                <div class="item-details">
                    <div class="item-info">
                        <input type="checkbox" class="select-item" onchange="updateSelection('${item.itemName}', this.checked)" />
                        <h3 style="display:inline;">${item.itemName}</h3>
                        <p><strong>Quantity:</strong> <span class="quantity-count">${item.quantity}</span></p>
                    </div>
                </div>
                <div class="quantity">
                    <button onclick="updateQuantity('${item.itemName}', -1)">-</button>
                    <span class="quantity-display">${item.quantity}</span>
                    <button onclick="updateQuantity('${item.itemName}', 1)">+</button>
                    <button class="delete-btn" onclick="deleteItem('${item.itemName}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `).join('');

        cartItemsContainer.innerHTML = cartHTML;
    }

    function updateQuantity(itemName, change) {
        fetch('/stationery/fetchFunction/fetch_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'updateItem',
                itemName: itemName,
                quantity: change
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                initializeCart(); // Refresh cart items
            } else {
                console.error(data.error);
            }
        })
        .catch(error => console.error('Error updating quantity:', error));
    }

    function deleteItem(itemName) {
        if (confirm('Are you sure you want to remove this item from your cart?')) {
            fetch('/stationery/fetchFunction/fetch_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'removeItem',
                    itemName: itemName
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    initializeCart(); // Refresh cart items
                } else {
                    console.error(data.error);
                }
            })
            .catch(error => console.error('Error deleting item:', error));
        }
    }

    let selectedItems = [];

    function updateSelection(itemName, isSelected) {
        if (isSelected) {
            selectedItems.push(itemName);
        } else {
            selectedItems = selectedItems.filter(name => name !== itemName);
        }
        updateTotals();
    }

    function updateTotals() {
        const totalItems = selectedItems.length;
        document.getElementById('totalItems').textContent = totalItems;
    }

    function placeOrder() {
    if (selectedItems.length === 0) {
        alert('Please select at least one item to place an order.');
        return;
    }

    // Get all cart items and their quantities
    const cartItems = Array.from(document.querySelectorAll('.cart-item')).map(item => {
        const itemName = item.querySelector('.item-info h3').textContent;
        const quantity = parseInt(item.querySelector('.quantity-display').textContent);
        const isSelected = item.querySelector('.select-item').checked;
        
        return isSelected ? {
            itemName: itemName,
            quantity: quantity
        } : null;
    }).filter(item => item !== null);

    // Store the complete item details
    localStorage.setItem('selectedItems', JSON.stringify(cartItems));
    window.location.href = '/stationery/user/order_confirmation.php';
}
</script>
</body>
</html>