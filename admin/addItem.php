<?php
// Define the page title for this page
$page_title = "Add Item";

// Include the header file
include('../header.php');  // or the full path to your header file

// Page content starts here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Register Item</title>
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

        /* Added subtle hover effect for form fields */
        .form-group input:hover,
        .form-group select:hover {
            border-color: #94a3b8;
        }

        /* Required field indicator */
        .form-group label::after {
            content: "*";
            color: #dc2626;
            margin-left: 4px;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-header">
            <h2>Register New Item</h2>
            <p>Enter item details below</p>
        </div>

        <form id="registerItemForm" action="/stationery/crudFunction/addItem.php" method="post">
            <div class="form-group">
                <label for="itemCode">Item Code</label>
                <input type="text" id="itemCode" name="itemCode" required>
                <i class="fas fa-barcode icon"></i>
            </div>

            <div class="form-group">
                <label for="itemName">Item Name</label>
                <input type="text" id="itemName" name="itemName" required>
                <i class="fas fa-box icon"></i>
            </div>

            <div class="form-group">
    <label for="category_id">Category</label>
    <select id="category_id" name="category_id" required>
        <option value="">Select category</option>
    </select>
    <i class="fas fa-tags icon"></i>
</div>

            <!-- <div class="form-group">
                <label for="title">Category</label>
                <select id="title" name="title" required>
                    <option value="">Select category</option>
                </select>
                <i class="fas fa-tags icon"></i>
            </div> -->

            <div class="form-group">
                <label for="oumName">Order Unit of Measure</label>
                <select id="oumName" name="oumName" required>
                    <option value="">Select OUM</option>
                </select>
                <i class="fas fa-ruler icon"></i>
            </div>

            <div class="btn-container">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='/stationery/admin/addItem.php'">Cancel</button>
                <button type="submit" class="btn btn-primary">Register Item</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchCategories();
            fetchOUMs();
        });

        function fetchCategories() {
    fetch('/stationery/fetchFunction/fetchCategories.php')
        .then(response => response.json())
        .then(categories => {
            const categorySelect = document.getElementById('category_id');
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.category_id;  // Use category_id as the value
                option.textContent = category.title;
                categorySelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching categories:', error));
}


        function fetchOUMs() {
            fetch('/stationery/fetchFunction/fetch_oum.php')
                .then(response => response.json())
                .then(oums => {
                    const oumSelect = document.getElementById('oumName');
                    oums.forEach(oum => {
                        const option = document.createElement('option');
                        option.value = oum.oumName;
                        option.textContent = oum.oumName;
                        oumSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching OUMs:', error));
        }

        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                // Send request to logout.php
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
            window.location.href = "aHome2.html";
        }
    </script>
</body>
</html>