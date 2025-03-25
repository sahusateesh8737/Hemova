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
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="font-sans bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="fixed top-0 z-10 w-full bg-white shadow-md">
        <div class="container flex items-center justify-between p-4 mx-auto">
            <a href="index.php" class="text-2xl font-bold text-red-600">Hemova</a>
            <div class="space-x-4">
                <?php if ($isLoggedIn): ?>
                    <a href="profile.php" class="text-gray-700 transition duration-300 hover:text-red-600">Profile</a>
                    <a href="check_blood_availability.php" class="text-gray-700 transition duration-300 hover:text-red-600">Check Blood Availability</a>
                    <a href="viewCamps.php" class="text-gray-700 transition duration-300 hover:text-red-600">View Camps</a>
                    <a href="logout.php" class="px-4 py-2 text-white transition duration-300 bg-red-600 rounded hover:bg-red-700">Logout</a>
                <?php elseif ($isHospitalLoggedIn): ?>
                    <a href="managecamps.php" class="text-gray-700 transition duration-300 hover:text-red-600">Manage Camps</a>
                    <a href="logout.php" class="px-4 py-2 text-white transition duration-300 bg-red-600 rounded hover:bg-red-700">Logout</a>
                <?php else: ?>
                    <a href="signin.php" class="text-gray-700 transition duration-300 hover:text-red-600">Sign In</a>
                    <a href="signup.php" class="text-gray-700 transition duration-300 hover:text-red-600">Sign Up</a>
                    <a href="hospitalLogin.html" class="text-gray-700 transition duration-300 hover:text-red-600">Hospital Login</a>
                    <a href="hospitalRegister.html" class="text-gray-700 transition duration-300 hover:text-red-600">Hospital Registration</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-20 mt-16 bg-red-50">
        <div class="container flex flex-col items-center mx-auto md:flex-row">
            <div class="text-center md:w-1/2 md:text-left">
                <h1 class="mb-4 text-4xl font-bold text-red-600 md:text-5xl">Save Lives with Hemova</h1>
                <p class="mb-6 text-lg text-gray-700">Join our community to donate blood, check availability, or organize blood donation camps. Together, we can make a difference.</p>
                <?php if (!$isLoggedIn && !$isHospitalLoggedIn): ?>
                    <a href="signup.php" class="px-6 py-3 text-white transition duration-300 bg-red-600 rounded-full hover:bg-red-700">Become a Donor</a>
                <?php endif; ?>
            </div>
            <div class="mt-8 md:w-1/2 md:mt-0">
                <img src="https://via.placeholder.com/500x400?text=Blood+Donation" alt="Blood Donation" class="rounded-lg shadow-md">
            </div>
        </div>
    </section>

    <!-- Call-to-Action Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto text-center">
            <h2 class="mb-6 text-3xl font-bold text-gray-800">How You Can Help</h2>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="p-6 bg-red-100 rounded-lg shadow-md">
                    <h3 class="mb-2 text-xl font-semibold text-red-600">Donate Blood</h3>
                    <p class="text-gray-600">Register as a donor and save lives by donating blood at nearby camps.</p>
                    <?php if ($isLoggedIn): ?>
                        <a href="view_camps.php" class="inline-block mt-4 text-red-600 hover:underline">Find a Camp</a>
                    <?php endif; ?>
                </div>
                <div class="p-6 bg-red-100 rounded-lg shadow-md">
                    <h3 class="mb-2 text-xl font-semibold text-red-600">Check Availability</h3>
                    <p class="text-gray-600">Find out which blood types are available in real-time.</p>
                    <?php if ($isLoggedIn): ?>
                        <a href="check_blood_availability.php" class="inline-block mt-4 text-red-600 hover:underline">Check Now</a>
                    <?php endif; ?>
                </div>
                <div class="p-6 bg-red-100 rounded-lg shadow-md">
                    <h3 class="mb-2 text-xl font-semibold text-red-600">Organize a Camp</h3>
                    <p class="text-gray-600">Hospitals can manage and schedule blood donation camps.</p>
                    <?php if ($isHospitalLoggedIn): ?>
                        <a href="managecamps.php" class="inline-block mt-4 text-red-600 hover:underline">Manage Camps</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Blood Donation Stats Section -->
    <section class="py-12 bg-gray-200">
        <div class="container mx-auto text-center">
            <h2 class="mb-6 text-3xl font-bold text-gray-800">Our Impact</h2>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <div>
                    <p class="text-4xl font-bold text-red-600">500+</p>
                    <p class="text-gray-600">Donors Registered</p>
                </div>
                <div>
                    <p class="text-4xl font-bold text-red-600">300+</p>
                    <p class="text-gray-600">Units Collected</p>
                </div>
                <div>
                    <p class="text-4xl font-bold text-red-600">50+</p>
                    <p class="text-gray-600">Camps Organized</p>
                </div>
                <div>
                    <p class="text-4xl font-bold text-red-600">200+</p>
                    <p class="text-gray-600">Lives Saved</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-6 text-white bg-red-600">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Hemova. All rights reserved.</p>
            <div class="mt-2">
                <a href="#" class="mx-2 text-white hover:underline">Privacy Policy</a>
                <a href="#" class="mx-2 text-white hover:underline">Terms of Service</a>
                <a href="#" class="mx-2 text-white hover:underline">Contact Us</a>
            </div>
        </div>
    </footer>
</body>
</html>