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
<<<<<<< HEAD
    <nav class="bg-white shadow-md fixed top-0 left-0 w-full z-50">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold">Hemova</a>
            <div>
                <?php if ($isLoggedIn): ?>
                    <a href="profile.php" class="text-gray-700 hover:text-gray-900 mx-2">Profile</a>
                    <a href="check_blood_availability.php" class="text-gray-700 hover:text-gray-900 mx-2">Check Blood Availability</a>
                    <a href="view_camps.php" class="text-gray-700 hover:text-gray-900 mx-2">View Camps</a>
                    <a href="about.php" class="text-gray-700 hover:text-gray-900 mx-2">About</a>
                    <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</a>
=======
    <nav class="fixed top-0 z-10 w-full bg-white shadow-md">
        <div class="container flex items-center justify-between p-4 mx-auto">
            <a href="index.php" class="text-2xl font-bold text-red-600">Hemova</a>
            <div class="space-x-4">
                <?php if ($isLoggedIn): ?>
                    <a href="profile.php" class="text-gray-700 transition duration-300 hover:text-red-600">Profile</a>
                    <a href="check_blood_availability.php" class="text-gray-700 transition duration-300 hover:text-red-600">Check Blood Availability</a>
                    <a href="viewCamps.php" class="text-gray-700 transition duration-300 hover:text-red-600">View Camps</a>
                    <a href="logout.php" class="px-4 py-2 text-white transition duration-300 bg-red-600 rounded hover:bg-red-700">Logout</a>
>>>>>>> 0d00b6714cae60ea81c1630edbba1a932a529b5d
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

<<<<<<< HEAD
    <div class="container mx-auto p-4 mt-12">
        <div class="grid grid-cols-1 md:grid-cols-2 ">
            
            <div class="bg-blue-900 text-white p-8 ">
                <h2 class="text-3xl font-bold mb-4 mt-12 ml-5">DONATING BLOOD</h2>
                <p class="mb-6 ml-5">Blood is made up of four main components: Red blood cells, platelets, plasma and white blood cells. Each whole blood donation has the potential to save up to three lives.</p>
                <div class="flex flex-wrap gap-4 ml-5">
                    <button class="bg-white text-blue-900 py-2 px-4 rounded-full font-semibold">Donor Eligibility</button>
                    <button class="bg-white text-blue-900 py-2 px-4 rounded-full font-semibold">EarlyQ</button>
                    <button class="bg-white text-blue-900 py-2 px-4 rounded-full font-semibold">Find a Location Near You</button>
                </div>
            </div>

            <div class="flex items-center justify-center">
                <img src="homeimg.jpg" alt="Blood Donor" class="shadow-lg max-w-full h-auto">
            </div>
        </div>
    </div>
    <div class="flex flex-wrap justify-center gap-8 mt-8">
        <!-- Flip Card 1 -->
        <div class="flip-card w-64 h-80 bg-transparent perspective-1000">
            <div class="flip-card-inner relative w-full h-full text-center transition-transform duration-700 ease-in-out transform-style-preserve-3d hover:rotate-y-180">
                <!-- Front Side -->
                <div class="flip-card-front absolute w-full h-full flex flex-col justify-center items-center shadow-lg border border-blue-500 rounded-xl bg-gradient-to-br from-blue-100 to-blue-300">
                    <div class="text-4xl text-blue-600 mb-4">
                        <i class="fas fa-hand-holding-heart"></i> <!-- Example FontAwesome Icon -->
                    </div>
                    <p class="title text-blue-600 text-2xl font-bold">Donate Blood</p>
                    <p class="text-gray-700 mt-2 px-4">Be a hero by donating blood and saving lives.</p>
                </div>
                <!-- Back Side -->
                <div class="flip-card-back absolute w-full h-full flex flex-col justify-center items-center shadow-lg border border-blue-500 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 rotate-y-180">
                    <p class="title text-white text-2xl font-bold">Learn More</p>
                    <p class="text-white mt-2 px-4">Discover how your donation can make a difference.</p>
                    <button class="mt-4 bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100">Read More</button>
                </div>
            </div>
        </div>

        <!-- Flip Card 2 -->
        <div class="flip-card w-64 h-80 bg-transparent perspective-1000">
            <div class="flip-card-inner relative w-full h-full text-center transition-transform duration-700 ease-in-out transform-style-preserve-3d hover:rotate-y-180">
                <!-- Front Side -->
                <div class="flip-card-front absolute w-full h-full flex flex-col justify-center items-center shadow-lg border border-green-500 rounded-xl bg-gradient-to-br from-green-100 to-green-300">
                    <div class="text-4xl text-green-600 mb-4">
                        <i class="fas fa-users"></i> <!-- Example FontAwesome Icon -->
                    </div>
                    <p class="title text-green-600 text-2xl font-bold">Join a Camp</p>
                    <p class="text-gray-700 mt-2 px-4">Participate in blood donation camps near you.</p>
                </div>
                <!-- Back Side -->
                <div class="flip-card-back absolute w-full h-full flex flex-col justify-center items-center shadow-lg border border-green-500 rounded-xl bg-gradient-to-br from-green-400 to-green-600 rotate-y-180">
                    <p class="title text-white text-2xl font-bold">Find Camps</p>
                    <p class="text-white mt-2 px-4">Locate and join blood donation camps in your area.</p>
                    <button class="mt-4 bg-white text-green-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100">View Camps</button>
                </div>
            </div>
        </div>

        <!-- Flip Card 3 -->
        <div class="flip-card w-64 h-80 bg-transparent perspective-1000">
            <div class="flip-card-inner relative w-full h-full text-center transition-transform duration-700 ease-in-out transform-style-preserve-3d hover:rotate-y-180">
                <!-- Front Side -->
                <div class="flip-card-front absolute w-full h-full flex flex-col justify-center items-center shadow-lg border border-red-500 rounded-xl bg-gradient-to-br from-red-100 to-red-300">
                    <div class="text-4xl text-red-600 mb-4">
                        <i class="fas fa-heartbeat"></i> <!-- Example FontAwesome Icon -->
                    </div>
                    <p class="title text-red-600 text-2xl font-bold">Save Lives</p>
                    <p class="text-gray-700 mt-2 px-4">Your blood donation can save up to three lives.</p>
                </div>
                <!-- Back Side -->
                <div class="flip-card-back absolute w-full h-full flex flex-col justify-center items-center shadow-lg border border-red-500 rounded-xl bg-gradient-to-br from-red-400 to-red-600 rotate-y-180">
                    <p class="title text-white text-2xl font-bold">Get Involved</p>
                    <p class="text-white mt-2 px-4">Learn how you can contribute to saving lives.</p>
                    <button class="mt-4 bg-white text-red-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100">Join Us</button>
                </div>
            </div>
        </div>
    </div>
=======
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
>>>>>>> 0d00b6714cae60ea81c1630edbba1a932a529b5d
</body>
</html>