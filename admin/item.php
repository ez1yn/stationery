<?php
session_start();  

if (!isset($_SESSION['loggedin']) || $_SESSION['userlevel'] !== 'Admin') {
    header("Location: ../index.php?error=" . urlencode("Unauthorized access. Please log in first."));
    exit;
}
?>

<?php
// Define the page title for this page
$page_title = "List of Stationery Items";

// Include the header file
include('../header.php');  // or the full path to your header file

// Page content starts here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - List Item</title>
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
                margin: 100px auto 40px;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                display: flex;
            }
            .sidebar {
                width: 200px;
                padding-right: 20px;
            }
            .main-content {
                flex-grow: 1;
            }
            .top-controls {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }
            .search-container {
                display: flex;
                align-items: center;
                flex-grow: 1;
                margin-right: 20px;
            }
            .search-container input[type="text"] {
                padding: 10px;
                width: 100%;
                border-radius: 20px;
                border: 1px solid #ccc;
                transition: box-shadow 0.3s;
            }
            .search-container input[type="text"]:focus {
                box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            }
            .btn {
                padding: 10px 20px;
                border: none;
                border-radius: 20px;
                cursor: pointer;
                transition: background-color 0.3s, box-shadow 0.3s;
                color: white;
                font-weight: bold;
            }
            .search-btn {
                background-color: #0056b3;
                margin-left: 10px;
            }
            .add-btn {
                background-color: #4CAF50;
            }
            .print-btn {
                background-color: #004a99;
                margin-left: 10px;
            }
            .btn:hover {
                opacity: 0.9;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
                margin: 4%;
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
            .category-list {
                list-style-type: none;
                padding: 0;
            }
            .category-list li {
                cursor: pointer;
                padding: 10px;
                border-radius: 5px;
                transition: background-color 0.3s;
            }
            .category-list li:hover {
                background-color: #e6f2ff;
            }
            .category-list li.active {
                background-color: #2c3e50;
                color: white;
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

            .no-results {
                display: none;
                text-align: center;
                padding: 20px;
                background-color: #f8f9fa;
                border: 1px solid #dee2e6;
                border-radius: 5px;
                margin: 20px 0;
                color: #6c757d;
                font-size: 16px;
            }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h3>Categories</h3>
            <ul class="category-list">
                <li onclick="filterByCategory('all')" class="active">All Categories</li>
            </ul>
        </div>

        <div class="main-content">
            <div class="top-controls">
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search by Item Name...">
                    <button class="btn search-btn" onclick="searchItems()">Search</button>
                </div>
                <div>
                    <button class="btn add-btn" onclick="addItem()">Add Item</button>
                    <button class="btn print-btn" onclick="printTable()">Print</button>
                </div>
            </div>

            <table id="itemTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>OUM</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="itemTableBody">
                    <!-- Dynamic content will be populated here -->
                </tbody>
            </table>

            <div id="noResults" class="no-results">
                No items found.
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {  
            loadItems();
            loadCategories(); // Fetch categories when the page loads
            showMessage();
        };

        function loadCategories() {
            fetch('/stationery/getFunction/getCategories.php')
                .then(response => response.json())
                .then(categories => {
                    const categoryList = document.querySelector('.category-list');
                    categoryList.innerHTML = ''; // Clear existing categories
                    categoryList.innerHTML += '<li onclick="filterByCategory(\'all\')" class="active">All Categories</li>'; // Default item

                    categories.forEach(category => {
                        const li = document.createElement('li');
                        li.textContent = category;
                        li.onclick = () => filterByCategory(category);
                        categoryList.appendChild(li);
                    });
                })
                .catch(error => console.error('Error fetching categories:', error));
        }

        function loadItems(forceRefresh = false) {
            const timestamp = forceRefresh ? `?t=${new Date().getTime()}` : '';
            fetch('/stationery/getFunction/getItemList.php' + timestamp)
                .then(response => response.json())
                .then(items => {
                    const tableBody = document.getElementById('itemTableBody');
                    tableBody.innerHTML = '';
                    items.forEach((item) => {
                        const row = `
                            <tr>
                                <td>${item.id}</td>
                                <td>${item.itemCode}</td>
                                <td>${item.itemName}</td>
                                <td>${item.title}</td>
                                <td>${item.oumName}</td>
                                <td>
                                    <button class="action-btn edit-btn" onclick="editItem(${item.id})">Edit</button>
                                    <button class="action-btn delete-btn" onclick="confirmDelete(${item.id}, '${item.itemName}')">Delete</button>
                                </td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        function addItem() {
            window.location.href = '/stationery/admin/addItem.php';
        }

        function confirmDelete(id, itemName) {
            if (confirm(`Are you sure you want to delete ${itemName}?`)) {
                fetch('/stationery/crudFunction/deleteItem.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        loadItems(); // Reload the item list
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }



        function editItem(id) {
            window.location.href = `/stationery/admin/itemEdit.php?id=${id}`;
        }

        function searchItems() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('itemTable');
            const tr = table.getElementsByTagName('tr');
            const noResults = document.getElementById('noResults');
            let found = false;

            // Start from 1 to skip the header row
            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[2]; // Item Name column
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                        found = true;
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }

            // Show/hide the "No results" message
            noResults.style.display = found ? 'none' : 'block';
            
            // Show/hide the table based on results
            table.style.display = found ? 'table' : 'none';
        }

        function filterByCategory(category) {
            const table = document.getElementById('itemTable');
            const tr = table.getElementsByTagName('tr');
            const noResults = document.getElementById('noResults');
            let found = false;

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[3];
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (category === 'all' || txtValue === category) {
                        tr[i].style.display = '';
                        found = true;
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }

            // Show/hide the "No results" message
            noResults.style.display = found ? 'none' : 'block';
            
            // Show/hide the table based on results
            table.style.display = found ? 'table' : 'none';

            const categoryItems = document.querySelectorAll('.category-list li');
            categoryItems.forEach(item => {
                item.classList.remove('active');
                if (item.textContent.includes(category) || (category === 'all' && item.textContent === 'All Categories')) {
                    item.classList.add('active');
                }
            });
        }

        function printTable() {
            window.print();
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

        function showMessage() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');
            if (message) {
                const messageElement = document.getElementById('message');
                messageElement.textContent = message;
                messageElement.style.display = 'block';
                setTimeout(() => {
                    messageElement.style.display = 'none';
                }, 5000); // Hide the message after 5 seconds
            }
        }
    </script>
</body>
</html>