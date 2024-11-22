<?php
require_once '../session_helper.php';
check_user_access();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPJ</title>
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
            padding: 5px 20px; /* Reduced padding */
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
            margin: 10px auto 20px;
        }

        .logo {
            max-width: 200px;
        }

        .logo img {
            width: 100%;
            height: auto;
        }

        .search-container {
            flex-grow: 1;
            margin: 1px auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .search-container input[type="text"] {
            padding: 8px; /* Reduced padding */
            width: 500px; /* Reduced width */
            border-radius: 20px;
            border: 1px solid #ccc;
            transition: all 0.3s ease;
            font-size: 14px; /* Reduced font size */
        }

        .search-container button {
            padding: 8px 12px; /* Reduced padding */
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-left: 10px;
            font-size: 14px; /* Reduced font size */
        }

        .search-container button:hover {
            background-color: #003d82;
        }

        .page-title {
            text-align: center;
            color: white;
            font-size: 20px; /* Reduced font size */
            font-weight: bold;
            margin: 5px 0; /* Reduced margin */
            padding: 5px; /* Reduced padding */
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
            padding: 8px; /* Reduced padding */
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .button-container button:hover {
            background-color: #f2f2f2;
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

        .main-content {
            margin-top: 130px; /* Adjusted for the smaller header */
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .slider-container {
            position: relative;
            width: 100%;
            max-width: 900px;
            margin: 30px auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .slider {
            position: relative;
            height: 250px; /* Reduced height */
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            min-width: 100%;
            position: relative;
        }

        .slide img {
            width: 100%;
            height: 250px; /* Reduced height */
            object-fit: cover;
            border-radius: 15px;
        }

        .slider-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .slider-nav span {
            font-size: 24px; /* Reduced font size */
            color: #fff;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 5px; /* Reduced padding */
            cursor: pointer;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .slider-nav span:hover {
            background-color: rgba(74, 144, 226, 0.8);
        }

        .categories h2 {
            font-size: 22px; /* Reduced font size */
            margin-bottom: 20px; /* Reduced margin */
            color: #1c2331;
            text-align: center;
            font-weight: bold;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px; /* Reduced gap */
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .category-item {
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
            /* Add these new properties */
            height: 150px; /* Fixed height */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .category-item img {
            width: 80px; /* Fixed width */
            height: 80px; /* Fixed height */
            object-fit: cover; /* This will maintain aspect ratio */
            margin-bottom: 10px;
            transition: transform 0.3s ease;
        }

        .category-item p {
            margin: 0;
            font-size: 14px;
            color: #333;
        }

        .category-item a {
            text-decoration: none;
            color: inherit;
        }

        .category-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .category-item:hover img {
            transform: scale(1.1);
        }

        footer {
            background-color: #2c3e50;
            color: #ffffff;
            text-align: center;
            padding: 15px; /* Reduced padding */
            margin-top: 50px;
        }

        .bottom-bar {
            background-color: #34495e;
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
            color: #a0a0a0;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 10px;
            }

            .navigation ul {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        .page-title {
            text-align: center;
            color: white;
            font-size: 20px;
            font-weight: bold;
            margin: 10px auto;
            padding: 5px;
            background-color: rgba(0,0,0,0.1);
            border-radius: 5px;
            width: 100%;
            max-width: 300px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
        }
    </style>
</head>
<body>
<?php
$page_title = "Home";

include('../userHeader.php');  
?>
    <div class="main-content">
        <div class="slider-container">
            <div class="slider">
                <div class="slides">
                    <div class="slide">
                        <img src="/stationery/images/slide3.jpg" alt="Slide 1">
                    </div>
                    <div class="slide">
                        <img src="/stationery/images/slider1.jpg" alt="Slide 2">
                    </div>
                    <div class="slide">
                        <img src="/stationery/images/slider2.jpg" alt="Slide 3">
                    </div>
                </div>
                <div class="slider-nav">
                    <span class="prev">&#10094;</span>
                    <span class="next">&#10095;</span>
                </div>
            </div>
        </div>
        <div class="search-container">
                <input type="text" placeholder="Search...">
                <button onclick="performSearch()">Search</button>
        </div>

        <section class="categories">
            <h2>Categories</h2>
            <div class="categories-grid" id="categories-grid">
                <!-- Categories will be populated dynamically -->
            </div>
        </section>
    </div>

    <footer>
        <div class="bottom-bar">
            <p>&copy; 2024 KPJ Specialist Hospital. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function performSearch() {
            const searchQuery = document.querySelector('.search-container input[type="text"]').value.toLowerCase();
            const categoriesGrid = document.getElementById('categories-grid');
            
            categoriesGrid.innerHTML = '';

            fetch('/stationery/fetchFunction/fetchCategories.php')
                .then(response => response.json())
                .then(categories => {
                    const filteredCategories = categories.filter(category => 
                        category.title.toLowerCase().includes(searchQuery)
                    );
                    
                    if (filteredCategories.length === 0) {
                        categoriesGrid.innerHTML = '<p>No categories found matching your search.</p>';
                        return;
                    }
                    
                    filteredCategories.forEach(category => {
                        const categoryItem = document.createElement('div');
                        categoryItem.className = 'category-item';
                        categoryItem.innerHTML = `
                            <a href="/stationery/user/items.php?category=${encodeURIComponent(category.title)}">
                                <div class="category-image-container">
                                    <img src="${category.image_path || '/stationery/images/default-category.jpg'}" 
                                        alt="${category.title}" 
                                        onerror="this.src='/stationery/images/default-category.jpg'">
                                </div>
                                <p>${category.title}</p>
                            </a>
                        `;
                        categoriesGrid.appendChild(categoryItem);
                    });
                })
                .catch(error => {
                    console.error('Error searching categories:', error);
                    categoriesGrid.innerHTML = '<p>Error searching categories. Please try again later.</p>';
                });
        }

        document.querySelector('.search-container input[type="text"]').addEventListener('input', function() {
            performSearch();
        });

        function loadCategories() {
            const categoriesGrid = document.getElementById('categories-grid');
            categoriesGrid.innerHTML = ''; 
            
            fetch('/stationery/fetchFunction/fetchCategories.php')
                .then(response => response.json())
                .then(categories => {
                    categories.forEach(category => {
                        const categoryItem = document.createElement('div');
                        categoryItem.className = 'category-item';
                        categoryItem.innerHTML = `
                            <a href="/stationery/user/items.php?category=${category.id}">
                                <img src="${category.image_path}" alt="${category.title}" onerror="this.src='/stationery/images/default-category.jpg'">
                                <p>${category.title}</p>
                            </a>
                        `;
                        categoriesGrid.appendChild(categoryItem);
                    });
                })
                .catch(error => console.error('Error loading categories:', error));
        }

        // Function to populate categories
        function populateCategories() {
            const categoriesGrid = document.getElementById('categories-grid');
            categoriesGrid.innerHTML = ''; 
            
            fetch('/stationery/fetchFunction/fetchCategories.php')
                .then(response => response.json())
                .then(categories => { 
                    categories.forEach(category => {
                        const categoryItem = document.createElement('div');
                        categoryItem.className = 'category-item';
                        
                        categoryItem.innerHTML = `
                            <a href="/stationery/user/items.php?category=${encodeURIComponent(category.title)}">
                                <div class="category-image-container">
                                    <img src="${category.image_path || '/stationery/images/default-category.jpg'}" 
                                        alt="${category.title}" 
                                        onerror="this.src='/stationery/images/default-category.jpg'">
                                </div>
                                <p>${category.title}</p>
                            </a>
                        `;
                        categoriesGrid.appendChild(categoryItem);
                    });
                })
                .catch(error => {
                    console.error('Error loading categories:', error);
                    categoriesGrid.innerHTML = '<p>Error loading categories. Please try again later.</p>';
                });
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

        function goCart() {
            window.location.href = "/stationery/user/cart.php";
        }

        // Slider functionality
        const slides = document.querySelector('.slides');
        const slideImages = document.querySelectorAll('.slide');
        const prevBtn = document.querySelector('.prev');
        const nextBtn = document.querySelector('.next');
        let counter = 0;
        const size = slideImages[0].clientWidth;
        let autoSlideInterval;

        function nextSlide() {
            if (counter >= slideImages.length - 1) {
                counter = -1;
            }
            slides.style.transition = "transform 0.5s ease-in-out";
            counter++;
            slides.style.transform = 'translateX(' + (-size * counter) + 'px)';
        }

        function prevSlide() {
            if (counter <= 0) {
                counter = slideImages.length;
            }
            slides.style.transition = "transform 0.5s ease-in-out";
            counter--;
            slides.style.transform = 'translateX(' + (-size * counter) + 'px)';
        }

        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, 5000);
        }

        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }

        // Event listeners
        nextBtn.addEventListener('click', () => {
            nextSlide();
            resetAutoSlide();
        });

        prevBtn.addEventListener('click', () => {
            prevSlide();
            resetAutoSlide();
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            populateCategories();
            startAutoSlide();
        });
    </script>
</body>
</html>