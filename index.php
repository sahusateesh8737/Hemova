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
    <title>Home</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold">Hemova</a>
            <div>
                <?php if ($isLoggedIn): ?>
                    <a href="profile.php" class="text-gray-700 hover:text-gray-900 mx-2">Profile</a>
                    <a href="check_blood_availability.php" class="text-gray-700 hover:text-gray-900 mx-2">Check Blood Availability</a>
                    <a href="view_camps.php" class="text-gray-700 hover:text-gray-900 mx-2">View Camps</a>
                    <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</a>
                <?php elseif ($isHospitalLoggedIn): ?>
                    <a href="managecamps.php" class="text-gray-700 hover:text-gray-900 mx-2">Manage Camps</a>
                    <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</a>
                <?php else: ?>
                    <a href="signin.php" class="text-gray-700 hover:text-gray-900 mx-2">Sign In</a>
                    <a href="signup.php" class="text-gray-700 hover:text-gray-900 mx-2">Sign Up</a>
                    <a href="hospitalLogin.html" class="text-gray-700 hover:text-gray-900 mx-2">Hospital Login</a>
                    <a href="hospitalRegister.html" class="text-gray-700 hover:text-gray-900 mx-2">Hospital Registration</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4 text-center">Welcome to Hemova</h1>
        <p class="text-center">This is the home page.</p>
    </div>
</body>
</html>