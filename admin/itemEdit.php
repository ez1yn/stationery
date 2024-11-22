<?php
// Define the page title for this page
$page_title = "Edit Item";

// Include the header file
include('../header.php');  // or the full path to your header file

// Page content starts here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Item</title>
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

        .form-group input:hover,
        .form-group select:hover {
            border-color: #94a3b8;
        }

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
            <h2>Edit Item Details</h2>
            <p>Update item information below</p>
        </div>

        <form id="editItemForm">
            <input type="hidden" id="itemId" name="id">
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
                <label for="title">Category</label>
                <select id="title" name="title" required>
                    <option value="">Select category</option>
                </select>
                <i class="fas fa-tags icon"></i>
            </div>

            <div class="form-group">
                <label for="oumName">Order Unit of Measure</label>
                <select id="oumName" name="oumName" required>
                    <option value="">Select OUM</option>
                </select>
                <i class="fas fa-ruler icon"></i>
            </div>

            <div class="btn-container">
                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveChanges()">Save Changes</button>
            </div>
        </form>
    </div>

    <script>
       document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('userId');
    if (userId) {
        loadUserData(userId);
    } else {
        console.error("No user ID provided");
    }
});

function loadUserData(userId) {
    fetch(`/stationery/crudFunction/editUser.php?userId=${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Populate the form fields with the user data
                document.getElementById('userId').value = data.data.user_id;
                document.getElementById('username').value = data.data.username;
                document.getElementById('staffName').value = data.data.staffName;
                document.getElementById('serviceName').value = data.data.serviceName;
                document.getElementById('userlevel').value = data.data.userlevel;

                // Populate the serviceName dropdown
                const serviceSelect = document.getElementById('serviceName');
                data.services.forEach(service => {
                    const option = document.createElement('option');
                    option.value = service.serviceName;
                    option.textContent = service.serviceName;
                    serviceSelect.appendChild(option);
                });

                // Populate the userlevel dropdown
                const userLevelSelect = document.getElementById('userlevel');
                data.userLevels.forEach(level => {
                    const option = document.createElement('option');
                    option.value = level;
                    option.textContent = level;
                    userLevelSelect.appendChild(option);
                });
            } else {
                // Log and alert error
                console.error('Error loading user data:', data.error);
                alert('Error loading user data: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading user data: ' + error.message);
        });
}

function saveChanges() {
    const form = document.getElementById('editUserForm');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    fetch('/stationery/crudFunction/editUser.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = '/stationery/admin/user.php?updated=true';
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving changes.');
    });
}

function cancelEdit() {
    if (confirm('Are you sure you want to cancel? All changes will be lost.')) {
        window.location.href = '/stationery/admin/user.php';
    }
}

function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
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
    window.location.href = "home.php";
}

    </script>
</body>
</html>