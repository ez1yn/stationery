<?php
session_start();  

if (!isset($_SESSION['loggedin']) || $_SESSION['userlevel'] !== 'Admin') {
    header("Location: ../index.php?error=" . urlencode("Unauthorized access. Please log in first."));
    exit;
}
?>

<?php
// Define the page title for this page
$page_title = "Category";

// Include the header file
include('../header.php');  // or the full path to your header file

// Page content starts here
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $page_title; ?></title>
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
                width: 600px;
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
                background-color:#2c3e50;
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
                margin: 150px auto 40px;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .top-controls {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
            }
            .add-category-btn {
                padding: 6px 20px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 20px;
                cursor: pointer;
                transition: background-color 0.3s, box-shadow 0.3s;
                font-size: 15px;
            }
            .add-category-btn:hover {
                background-color: #45a049;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            table {
                width: 100%;
                border-collapse: collapse;
                background-color: white;
                margin-top: 5px;
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
                padding: 10px 15px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s, transform 0.3s;
                margin-right: 5px;
            }
            .edit-btn {
                background-color: #FFA500;
                color: white;
            }
            .edit-btn:hover {
                background-color: #FF8C00;
                transform: scale(1.05);
            }
            .remove-btn {
                background-color: #f44336;
                color: white;
            }
            .remove-btn:hover {
                background-color: #e53935;
                transform: scale(1.05);
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

            .text-center {
                text-align: center;
            }
        </style>
    </head>
    <body>

    <div class="container" style="margin-top: 10%;">
            <div class="top-controls">
                <div class="search-container">
                    <input type="text" id="categorySearch" placeholder="Search categories...">
                    <button onclick="searchCategories()">Search</button>
                </div>
                <button class="add-category-btn" onclick="showAddCategoryModal()">Add Category</button> 
            </div>

            <!-- Updated modal with proper styling -->
            <div class="modal" id="addCategoryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
                <div class="modal-content" style="background: white; padding: 20px; border-radius: 8px; width: 80%; max-width: 500px; margin: 50px auto; position: relative;">
                    <span onclick="closeModal()" style="position: absolute; right: 10px; top: 10px; cursor: pointer; font-size: 20px;">&times;</span>
                    <h2 style="margin-bottom: 20px;">Add New Category</h2>
                    <form id="addCategoryForm" onsubmit="handleCategorySubmit(event)">
                        <div style="margin-bottom: 15px;">
                            <label for="categoryName" style="display: block; margin-bottom: 5px;">Category Name:</label>
                            <input type="text" id="categoryName" name="title" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label for="categoryImage" style="display: block; margin-bottom: 5px;">Category Image:</label>
                            <input type="file" id="categoryImage" name="image" accept="image/*" required style="width: 100%;">
                        </div>
                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button" onclick="closeModal()" style="padding: 8px 15px; border: 1px solid #ddd; background: #fff; border-radius: 4px;">Cancel</button>
                            <button type="submit" style="padding: 8px 15px; background: #4CAF50; color: white; border: none; border-radius: 4px;">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table remains the same -->
            <table id="categoryTable">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>CATEGORY NAME</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                </tbody>
            </table>

            <div id="noCategoryResults" class="no-results">
                No category found.
            </div>
        </div>

        <script>
           function loadCategories() {
            fetch('/stationery/fetchFunction/fetch_category.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'error') {
                        throw new Error(data.message);
                    }
                    
                    const tableBody = document.getElementById('categoryTableBody');
                    tableBody.innerHTML = '';
                    
                    if (!data.categories || data.categories.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="3">No categories found</td></tr>';
                        return;
                    }

                    data.categories.forEach((category, index) => {
                        const row = tableBody.insertRow();
                        row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${category.title}</td>
                            <td>
                                <button class="action-btn edit-btn" onclick="editCategory(${category.category_id}, '${category.title}')">Edit</button>
                                <button class="action-btn remove-btn" onclick="removeCategory(${category.category_id})">Remove</button>
                            </td>
                        `;
                    });
                })
                .catch(error => {
                    console.error('Error loading categories:', error);
                    const tableBody = document.getElementById('categoryTableBody');
                    tableBody.innerHTML = `<tr><td colspan="3">Error loading categories: ${error.message}</td></tr>`;
                });
             }

            function addCategory() {
                const title = prompt("Enter new category name:");
                if (!title) return;

                const fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.accept = 'image/*';
                
                fileInput.onchange = function(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    const formData = new FormData();
                    formData.append('title', title);
                    formData.append('image', file);

                    fetch('/stationery/crudFunction/addCategory.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.success) loadCategories();
                    })
                    .catch(error => console.error('Error:', error));
                };

                fileInput.click();
            }

            function closeModal() {
                document.getElementById('addCategoryModal').style.display = 'none';
            }

            function editCategory(id, currentName) {
                const newName = prompt("Edit category name:", currentName);
                if (newName && newName !== currentName) {
                    fetch('/stationery/crudFunction/editCategory.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `id=${id}&title=${encodeURIComponent(newName)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.success) loadCategories();
                    })
                    .catch(error => console.error('Error:', error));
                }
            }

          // Update the removeCategory function in category.php
          function removeCategory(id) {
            if (!id || id <= 0) {
                alert("Invalid category ID");
                return;
            }

            if (confirm("Are you sure you want to remove this category?")) {
                const formData = new FormData();
                formData.append('category_id', id);

                fetch('/stationery/crudFunction/deleteCategory.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        loadCategories(); // Reload the categories table
                    } else {
                        alert(data.message || "Error deleting category");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("An error occurred while deleting the category. Please try again.");
                });
            }
        }

        function searchCategories() {
            const input = document.getElementById("categorySearch");
            const filter = input.value.toLowerCase();
            const tableBody = document.getElementById("categoryTableBody");
            const rows = tableBody.getElementsByTagName("tr");
            const noResults = document.getElementById("noCategoryResults");
            const table = document.getElementById("categoryTable");
            let found = false;

            for (let i = 0; i < rows.length; i++) {
                const categoryName = rows[i].cells[1].textContent.toLowerCase();
                if (categoryName.includes(filter)) {
                    rows[i].style.display = "";
                    found = true;
                } else {
                    rows[i].style.display = "none";
                }
            }

            // Show/hide the "No results" message
            noResults.style.display = found ? 'none' : 'block';
            
            // Show/hide the table based on results
            table.style.display = found ? 'table' : 'none';
        }

        // Add event listener for real-time search
        document.getElementById("categorySearch").addEventListener("input", searchCategories);

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

        function showAddCategoryModal() {
            document.getElementById('addCategoryModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('addCategoryModal').style.display = 'none';
            document.getElementById('addCategoryForm').reset();
        }

        async function handleCategorySubmit(event) {
        event.preventDefault();
    
            try {
                const form = event.target;
                const formData = new FormData(form);

                const response = await fetch('/stationery/crudFunction/addCategory.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                
                if (data.success) {
                    alert(data.message);
                    closeModal();
                    loadCategories();
                    form.reset(); // Reset the form after successful submission
                } else {
                    alert(data.message); // Show the error message from the server
                }
            } catch (error) {
                console.error('Error details:', error);
                alert('An error occurred while adding the category. Please try again.');
            }
        }

        // Add form validation
        document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
            const titleInput = document.getElementById('categoryName');
            const title = titleInput.value.trim();
            
            if (title.length === 0) {
                e.preventDefault();
                alert('Please enter a category name.');
                return;
            }
            
            // You could add more validation here if needed
        });

        // Add this to your existing code to help with debugging
        function loadCategories() {
            fetch('/stationery/fetchFunction/fetch_category.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const tableBody = document.getElementById('categoryTableBody');
                    tableBody.innerHTML = '';
                    
                    if (!data.categories || data.categories.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="3" class="text-center">No categories found</td></tr>';
                        return;
                    }

                    data.categories.forEach((category, index) => {
                        const row = tableBody.insertRow();
                        // Sanitize the category title to prevent XSS
                        const sanitizedTitle = category.title
                            .replace(/&/g, '&amp;')
                            .replace(/</g, '&lt;')
                            .replace(/>/g, '&gt;')
                            .replace(/"/g, '&quot;')
                            .replace(/'/g, '&#039;');
                        
                        row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${sanitizedTitle}</td>
                            <td>
                                <button class="action-btn edit-btn" onclick="editCategory(${category.category_id}, '${sanitizedTitle}')">Edit</button>
                                <button class="action-btn remove-btn" onclick="removeCategory(${category.category_id})">Remove</button>
                            </td>
                        `;
                    });
                })
                .catch(error => {
                    console.error('Error loading categories:', error);
                    const tableBody = document.getElementById('categoryTableBody');
                    tableBody.innerHTML = `<tr><td colspan="3" class="text-center">Error loading categories. Please try again.</td></tr>`;
                });
        }
        document.addEventListener('DOMContentLoaded', loadCategories);
        </script>

    </body>
</html>