<?php
session_start();
include 'dbconnection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Hemova</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        .content-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 500px;
            padding: 2rem;
            margin: 2rem auto;
        }

        input, select {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        button[type="submit"] {
            background: linear-gradient(90deg, #ff3a82, #5233ff) !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 20px rgba(255, 58, 130, 0.3) !important;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 25px rgba(255, 58, 130, 0.4) !important;
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

        @keyframes float-1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(10%, 10%) scale(1.1); }
        }

        @keyframes float-2 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-10%, -5%) scale(1.15); }
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .content-container {
                padding: 1rem;
            }
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen">
    <div class="gradient-background">
        <div class="gradient-sphere sphere-1"></div>
        <div class="gradient-sphere sphere-2"></div>
        <div class="grid-overlay"></div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $phoneno = filter_input(INPUT_POST, 'phoneno', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
        $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $blood_group = filter_input(INPUT_POST, 'blood_group', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $disease = filter_input(INPUT_POST, 'disease', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // password check
        if ($password !== $confirm_password) {
            echo "<p class='text-red-600'>Passwords didn't match</p>";
        } else {
            if ($name && $email && $phoneno && $age && $gender && $blood_group && $disease && $password && $confirm_password) {
                // Hash the password before storing it in the database
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` (`name`, `email`, `phoneno`, `age`, `gender`, `blood_group`, `disease`, `password`) VALUES ('$name', '$email', '$phoneno', '$age', '$gender', '$blood_group', '$disease', '$hashed_password')";
            
                if (mysqli_query($connection, $sql)) {
                    // Store user information in session variables
                    $_SESSION['currUserID'] = mysqli_insert_id($connection);
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;

                    // Redirect to the homepage
                    header("Location: index.php");
                    exit(); // Ensure no further code is executed after the redirect
                } else {
                    echo "<p class='text-red-600'>Error: " . $sql . "<br>" . mysqli_error($connection) . "</p>";
                }
            } else {
                echo "<p class='text-red-600'>All fields are required.</p>";
            }
        }
    }   
    ?>

    <div class="content-container">
        <!-- Logo Section -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-white">Create Account</h2>
            <p class="text-white/80">Join us in saving lives through blood donation</p>
        </div>

        <!-- Sign Up Form -->
        <div class="p-8 shadow-2xl glass-effect rounded-2xl">
            <?php if(!isset($_SESSION['currUserID'])): ?>
            <form action="" method="POST" class="space-y-4">
                <!-- Name Field -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-white" for="name">
                        <i class="mr-2 fas fa-user"></i>Full Name
                    </label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-4 py-3 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 placeholder-white/50 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                        placeholder="Enter your name">
                </div>

                <!-- Email Field -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-white" for="email">
                        <i class="mr-2 fas fa-envelope"></i>Email Address
                    </label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-3 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 placeholder-white/50 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                        placeholder="Enter your email">
                </div>

                <!-- Phone Number Field -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-white" for="phoneno">
                        <i class="mr-2 fas fa-phone"></i>Phone Number
                    </label>
                    <input type="tel" name="phoneno" id="phoneno" required
                        class="w-full px-4 py-3 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 placeholder-white/50 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                        placeholder="Enter your phone number">
                </div>

                <!-- Age Field -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-white" for="age">
                        <i class="mr-2 fas fa-calendar"></i>Age
                    </label>
                    <input type="number" name="age" id="age" required
                        class="w-full px-4 py-3 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 placeholder-white/50 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                        placeholder="Enter your age">
                </div>

                <!-- Gender Field -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-white">
                        <i class="mr-2 fas fa-venus-mars"></i>Gender
                    </label>
                    <div class="flex space-x-4">
                        <label class="flex items-center text-white">
                            <input type="radio" name="gender" value="male" required
                                class="w-4 h-4 mr-2 text-red-600 border-white/20 focus:ring-red-400">
                            Male
                        </label>
                        <label class="flex items-center text-white">
                            <input type="radio" name="gender" value="female" required
                                class="w-4 h-4 mr-2 text-red-600 border-white/20 focus:ring-red-400">
                            Female
                        </label>
                        <label class="flex items-center text-white">
                            <input type="radio" name="gender" value="other" required
                                class="w-4 h-4 mr-2 text-red-600 border-white/20 focus:ring-red-400">
                            Other
                        </label>
                    </div>
                </div>

                <!-- Blood Group Field -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-white" for="blood_group">
                        <i class="mr-2 fas fa-tint"></i>Blood Group
                    </label>
                    <select name="blood_group" id="blood_group" required
                        class="w-full px-4 py-3 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 focus:ring-2 focus:ring-red-400 focus:border-transparent">
                        <option value="">Select your blood group</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>

                <!-- Disease Field -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-white">
                        <i class="mr-2 fas fa-heartbeat"></i>Current Health Status
                    </label>
                    <div class="flex space-x-4">
                        <label class="flex items-center text-white">
                            <input type="radio" name="disease" value="yes" required
                                class="w-4 h-4 mr-2 text-red-600 border-white/20 focus:ring-red-400">
                            Have Disease
                        </label>
                        <label class="flex items-center text-white">
                            <input type="radio" name="disease" value="no" required
                                class="w-4 h-4 mr-2 text-red-600 border-white/20 focus:ring-red-400">
                            Healthy
                        </label>
                    </div>
                </div>

                <!-- Password Fields -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-white" for="password">
                        <i class="mr-2 fas fa-lock"></i>Password
                    </label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-3 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 placeholder-white/50 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                        placeholder="Enter your password">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-white" for="confirm_password">
                        <i class="mr-2 fas fa-lock"></i>Confirm Password
                    </label>
                    <input type="password" name="confirm_password" id="confirm_password" required
                        class="w-full px-4 py-3 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 placeholder-white/50 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                        placeholder="Confirm your password">
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full py-3 mt-6 font-medium text-white transition duration-200 transform bg-gradient-to-r from-red-600 to-pink-600 rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                    Create Account
                </button>

                <!-- Sign In Link -->
                <div class="mt-6 text-center text-white">
                    <p class="text-white/80">Already have an account?</p>
                    <a href="signin.php" class="font-medium transition duration-200 hover:text-red-200">Sign In</a>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Back to Home Button -->
    <a href="index.php" class="fixed z-50 p-3 transition duration-200 rounded-full top-6 left-6 bg-white/10 hover:bg-white/20 backdrop-blur-sm">
        <i class="text-white fas fa-arrow-left"></i>
    </a>
</body>
</html>