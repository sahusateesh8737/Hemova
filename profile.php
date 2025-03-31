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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background-color: #050505;
            color: white;
            position: relative;
            overflow-x: hidden;
        }

        .gradient-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
            opacity: 0.8;
        }

        .gradient-sphere {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
        }

        .sphere-1 {
            width: 40vw;
            height: 40vw;
            background: linear-gradient(40deg, rgba(255, 0, 128, 0.8), rgba(255, 102, 0, 0.4));
            top: -10%;
            left: -10%;
            animation: float-1 15s ease-in-out infinite alternate;
        }

        .sphere-2 {
            width: 45vw;
            height: 45vw;
            background: linear-gradient(240deg, rgba(72, 0, 255, 0.8), rgba(0, 183, 255, 0.4));
            bottom: -20%;
            right: -10%;
            animation: float-2 18s ease-in-out infinite alternate;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .glass-effect:hover {
            background: rgba(255, 255, 255, 0.15) !important;
            transform: translateY(-2px);
        }

        @keyframes float-1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(10%, 10%) scale(1.1); }
        }

        @keyframes float-2 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-10%, -5%) scale(1.15); }
        }

        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            z-index: 2;
        }

        /* Text visibility improvements */
        .text-white {
            color: rgba(255, 255, 255, 0.95) !important;
        }

        .text-white\/60 {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        /* Profile header section */
        .profile-header {
            background: linear-gradient(to right, rgba(239, 68, 68, 0.5), rgba(225, 29, 72, 0.5));
            backdrop-filter: blur(10px);
        }

        /* Icon colors */
        .text-red-500 {
            color: rgb(239, 68, 68) !important;
        }

        /* Text shadow for better readability */
        h2, .text-lg {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Profile image border */
        .profile-image-border {
            border: 4px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="gradient-background">
        <div class="gradient-sphere sphere-1"></div>
        <div class="gradient-sphere sphere-2"></div>
        <div class="grid-overlay"></div>
    </div>

    <!-- Navigation Bar -->
    <nav class="fixed top-0 left-0 z-50 w-full bg-transparent border-b backdrop-blur-sm border-white/10">
        <div class="container flex items-center justify-between p-4 mx-auto">
            <a href="index.php" class="text-2xl font-bold text-white transition-colors hover:text-red-500">Hemova</a>
            <div class="flex items-center space-x-4">
                <a href="index.php" class="transition text-white/90 hover:text-red-500">Home</a>
                <a href="profile.php" class="transition text-white/90 hover:text-red-500">Profile</a>
                <a href="check_blood_availability.php" class="transition text-white/90 hover:text-red-500">Check Blood</a>
                <a href="logout.php" class="px-4 py-2 text-white transition rounded bg-red-600/80 hover:bg-red-700">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container relative z-10 px-4 py-20 mx-auto md:py-24">
        <div class="max-w-3xl mx-auto">
            <!-- Profile Card -->
            <div class="overflow-hidden transition-all duration-300 transform glass-effect rounded-2xl hover:shadow-xl">
                <!-- Header Section -->
                <div class="relative h-40 profile-header">
                    <div class="absolute -bottom-16 left-8">
                        <div class="w-32 h-32 overflow-hidden transition-all duration-300 transform rounded-full shadow-lg profile-image-border hover:scale-105">
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
                        <h2 class="text-2xl font-bold tracking-tight text-white md:text-3xl">
                            <?php echo htmlspecialchars($user['name']); ?>
                        </h2>
                        <p class="mt-1 text-sm text-white/60 md:text-base"><?php echo htmlspecialchars($user['email']); ?></p>
                        <a href="edit_profile.php" 
                           class="inline-flex items-center px-5 py-2 mt-4 text-sm font-medium text-white transition-all duration-300 rounded-full bg-gradient-to-r from-red-600/80 to-rose-600/80 hover:shadow-lg hover:-translate-y-0.5">
                            <i class="mr-2 fas fa-edit"></i> Edit Profile
                        </a>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 gap-4 mb-8 sm:grid-cols-3">
                        <div class="p-4 text-center transition-all duration-300 rounded-xl glass-effect hover:shadow-lg">
                            <i class="mb-2 text-2xl text-red-500 fas fa-tint"></i>
                            <p class="text-lg font-semibold text-white"><?php echo htmlspecialchars($user['blood_group']); ?></p>
                            <p class="text-xs text-white/60">Blood Group</p>
                        </div>
                        <div class="p-4 text-center transition-all duration-300 rounded-xl glass-effect hover:shadow-lg">
                            <i class="mb-2 text-2xl text-red-500 fas fa-venus-mars"></i>
                            <p class="text-lg font-semibold text-white"><?php echo htmlspecialchars($user['gender']); ?></p>
                            <p class="text-xs text-white/60">Gender</p>
                        </div>
                        <div class="p-4 text-center transition-all duration-300 rounded-xl glass-effect hover:shadow-lg">
                            <i class="mb-2 text-2xl text-red-500 fas fa-calendar"></i>
                            <p class="text-lg font-semibold text-white"><?php echo htmlspecialchars($user['age']); ?></p>
                            <p class="text-xs text-white/60">Age</p>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="flex items-center p-4 transition-all duration-300 rounded-xl glass-effect hover:shadow-lg">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-full bg-red-500/20">
                                <i class="text-xl text-red-500 fas fa-phone"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs text-white/60">Phone</p>
                                <p class="text-base font-medium text-white"><?php echo htmlspecialchars($user['phoneno']); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center p-4 transition-all duration-300 rounded-xl glass-effect hover:shadow-lg">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-full bg-red-500/20">
                                <i class="text-xl text-red-500 fas fa-notes-medical"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs text-white/60">Medical Condition</p>
                                <p class="text-base font-medium text-white"><?php echo htmlspecialchars($user['disease'] ?: 'None'); ?></p>
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