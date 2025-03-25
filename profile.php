<?php
session_start();
include 'dbconnection.php';
include 'components/navbar.php';

// Navbar component

function renderNavbar($isLoggedIn, $isHospitalLoggedIn) {
    // Example implementation of renderNavbar
    if ($isLoggedIn) {
        echo '<nav>Logged in Navbar</nav>';
    } elseif ($isHospitalLoggedIn) {
        echo '<nav>Hospital Navbar</nav>';
    } else {
        echo '<nav>Guest Navbar</nav>';
    }
}

// Check if user is logged in
if (!isset($_SESSION['currUserID'])) {
    header("Location: signin.php");
    exit();
}

// Fetch user data
$user_id = $_SESSION['currUserID'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$isLoggedIn = isset($_SESSION['currUserID']);
$isHospitalLoggedIn = isset($_SESSION['hospital_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Hemova</title>
    <link rel="stylesheet" href="./src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<<<<<<< HEAD
<body class="bg-red-400">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md fixed top-0 left-0 w-full z-50">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold">Hemova</a>
            <div>
            <a href="index.php" class="text-gray-700 hover:text-gray-900 mx-2">Home</a>
                <a href="profile.php" class="text-gray-700 hover:text-gray-900 mx-2">Profile</a>
                <a href="check_blood_availability.php" class="text-gray-700 hover:text-gray-900 mx-2">Check Blood Availability</a>
                <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</a>
=======
<body class="min-h-screen font-sans antialiased bg-gray-50">
    <?php renderNavbar($isLoggedIn, $isHospitalLoggedIn); ?>
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
>>>>>>> 0d00b6714cae60ea81c1630edbba1a932a529b5d
            </div>
        </div>
    </nav>

    <main class="container px-4 py-20 mx-auto md:py-24">
        <div class="max-w-3xl mx-auto">
            <!-- Profile Card -->
            <div class="overflow-hidden transition-all duration-300 transform bg-white shadow-lg rounded-2xl hover:shadow-xl">
                <!-- Header Section -->
                <div class="relative h-40 bg-gradient-to-r from-red-500 to-rose-600">
                    <div class="absolute -bottom-16 left-8">
                        <div class="w-32 h-32 overflow-hidden transition-all duration-300 transform border-4 border-white rounded-full shadow-lg hover:scale-105">
                            <img src="<?php echo !empty($user['profile_image']) ? $user['profile_image'] : 'profile.png'; ?>" 
                                 alt="Profile" 
                                 class="object-cover w-full h-full">
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="px-8 pt-20 pb-8">
                    <!-- User Info -->
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900 md:text-3xl">
                            <?php echo htmlspecialchars($user['name']); ?>
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 md:text-base"><?php echo htmlspecialchars($user['email']); ?></p>
                        <a href="edit_profile.php" 
                           class="inline-flex items-center px-5 py-2 mt-4 text-sm font-medium text-white transition-all duration-300 bg-red-600 rounded-full hover:bg-red-700 hover:shadow-md">
                            <i class="mr-2 fas fa-edit"></i> Edit Profile
                        </a>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 gap-4 mb-8 sm:grid-cols-3">
                        <div class="p-4 text-center transition-all duration-300 bg-gray-50 rounded-xl hover:bg-white hover:shadow-md">
                            <i class="mb-2 text-2xl text-red-500 fas fa-tint"></i>
                            <p class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($user['blood_group']); ?></p>
                            <p class="text-xs text-gray-500">Blood Group</p>
                        </div>
                        <div class="p-4 text-center transition-all duration-300 bg-gray-50 rounded-xl hover:bg-white hover:shadow-md">
                            <i class="mb-2 text-2xl text-red-500 fas fa-venus-mars"></i>
                            <p class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($user['gender']); ?></p>
                            <p class="text-xs text-gray-500">Gender</p>
                        </div>
                        <div class="p-4 text-center transition-all duration-300 bg-gray-50 rounded-xl hover:bg-white hover:shadow-md">
                            <i class="mb-2 text-2xl text-red-500 fas fa-calendar"></i>
                            <p class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($user['age']); ?></p>
                            <p class="text-xs text-gray-500">Age</p>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="flex items-center p-4 transition-all duration-300 bg-gray-50 rounded-xl hover:bg-white hover:shadow-md">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-red-100 rounded-full">
                                <i class="text-xl text-red-500 fas fa-phone"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs text-gray-500">Phone</p>
                                <p class="text-base font-medium text-gray-800"><?php echo htmlspecialchars($user['phoneno']); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center p-4 transition-all duration-300 bg-gray-50 rounded-xl hover:bg-white hover:shadow-md">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-red-100 rounded-full">
                                <i class="text-xl text-red-500 fas fa-notes-medical"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs text-gray-500">Medical Condition</p>
                                <p class="text-base font-medium text-gray-800"><?php echo htmlspecialchars($user['disease'] ?: 'None'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php $stmt->close(); $connection->close(); ?>
</body>
</html>