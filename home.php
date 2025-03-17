<?php
session_start();
include 'dbconnection.php';

// Check if user is logged in
if (!isset($_SESSION['currUserID'])) {
    header("Location: signin.php");
    exit();
}
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
            <a href="home.php" class="text-2xl font-bold">Hemova</a>
            <div>
                <a href="profile.php" class="text-gray-700 hover:text-gray-900 mx-2">Profile</a>
                <a href="check_blood_availability.php" class="text-gray-700 hover:text-gray-900 mx-2">Settings</a>
                <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4 text-center">Welcome to Hemova</h1>
        <p class="text-center">This is the home page.</p>
    </div>
</body>
</html>