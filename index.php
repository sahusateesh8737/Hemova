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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans antialiased bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="fixed top-0 left-0 z-50 w-full bg-white shadow-md">
        <div class="container flex items-center justify-between p-4 mx-auto">
            <a href="index.php" class="text-2xl font-bold text-red-600">Hemova</a>
            <div class="flex items-center space-x-4">
                <?php if ($isLoggedIn): ?>
                    <a href="profile.php" class="text-gray-700 transition hover:text-red-600">Profile</a>
                    <a href="check_blood_availability.php" class="text-gray-700 transition hover:text-red-600">Check Blood</a>
                    <a href="view_camps.php" class="text-gray-700 transition hover:text-red-600">View Camps</a>
                    <a href="about.php" class="text-gray-700 transition hover:text-red-600">About</a>
                    <a href="logout.php" class="px-4 py-2 text-white transition bg-red-600 rounded hover:bg-red-700">Logout</a>
                <?php elseif ($isHospitalLoggedIn): ?>
                    <a href="managecamps.php" class="text-gray-700 transition hover:text-red-600">Manage Camps</a>
                    <a href="logout.php" class="px-4 py-2 text-white transition bg-red-600 rounded hover:bg-red-700">Logout</a>
                <?php else: ?>
                    <a href="signin.php" class="text-gray-700 transition hover:text-red-600">Sign In</a>
                    <a href="signup.php" class="text-gray-700 transition hover:text-red-600">Sign Up</a>
                    <a href="hospitalLogin.html" class="text-gray-700 transition hover:text-red-600">Hospital Login</a>
                    <a href="hospitalRegister.html" class="text-gray-700 transition hover:text-red-600">Hospital Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="container px-4 py-12 mx-auto mt-20">
        <div class="grid items-center grid-cols-1 gap-8 md:grid-cols-2">
            <div class="p-8 text-white bg-blue-900 rounded-lg">
                <h2 class="mb-4 text-3xl font-bold md:text-4xl">Donating Blood Saves Lives</h2>
                <p class="mb-6">Blood consists of red blood cells, platelets, plasma, and white blood cells. Each donation can save up to three lives.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#eligibility" class="px-4 py-2 font-semibold text-blue-900 transition bg-white rounded-full hover:bg-gray-100">Donor Eligibility</a>
                    <a href="#locations" class="px-4 py-2 font-semibold text-blue-900 transition bg-white rounded-full hover:bg-gray-100">Find a Location</a>
                    <a href="#signup" class="px-4 py-2 font-semibold text-blue-900 transition bg-white rounded-full hover:bg-gray-100">Join Now</a>
                </div>
            </div>
            <div class="flex justify-center">
                <img src="homeimg.jpg" alt="Blood Donor" class="h-auto max-w-full rounded-lg shadow-lg">
            </div>
        </div>
    </section>

    <!-- Flip Cards Section -->
    <section class="container px-4 py-12 mx-auto">
        <div class="flex flex-wrap justify-center gap-8">
            <div class="w-full sm:w-64 h-80 perspective-1000">
                <div class="relative w-full h-full transition-transform duration-700 ease-in-out transform-style-preserve-3d hover:rotate-y-180">
                    <div class="absolute flex flex-col items-center justify-center w-full h-full border border-blue-500 shadow-lg bg-gradient-to-br from-blue-100 to-blue-300 rounded-xl backface-hidden">
                        <i class="mb-4 text-4xl text-blue-600 fas fa-hand-holding-heart"></i>
                        <p class="text-2xl font-bold text-blue-600">Donate Blood</p>
                        <p class="px-4 mt-2 text-gray-700">Be a hero by donating blood.</p>
                    </div>
                    <div class="absolute flex flex-col items-center justify-center w-full h-full border border-blue-500 shadow-lg bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl backface-hidden rotate-y-180">
                        <p class="text-2xl font-bold text-white">Learn More</p>
                        <p class="px-4 mt-2 text-white">Discover the impact of your donation.</p>
                        <button class="px-4 py-2 mt-4 font-semibold text-blue-600 bg-white rounded-lg hover:bg-gray-100">Read More</button>
                    </div>
                </div>
            </div>
            <div class="w-full sm:w-64 h-80 perspective-1000">
                <div class="relative w-full h-full transition-transform duration-700 ease-in-out transform-style-preserve-3d hover:rotate-y-180">
                    <div class="absolute flex flex-col items-center justify-center w-full h-full border border-green-500 shadow-lg bg-gradient-to-br from-green-100 to-green-300 rounded-xl backface-hidden">
                        <i class="mb-4 text-4xl text-green-600 fas fa-users"></i>
                        <p class="text-2xl font-bold text-green-600">Join a Camp</p>
                        <p class="px-4 mt-2 text-gray-700">Participate in local camps.</p>
                    </div>
                    <div class="absolute flex flex-col items-center justify-center w-full h-full border border-green-500 shadow-lg bg-gradient-to-br from-green-400 to-green-600 rounded-xl backface-hidden rotate-y-180">
                        <p class="text-2xl font-bold text-white">Find Camps</p>
                        <p class="px-4 mt-2 text-white">Locate nearby donation camps.</p>
                        <button class="px-4 py-2 mt-4 font-semibold text-green-600 bg-white rounded-lg hover:bg-gray-100">View Camps</button>
                    </div>
                </div>
            </div>
            <div class="w-full sm:w-64 h-80 perspective-1000">
                <div class="relative w-full h-full transition-transform duration-700 ease-in-out transform-style-preserve-3d hover:rotate-y-180">
                    <div class="absolute flex flex-col items-center justify-center w-full h-full border border-red-500 shadow-lg bg-gradient-to-br from-red-100 to-red-300 rounded-xl backface-hidden">
                        <i class="mb-4 text-4xl text-red-600 fas fa-heartbeat"></i>
                        <p class="text-2xl font-bold text-red-600">Save Lives</p>
                        <p class="px-4 mt-2 text-gray-700">One donation, three lives saved.</p>
                    </div>
                    <div class="absolute flex flex-col items-center justify-center w-full h-full border border-red-500 shadow-lg bg-gradient-to-br from-red-400 to-red-600 rounded-xl backface-hidden rotate-y-180">
                        <p class="text-2xl font-bold text-white">Get Involved</p>
                        <p class="px-4 mt-2 text-white">Join the life-saving mission.</p>
                        <button class="px-4 py-2 mt-4 font-semibold text-red-600 bg-white rounded-lg hover:bg-gray-100">Join Us</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blood Group Compatibility Section -->
    <section id="eligibility" class="container px-4 py-12 mx-auto bg-white rounded-lg shadow-md">
        <h2 class="mb-8 text-3xl font-bold text-center text-gray-800">Blood Group Compatibility</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-white bg-red-600">
                        <th class="p-4">Blood Type</th>
                        <th class="p-4">Can Donate To</th>
                        <th class="p-4">Can Receive From</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-4">A+</td>
                        <td class="p-4">A+, AB+</td>
                        <td class="p-4">A+, A-, O+, O-</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-4">A-</td>
                        <td class="p-4">A+, A-, AB+, AB-</td>
                        <td class="p-4">A-, O-</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-4">B+</td>
                        <td class="p-4">B+, AB+</td>
                        <td class="p-4">B+, B-, O+, O-</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-4">B-</td>
                        <td class="p-4">B+, B-, AB+, AB-</td>
                        <td class="p-4">B-, O-</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-4">AB+</td>
                        <td class="p-4">AB+</td>
                        <td class="p-4">All Blood Types</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-4">AB-</td>
                        <td class="p-4">AB+, AB-</td>
                        <td class="p-4">AB-, A-, B-, O-</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-4">O+</td>
                        <td class="p-4">O+, A+, B+, AB+</td>
                        <td class="p-4">O+, O-</td>
                    </tr>
                    <tr>
                        <td class="p-4">O-</td>
                        <td class="p-4">All Blood Types</td>
                        <td class="p-4">O-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Eligibility Criteria Section -->
    <section class="container px-4 py-12 mx-auto">
        <h2 class="mb-8 text-3xl font-bold text-center text-gray-800">Who Can Donate?</h2>
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
            <div class="p-6 rounded-lg shadow-md bg-green-50">
                <h3 class="mb-4 text-xl font-semibold text-green-600">Eligible Donors</h3>
                <ul class="pl-5 space-y-2 text-gray-700 list-disc">
                    <li>Age: 17-65 (16 with parental consent in some regions)</li>
                    <li>Weight: At least 110 lbs (50 kg)</li>
                    <li>Good general health</li>
                    <li>No recent tattoos or piercings (within 6 months)</li>
                    <li>No cold, flu, or fever on donation day</li>
                </ul>
            </div>
            <div class="p-6 rounded-lg shadow-md bg-red-50">
                <h3 class="mb-4 text-xl font-semibold text-red-600">Cannot Donate</h3>
                <ul class="pl-5 space-y-2 text-gray-700 list-disc">
                    <li>Pregnant or breastfeeding women</li>
                    <li>Recent surgery or blood transfusion (within 6 months)</li>
                    <li>Chronic illnesses (e.g., diabetes, heart disease)</li>
                    <li>HIV/AIDS or hepatitis positive</li>
                    <li>Under medication for serious conditions</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Donation Facts Section -->
    <section class="container px-4 py-12 mx-auto bg-gray-200">
        <h2 class="mb-8 text-3xl font-bold text-center text-gray-800">Blood Donation Facts</h2>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
            <div class="p-6 text-center bg-white rounded-lg shadow-md">
                <i class="mb-4 text-3xl text-red-600 fas fa-tint"></i>
                <p class="text-lg font-semibold">1 Donation = 3 Lives</p>
                <p class="text-gray-600">Each donation can help multiple patients.</p>
            </div>
            <div class="p-6 text-center bg-white rounded-lg shadow-md">
                <i class="mb-4 text-3xl text-red-600 fas fa-clock"></i>
                <p class="text-lg font-semibold">EveryCUL8 Every 8 Weeks</p>
                <p class="text-gray-600">You can donate every 56 days, up to 6 times a year.</p>
            </div>
            <div class="p-6 text-center bg-white rounded-lg shadow-md">
                <i class="mb-4 text-3xl text-red-600 fas fa-users"></i>
                <p class="text-lg font-semibold">High Demand</p>
                <p class="text-gray-600">Someone needs blood every 2 seconds.</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section id="signup" class="container px-4 py-12 mx-auto text-center">
        <h2 class="mb-4 text-3xl font-bold text-gray-800">Ready to Make a Difference?</h2>
        <p class="mb-6 text-gray-600">Join our community of donors and help save lives today!</p>
        <a href="signup.php" class="px-6 py-3 font-semibold text-white transition bg-red-600 rounded-full hover:bg-red-700">Sign Up Now</a>
    </section>

    <!-- Footer -->
    <footer class="py-6 text-white bg-gray-800">
        <div class="container px-4 mx-auto text-center">
            <p>&copy; 2025 Hemova. All rights reserved.</p>
            <div class="flex justify-center mt-4 space-x-4">
                <a href="#" class="hover:text-red-600"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-red-600"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-red-600"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>