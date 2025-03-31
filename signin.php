<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hemova</title>
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
            overflow: hidden;
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
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .content-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 450px;
            padding: 2rem;
        }

        input {
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
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $servername = "localhost";
        $username = "root";
        $pass = "";
        $db = "hemova";

        // create a connection
        $conn = mysqli_connect($servername, $username, $pass, $db);
        // die if connection not successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row['password'])) {
                    // Store user information in session variables
                    $_SESSION['currUserID'] = $row['id'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['email'] = $row['email'];

                    // Redirect to homepage immediately
                    header('Location: index.php');
                    exit();
                } else {
                    echo '<div class="fixed px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded top-4 right-4">
                        <strong class="font-bold">Warning!</strong>
                        <span class="block sm:inline"> Incorrect password.</span>
                    </div>';
                }
            } else {
                echo '<div class="fixed px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded top-4 right-4">
                    <strong class="font-bold">Warning!</strong>
                    <span class="block sm:inline"> No account found with that email.</span>
                </div>';
            }

            mysqli_close($conn);
        }
    }
    ?>
    
    <div class="content-container">
        <!-- Logo Section -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-white">Welcome Back</h2>
            <p class="text-white/80">Sign in to continue your journey of saving lives</p>
        </div>

        <!-- Sign In Form -->
        <div class="p-8 shadow-2xl glass-effect rounded-2xl">
            <form action="" method="post" class="space-y-6">
                <!-- Email Field -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-white" for="email">
                        <i class="mr-2 fas fa-envelope"></i>Email Address
                    </label>
                    <div class="relative">
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-3 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 placeholder-white/50 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                            placeholder="Enter your email">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-white" for="password">
                        <i class="mr-2 fas fa-lock"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 placeholder-white/50 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                            placeholder="Enter your password">
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" class="w-4 h-4 text-red-500 rounded border-white/20 bg-white/10 focus:ring-red-400">
                        <label for="remember" class="ml-2 text-sm text-white">Remember me</label>
                    </div>
                    <a href="#" class="text-sm text-white transition duration-200 hover:text-red-200">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-pink-600 text-white py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200">
                    Sign In
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/20"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 text-white bg-transparent">Or continue with</span>
                    </div>
                </div>

                <!-- Social Login Buttons -->
                <div class="grid grid-cols-3 gap-4">
                    <button type="button" class="flex items-center justify-center py-2.5 border border-white/20 rounded-lg hover:bg-white/10 transition duration-200">
                        <i class="text-white fab fa-google"></i>
                    </button>
                    <button type="button" class="flex items-center justify-center py-2.5 border border-white/20 rounded-lg hover:bg-white/10 transition duration-200">
                        <i class="text-white fab fa-facebook-f"></i>
                    </button>
                    <button type="button" class="flex items-center justify-center py-2.5 border border-white/20 rounded-lg hover:bg-white/10 transition duration-200">
                        <i class="text-white fab fa-apple"></i>
                    </button>
                </div>

                <!-- Sign Up Link -->
                <p class="text-sm text-center text-white">
                    Don't have an account? 
                    <a href="signup.php" class="font-medium text-red-200 transition duration-200 hover:text-red-100">Sign up now</a>
                </p>
            </form>
        </div>
    </div>

    <!-- Back to Home Button -->
    <a href="index.php" class="fixed z-50 p-3 transition duration-200 rounded-full top-6 left-6 bg-white/10 hover:bg-white/20 backdrop-blur-sm">
        <i class="text-white fas fa-arrow-left"></i>
    </a>
</body>
</html>