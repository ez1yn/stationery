<?php
require_once '../session_helper.php';
check_user_access();
?>

<?php
$page_title = "List of Item";
include("../userHeader.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Items</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #1a5f7a;
            margin: 30px 0;
            font-weight: 600;
            font-size: 2.5em;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        #search-input {
            width: 50%;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #1a5f7a;
            border-radius: 6px 0 0 6px;
            outline: none;
        }

        #search-button {
            padding: 12px 20px;
            background-color: #1a5f7a;
            color: white;
            border: none;
            border-radius: 0 6px 6px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #search-button:hover {
            background-color: #2c3e50;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .product-card {
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .product-info {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-card h3 {
            font-size: 18px;
            color: #ffffff;
            margin: 0;
            padding: 15px;
            background-color: #1a5f7a;
            text-align: center;
        }

        .product-card ul {
            list-style-type: none;
            padding: 0;
            margin: 15px 0;
        }

        .product-card ul li {
            margin: 10px 0;
            color: #555;
            display: flex;
            justify-content: space-between;
        }

        .product-card .btn {
            display: block;
            width: 80%;
            padding: 12px;
            background-color: #1a5f7a;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            text-align: center;
            transition: background-color 0.3s ease;
            font-weight: 600;
            margin: 0 auto 20px;
            text-transform: uppercase;
        }

        .product-card .btn:hover {
            background-color: #2c3e50;
        }

        .product-card a {
            text-decoration: none;
            color: inherit;
        }

        @media (max-width: 900px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            #search-input {
                width: 70%;
            }
        }

        @media (max-width: 600px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
            #search-input {
                width: 100%;
            }
            #search-button {
                width: 100%;
                border-radius: 0 0 6px 6px;
            }
            .search-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <div class="container" style="margin-top: 9%;">
        <h1 id="category-title">Items</h1>
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Search by item name...">
            <button id="search-button"><i class="fas fa-search"></i></button>
        </div>
        <div class="product-grid" id="product-grid">
            <!-- Product cards will be displayed here -->
        </div>
    </div>

    <script>

        function goCart() {
            window.location.href = "/stationery/user/cart.php";
        }

        let items = [];
        // Get the category from URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const category = urlParams.get('category') || '';

        // Updated categories array with correct case
        const categories = [
            'Battery',
            'Book',
            'Marker Pen',
            'Drawer',
            'Envelope',
            'File',
            'Dis',
            'Form',
            'Form BO',
            'Form Medical Record',
            'Form Nursing',
            'Form Other',
            'Form Pharmacy',
            'Glue',
            'Other',
            'Paper',
            'Sticker',
            'Tag',
            'Tapes',
            'Toner'
        ];

        // Format category name for display
        function formatCategoryName(category) {
            if (!category) return 'All Items';
            
            // Handle special cases
            if (category.toLowerCase().startsWith('form_')) {
                const formType = category.replace(/^form_/i, '');
                return `Form - ${formType.split('_')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                    .join(' ')}`;
            }
            
            // Capitalize first letter for display
            return category.charAt(0).toUpperCase() + category.slice(1).toLowerCase();
        }

        // Update page title based on category
        document.getElementById('category-title').textContent = formatCategoryName(category);

        // Fetch items with error handling and debugging
        async function fetchItems() {
            try {
                const urlParams = new URLSearchParams(window.location.search);
                const category = urlParams.get('category');
                console.log('Fetching items for category:', category);

                const url = `/stationery/fetchFunction/fetch_item.php${category ? `?category=${encodeURIComponent(category)}` : ''}`;
                console.log('Fetch URL:', url);

                const response = await fetch(url);
                console.log('Response status:', response.status);

                // Check if response is ok and contains valid JSON
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Server did not return JSON response');
                }

                const data = await response.json();
                console.log('Received data:', data);

                if (data.status === 'error') {
                    throw new Error(data.message || 'Unknown error occurred');
                }

                items = data.items || [];
                
                // Update page title with category
                const categoryTitle = category ? formatCategoryName(category) : 'All Items';
                document.getElementById('category-title').textContent = categoryTitle;
                
                displayItems(items);
            } catch (error) {
                console.error('Error fetching items:', error);
                document.getElementById('product-grid').innerHTML = 
                    `<p style="text-align: center; color: #666;">Error loading items: ${error.message}</p>`;
            }
        }

        // Display items
        function displayItems(itemsToDisplay) {
            console.log('Displaying items:', itemsToDisplay);
            const productGrid = document.getElementById('product-grid');
            productGrid.innerHTML = '';
            
            if (!itemsToDisplay || itemsToDisplay.length === 0) {
                productGrid.innerHTML = '<p style="text-align: center; color: #666;">No items found in this category.</p>';
                return;
            }
            
            itemsToDisplay.forEach(item => {
                const productCard = document.createElement('div');
                productCard.classList.add('product-card');
                
                // Escape any potential HTML in the item data
                const escapedItemName = escapeHtml(item.itemName);
                const escapedItemCode = escapeHtml(item.itemCode);
                const escapedCategory = escapeHtml(item.title || 'Uncategorized'); // Use title from the database
                const escapedOumName = escapeHtml(item.oumName);
                
                productCard.innerHTML = `
                    <h3>${escapedItemName}</h3>
                    <div class="product-info">
                        <ul>
                            <li><span>Item Code:</span> <span>${escapedItemCode}</span></li>
                            <li><span>Category:</span> <span>${escapedCategory}</span></li>
                            <li><span>OUM:</span> <span>${escapedOumName}</span></li>
                        </ul>
                    </div>
                    <button class="btn" onclick="addToCart('${escapedItemCode}', '${escapedItemName}', '${escapedCategory}', '${escapedOumName}')">
                        Add to cart
                    </button>
                `;
                productGrid.appendChild(productCard);
            });
        }
        

        //cart
        async function addToCart(itemCode, itemName, title, oumName) {
            // Create the cart item object matching database structure
            const cartItem = {
                itemName: itemName,
                quantity: 1  // Default quantity when adding to cart
            };

            try {
                const response = await fetch('/stationery/crudFuncUser/add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(cartItem)
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                
                if (result.success) {
                    alert(`${itemName} added to cart!`);
                } else {
                    alert(`Failed to add item to cart: ${result.message}`);
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                alert('An error occurred while adding to cart. Please try again later.');
            }
        }

        // Helper function to escape HTML and prevent XSS
        function escapeHtml(unsafe) {
            if (typeof unsafe !== 'string') return '';
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Format category name for display
        function formatCategoryName(category) {
            if (!category) return 'All Items';
            return category.split('_')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                .join(' ');
        }

        // Initialize when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            console.log('Page loaded, initializing...');
            fetchItems();
        });
        
        // Search functionality
        function searchItems() {
            const input = document.getElementById('search-input');
            const filter = input.value.toUpperCase();
            const filteredItems = items.filter(item => 
                item.itemName.toUpperCase().includes(filter)
            );
            displayItems(filteredItems);
        }
        
        // Event listeners
        document.getElementById('search-button').addEventListener('click', searchItems);
        document.getElementById('search-input').addEventListener('keyup', searchItems);
        
        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            console.log('Page loaded, initializing...'); // Debug log
            fetchItems();
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
    </script>
</body>
</html>