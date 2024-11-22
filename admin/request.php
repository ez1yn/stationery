<?php
session_start();  

if (!isset($_SESSION['loggedin']) || $_SESSION['userlevel'] !== 'Admin') {
    header("Location: ../index.php?error=" . urlencode("Unauthorized access. Please log in first."));
    exit;
}
?>

<?php
// Define the page title for this page
$page_title = "List of Requests Items";

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
            overflow-x: hidden; 
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
            width: 100%;
            box-sizing: border-box;
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
            width: 95%;
            max-width: 1800px; /* Added max-width */
            margin: 100px auto 40px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        /* Enhanced search container */
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }

        .search-container input[type="text"] {
            padding: 10px 15px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 14px;
        }

        .search-container button {
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-container button:hover {
            background-color: #004a99;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto; /* Allow table to scroll horizontally if needed */
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Fixed table layout */
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            vertical-align: top;
            overflow-wrap: break-word;
            word-wrap: break-word;
            hyphens: auto;
        }
        /* Column widths */
        th:nth-child(1), td:nth-child(1) { width: 50px; }      /* Order ID */
        th:nth-child(2), td:nth-child(2) { width: 120px; }     /* Staff Name */
        th:nth-child(3), td:nth-child(3) { width: 100px; }     /* Item Name */
        th:nth-child(4), td:nth-child(4) { width: 70px; }     /* Quantity Request */
        th:nth-child(5), td:nth-child(5) { width: 70px; }     /* Quantity Supply */
        th:nth-child(6), td:nth-child(6) { width: 70px; }     /* Remarks */
        th:nth-child(7), td:nth-child(7) { width: 120px; }     /* Services Name */
        th:nth-child(8), td:nth-child(8) { width: 80px; }     /* Date Requested */
        th:nth-child(9), td:nth-child(9) { width: 70px; }     /* Date Supply */
        th:nth-child(10), td:nth-child(10) { width: 70px; }   /* Status */
        th:nth-child(11), td:nth-child(11) { width: 100px; }   /* Action */


        th {
            background-color: #2c3e50;
            color: white;
            position: sticky;
            top: 120px; /* Adjust based on header height */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: bold;
            width: auto;
            text-align: center;
        }

        .status-pending {
            background-color: #ffd700;
            color: #000;
        }

        .status-done {
            background-color: #4CAF50;
            color: white;
        }
        .update-btn {
            width: 100%;
            background-color: #f3b421;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .update-btn:hover {
            background-color: #1976D2;
            transform: scale(1.05);
        }

        .error-message, .no-data-message {
            padding: 20px;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }

        .error-message {
            color: #d32f2f;
            background-color: #ffebee;
            border: 1px solid #ffcdd2;
        }

        .no-data-message {
            color: #666;
            background-color: #f5f5f5;
            border: 1px solid #e0e0e0;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search by staff name, item, date, or status">
            <button onclick="searchTable()">Search</button>
        </div>
        
        <table id="requestsTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Staff Name</th>
                    <th>Item Name</th>
                    <th>Quantity Request</th>
                    <th>Quantity Supply</th>
                    <th>Remarks</th>
                    <th>Services Name</th>
                    <th>Date Requested</th>
                    <th>Date Supply</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>

    <script>
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const tbody = document.getElementById('tableBody');
            const rows = tbody.getElementsByTagName('tr');
            let visibleRows = 0;

            // Remove existing no results message if it exists
            const existingMessage = document.querySelector('.no-results-message');
            if (existingMessage) {
                existingMessage.remove();
            }

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let showRow = false;
                
                // Skip the row if it's already a no-results-message
                if (rows[i].classList.contains('no-results-row')) {
                    continue;
                }
                
                // Search in staff name, item name, and status (columns 1, 2, and 9)
                for (let j = 1; j < 3; j++) {
                    if (cells[j]) {
                        const cellText = cells[j].textContent || cells[j].innerText;
                        if (cellText.toUpperCase().indexOf(filter) > -1) {
                            showRow = true;
                            break;
                        }
                    }
                }
                
                // Search in status (column 9)
                if (cells[9] && cells[9].textContent.toUpperCase().indexOf(filter) > -1) {
                    showRow = true;
                }
                
                // Search in dates (Date Requested and Date Supply - columns 7 and 8)
                const dateRequestedCell = cells[7];
                const dateSupplyCell = cells[8];
                
                if (dateRequestedCell) {
                    const dateRequested = dateRequestedCell.textContent || dateRequestedCell.innerText;
                    if (formatDateForComparison(dateRequested).indexOf(formatDateForComparison(filter)) > -1) {
                        showRow = true;
                    }
                }
                
                if (dateSupplyCell) {
                    const dateSupply = dateSupplyCell.textContent || dateSupplyCell.innerText;
                    if (dateSupply !== '-' && formatDateForComparison(dateSupply).indexOf(formatDateForComparison(filter)) > -1) {
                        showRow = true;
                    }
                }
                
                rows[i].style.display = showRow ? '' : 'none';
                if (showRow) visibleRows++;
            }

            // If no rows are visible, display the no results message
            if (visibleRows === 0) {
                const messageRow = document.createElement('tr');
                messageRow.className = 'no-results-row';
                messageRow.innerHTML = `
                    <td colspan="11" class="no-results-message">
                        <div style="
                            padding: 20px;
                            text-align: center;
                            color: #666;
                            background-color: #f5f5f5;
                            border-radius: 5px;
                            margin: 10px 0;
                            font-size: 1.1em;
                        ">
                            <i>No requests found for "${input.value}"</i>
                        </div>
                    </td>
                `;
                tbody.appendChild(messageRow);
            }
        }

        // format dates for comparison
        function formatDateForComparison(dateStr) {
            if (dateStr.length < 10) return dateStr.toUpperCase();
            
            try {
                const date = new Date(dateStr);
                if (isNaN(date.getTime())) return dateStr.toUpperCase();
                
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                
                return `${year}-${month}-${day} ${month}/${day}/${year} ${day}/${month}/${year}`.toUpperCase();
            } catch (e) {
                return dateStr.toUpperCase();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadOrders();
        });

        function loadOrders() {
            const tbody = document.getElementById('tableBody');
            
            fetch('/stationery/fetchFunction/fetch_pending_orders.php')
                .then(response => response.json())
                .then(result => {
                    if (!result.success) {
                        throw new Error(result.error || 'Failed to load data');
                    }

                    if (result.data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="11" class="no-data-message">No orders found</td></tr>';
                        return;
                    }

                    // Create document fragment for better performance
                    const fragment = document.createDocumentFragment();
                    
                    result.data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.dataset.id = row.orderId;
                        
                        // Build HTML string once
                        const html = `
                            <td>${row.orderId}</td>
                            <td>${row.staffName}</td>
                            <td>${row.itemName}</td>
                            <td>${row.quantity}</td>
                            <td>${row.quantityS || '-'}</td>
                            <td>${row.remarks || '-'}</td>
                            <td>${row.servicesName}</td>
                            <td>${row.dateR}</td>
                            <td>${row.dateS || '-'}</td>
                            <td><span class="status status-${row.status.toLowerCase()}">${row.status}</span></td>
                            <td><button class="update-btn" onclick="goToUpdate(${row.orderId})">Update</button></td>
                        `;
                        
                        tr.innerHTML = html;
                        fragment.appendChild(tr);
                    });

                    // Clear and update tbody in one operation
                    tbody.innerHTML = '';
                    tbody.appendChild(fragment);
                })
                .catch(error => {
                    console.error('Error:', error);
                    tbody.innerHTML = `<tr><td colspan="11" class="error-message">Error: ${error.message}. Please refresh the page or try again later.</td></tr>`;
                });
        }

        function goToUpdate(orderId) {
            // Find the order data from the table row
            const row = document.querySelector(`tr[data-id="${orderId}"]`);
            if (row) {
                const orderData = {
                    orderId: row.children[0].textContent,
                    staffName: row.children[1].textContent,
                    itemName: row.children[2].textContent,
                    quantity: row.children[3].textContent,
                    quantityS: row.children[4].textContent !== '-' ? row.children[4].textContent : '',
                    remarks: row.children[5].textContent !== '-' ? row.children[5].textContent : '',
                    servicesName: row.children[6].textContent,
                    dateR: row.children[7].textContent,
                    dateS: row.children[8].textContent !== '-' ? row.children[8].textContent : '',
                    status: row.children[9].querySelector('.status').textContent
                };
                
                // Store the data in localStorage
                localStorage.setItem('orderData', JSON.stringify(orderData));
                window.location.href = `updateRequest.php?id=${orderId}`;
            }
        }

        // Replace your existing confirmLogout() function with this:
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