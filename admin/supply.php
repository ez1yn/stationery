<?php
session_start();  

if (!isset($_SESSION['loggedin']) || $_SESSION['userlevel'] !== 'Admin') {
    header("Location: ../index.php?error=" . urlencode("Unauthorized access. Please log in first."));
    exit;
}
?>

<?php
// Define the page title for this page
$page_title = "List of Supplied";

// Include the header file
include('../header.php');  // or the full path to your header file

// Page content starts here
?>

<!DOCTYPE html>
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
                width: 300px;
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
                margin: 100px auto 40px;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .table-container {
                position: relative;
                overflow: visible;
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
                background-color: white;
                margin-bottom: 20px;
            }
            
            th, td {
                border: 1px solid #ddd;
                padding: 16px;
                text-align: left;
                white-space: normal;
                word-wrap: break-word;
            }
            
            /* Pagination styles */
            .pagination {
                display: flex;
                justify-content: center;
                gap: 10px;
                margin: 20px 0;
            }
            
            .pagination button {
                padding: 8px 16px;
                background-color: #2c3e50;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            
            .pagination button:hover {
                background-color: #1a252f;
            }
            
            .pagination button:disabled {
                background-color: #cccccc;
                cursor: not-allowed;
            }
            
            .pagination-info {
                text-align: center;
                margin-bottom: 10px;
                color: #666;
            }
            th {
                background-color: #2c3e50;
                color: white;
                position: sticky;
                top: 0;
                z-index: 10;
            }
            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            tr:hover {
                background-color: #f1f1f1;
                transition: background-color 0.3s;
            }
            .status {
                padding: 5px 10px;
                border-radius: 20px;
                font-size: 0.9em;
                font-weight: bold;
            }
            .status-completed {
                background-color: #4CAF50;
                color: white;
            }
            .loading-spinner {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(255, 255, 255, 0.9);
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                z-index: 1000;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .spinner {
                width: 40px;
                height: 40px;
                border: 4px solid #f3f3f3;
                border-top: 4px solid #3498db;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
        </style>
    </head>
    <body>
    </header> -->
        <div class="container">
            <div class="search-container">
                <input type="number" id="year-search" min="2000" max="2100" placeholder="Year" value="2024">
                <button onclick="searchByYear()">Search</button>
            </div>

            <div id="error-message" style="display: none; color: red; text-align: center; margin: 10px 0;"></div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID ORDER</th>
                            <th>NAME</th>
                            <th>SERVICES NAME</th>
                            <th>ITEM</th>
                            <th>QUANTITY REQUEST</th>
                            <th>QUANTITY SUPPLY</th>
                            <th>REMARKS</th>
                            <th>DATE REQUESTED</th>
                            <th>DATE SUPPLY</th>
                            <th>STATUS SUPPLY</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTableBody">
                        <!-- Data will be populated here -->
                    </tbody>
                </table>
            
            </div>
            
            <div class="pagination" id="pagination-controls">
                <button onclick="changePage('prev')" id="prev-button">← Previous</button>
                <div class="pagination-info" id="pagination-info"></div>
                <button onclick="changePage('next')" id="next-button">Next →</button>
            </div>
        </div>

        <div class="loading-spinner" id="loading-spinner">
            <div class="spinner"></div>
        </div>

        <script>
            let currentData = [];
            let isLoading = false;
            let currentPage = 1;
            const itemsPerPage = 100;

            // Cache DOM elements
            const yearSearch = document.getElementById('year-search');
            const errorMessage = document.getElementById('error-message');
            const ordersTableBody = document.getElementById('ordersTableBody');
            const loadingSpinner = document.getElementById('loading-spinner');
            const paginationInfo = document.getElementById('pagination-info');
            const prevButton = document.getElementById('prev-button');
            const nextButton = document.getElementById('next-button');

            // Load orders when page loads
            document.addEventListener('DOMContentLoaded', function() {
                loadOrders(new Date().getFullYear());
            });

            // Pagination handler
            function changePage(direction) {
                if (direction === 'prev' && currentPage > 1) {
                    currentPage--;
                } else if (direction === 'next' && currentPage < Math.ceil(currentData.length / itemsPerPage)) {
                    currentPage++;
                }
                renderOrders();
            }

            // Search function with validation
            function searchByYear() {
                const year = parseInt(yearSearch.value);
                if (year < 2000 || year > 2100) {
                    errorMessage.textContent = 'Please enter a valid year between 2000 and 2100';
                    errorMessage.style.display = 'block';
                    return;
                }
                currentPage = 1; // Reset to first page on new search
                loadOrders(year);
            }

            // Optimized load orders function
            async function loadOrders(year) {
                if (isLoading) return;
                
                try {
                    isLoading = true;
                    errorMessage.style.display = 'none';
                    loadingSpinner.style.display = 'flex';

                    const response = await fetch(`/stationery/fetchFunction/fetch_completed_orders.php?year=${year}`, {
                        method: 'GET',
                        headers: {
                            'Cache-Control': 'no-cache',
                            'Pragma': 'no-cache'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    currentData = data;
                    renderOrders();

                } catch (error) {
                    console.error('Error:', error);
                    errorMessage.textContent = 'Error loading data. Please try again.';
                    errorMessage.style.display = 'block';
                    ordersTableBody.innerHTML = '<tr><td colspan="10" style="text-align: center;">Error loading data</td></tr>';
                } finally {
                    isLoading = false;
                    loadingSpinner.style.display = 'none';
                }
            }

            // Optimized render function with pagination
            function renderOrders() {
                if (currentData.length === 0) {
                    ordersTableBody.innerHTML = `<tr><td colspan="10" style="text-align: center;">No completed orders found for ${yearSearch.value}</td></tr>`;
                    paginationInfo.textContent = 'No results found';
                    prevButton.disabled = true;
                    nextButton.disabled = true;
                    return;
                }

                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = Math.min(startIndex + itemsPerPage, currentData.length);
                const fragment = document.createDocumentFragment();
                
                for (let i = startIndex; i < endIndex; i++) {
                    const order = currentData[i];
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${escapeHtml(order.idOrder)}</td>
                        <td>${escapeHtml(order.staffName)}</td>
                        <td>${escapeHtml(order.serviceName)}</td>
                        <td>${escapeHtml(order.itemName)}</td>
                        <td>${escapeHtml(order.quantity)}</td>
                        <td>${escapeHtml(order.quantitySupply)}</td>
                        <td>${escapeHtml(order.remarks)}</td>
                        <td>${escapeHtml(order.dateRequested)}</td>
                        <td>${escapeHtml(order.dateDelivered)}</td>
                        <td><span class="status status-completed">${escapeHtml(order.deliveredStatus)}</span></td>
                    `;
                    fragment.appendChild(row);
                }

                ordersTableBody.innerHTML = '';
                ordersTableBody.appendChild(fragment);

                // Update pagination controls
                const totalPages = Math.ceil(currentData.length / itemsPerPage);
                paginationInfo.textContent = `Page ${currentPage} of ${totalPages} (${currentData.length} total records)`;
                prevButton.disabled = currentPage === 1;
                nextButton.disabled = currentPage === totalPages;
            }

            function escapeHtml(unsafe) {
                if (unsafe === null || unsafe === undefined) return '';
                return unsafe.toString()
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            // Add event listener for year input
            yearSearch.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchByYear();
                }
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

        function goHome() {
            window.location.href = "/stationery/admin/home.php";
        }
        </script>
    </body>
</html>