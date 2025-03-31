<?php
session_start();
include 'dbconnection.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['currUserID']);
$isHospitalLoggedIn = isset($_SESSION['hospital_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Hemova</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            overflow-x: hidden;
            color: #fff;
            background-color: #0a0a0a;
        }

        /* 3D Background Effect */
        #bg-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(200, 0, 0, 0.1);
            box-shadow: 0 0 20px rgba(200, 0, 0, 0.3);
            animation: float 15s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        /* Navigation - Updated for PHP session handling */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(200, 0, 0, 0.3);
        }

        .logo {
            display: flex;
            align-items: center;
            color: #fff;
        }

        .logo i {
            font-size: 24px;
            margin-right: 10px;
        }

        .logo h1 {
            font-size: 24px;
            font-weight: bold;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #dc2626;
        }

        .cta-button {
            padding: 10px 20px;
            background-color: #dc2626;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #ef4444;
        }
    </style>
</head>
<body>
    <!-- 3D Background -->
    <div id="bg-container"></div>

    <!-- Navigation - Updated for PHP session handling -->
    <header>
        <div class="logo">
            <i class="fas fa-tint"></i>
            <h1>Hemova</h1>
        </div>
        <nav>
            <ul>
                <?php if ($isLoggedIn): ?>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="check_blood_availability.php">Check Blood</a></li>
                    <li><a href="view_camps.php">View Camps</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="logout.php" class="cta-button">Logout</a></li>
                <?php elseif ($isHospitalLoggedIn): ?>
                    <li><a href="managecamps.php">Manage Camps</a></li>
                    <li><a href="logout.php" class="cta-button">Logout</a></li>
                <?php else: ?>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#process">Process</a></li>
                    <li><a href="signin.php" class="cta-button">Sign In</a></li>
                    <li><a href="signup.php">Sign Up</a></li>
                    <li><a href="hospitalLogin.html">Hospital Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="container px-4 py-12 mt-6">
        <div class="grid items-center grid-cols-1 md:grid-cols-2">
            <div class="p-20 text-white bg-blue-900 ">
                <h2 class="mb-4 text-3xl font-bold md:text-4xl">Donating Blood Saves Lives</h2>
                <p class="mb-6">Blood consists of red blood cells, platelets, plasma, and white blood cells. Each donation can save up to three lives.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#eligibility" class="px-4 py-2 font-semibold text-blue-900 transition bg-white rounded-full hover:bg-gray-100">Donor Eligibility</a>
                    <a href="#locations" class="px-4 py-2 font-semibold text-blue-900 transition bg-white rounded-full hover:bg-gray-100">Find a Location</a>
                    <a href="#signup" class="px-4 py-2 font-semibold text-blue-900 transition bg-white rounded-full hover:bg-gray-100">Join Now</a>
                </div>
            </div>
            <div class="flex justify-center ">
                <img src="homeimg.jpg" alt="Blood Donor" class="h-auto max-w-full rounded-lg shadow-lg">
            </div>
        </div>
    </section>

    <!-- JavaScript for 3D Background Animation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bgContainer = document.getElementById('bg-container');
            const colors = ['rgba(200, 0, 0, 0.1)', 'rgba(150, 0, 0, 0.1)', 'rgba(255, 50, 50, 0.1)'];
            
            // Create floating circles
            for (let i = 0; i < 15; i++) {
                const circle = document.createElement('div');
                circle.classList.add('bg-circle');
                
                // Random properties
                const size = Math.random() * 200 + 50;
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                const color = colors[Math.floor(Math.random() * colors.length)];
                const delay = Math.random() * 15;
                const duration = Math.random() * 10 + 10;
                
                // Apply styles
                circle.style.width = `${size}px`;
                circle.style.height = `${size}px`;
                circle.style.left = `${posX}%`;
                circle.style.top = `${posY}%`;
                circle.style.background = color;
                circle.style.animationDelay = `${delay}s`;
                circle.style.animationDuration = `${duration}s`;
                
                bgContainer.appendChild(circle);
            }
        });
    </script>
</body>
</html>






<!-- Hero Section -->
    <!-- <section class="container px-4 py-12 mt-6">
        <div class="grid items-center grid-cols-1 md:grid-cols-2">
            <div class="p-20 text-white bg-blue-900 ">
                <h2 class="mb-4 text-3xl font-bold md:text-4xl">Donating Blood Saves Lives</h2>
                <p class="mb-6">Blood consists of red blood cells, platelets, plasma, and white blood cells. Each donation can save up to three lives.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#eligibility" class="px-4 py-2 font-semibold text-blue-900 transition bg-white rounded-full hover:bg-gray-100">Donor Eligibility</a>
                    <a href="#locations" class="px-4 py-2 font-semibold text-blue-900 transition bg-white rounded-full hover:bg-gray-100">Find a Location</a>
                    <a href="#signup" class="px-4 py-2 font-semibold text-blue-900 transition bg-white rounded-full hover:bg-gray-100">Join Now</a>
                </div>
            </div>
            <div class="flex justify-center ">
                <img src="homeimg.jpg" alt="Blood Donor" class="h-auto max-w-full rounded-lg shadow-lg">
            </div>
        </div>
    </section> -->