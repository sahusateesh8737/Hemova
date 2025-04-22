<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Hemova</title>
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

        .password-strength {
            width: 100%;
            height: 5px;
            margin-top: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }

        .strength-meter {
            height: 100%;
            width: 0%;
            transition: all 0.3s;
        }

        .weak { width: 25%; background: #ff4d4d; }
        .medium { width: 50%; background: #ffcc00; }
        .strong { width: 75%; background: #2ecc71; }
        .very-strong { width: 100%; background: #27ae60; }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen">
    <div class="gradient-background">
        <div class="gradient-sphere sphere-1"></div>
        <div class="gradient-sphere sphere-2"></div>
        <div class="grid-overlay"></div>
    </div>

    <?php
    // Redirect if email is not set in session or OTP not verified
    if (!isset($_SESSION['reset_email']) || !isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
        header("Location: forgot_password.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include 'dbconnection.php';
        
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $email = $_SESSION['reset_email'];
        
        // Validate password
        if (strlen($password) < 8) {
            echo '<div class="fixed px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded top-4 right-4">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"> Password must be at least 8 characters long.</span>
            </div>';
        } elseif ($password !== $confirm_password) {
            echo '<div class="fixed px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded top-4 right-4">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"> Passwords do not match.</span>
            </div>';
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Update the password
            $sql = "UPDATE users SET password = ? WHERE email = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ss", $hashed_password, $email);
            
            if ($stmt->execute()) {
                // Delete the reset record
                $delete_sql = "DELETE FROM password_resets WHERE email = ?";
                $delete_stmt = $connection->prepare($delete_sql);
                $delete_stmt->bind_param("s", $email);
                $delete_stmt->execute();
                
                // Clear the session variables
                unset($_SESSION['reset_email']);
                unset($_SESSION['otp_verified']);
                
                // Set success message and redirect to login
                $_SESSION['password_reset_success'] = true;
                
                // Log the redirection for debugging
                error_log("Password reset successful, redirecting to signin.php");
                
                // Ensure output buffering is clean
                ob_clean();
                
                // JavaScript redirect for better reliability
                echo '<script>window.location.href = "signin.php";</script>';
                
                // Also do PHP redirect as fallback
                header("Location: signin.php");
                exit();
            } else {
                echo '<div class="fixed px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded top-4 right-4">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline"> Failed to update password. Please try again.</span>
                </div>';
            }
        }
    }
    ?>
    
    <div class="content-container">
        <!-- Logo Section -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-white">Reset Password</h2>
            <p class="text-white/80">Enter your new password</p>
        </div>

        <!-- Reset Password Form -->
        <div class="p-8 shadow-2xl glass-effect rounded-2xl">
            <form action="" method="post" class="space-y-6">
                <!-- New Password Field -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-white" for="password">
                        <i class="mr-2 fas fa-lock"></i>New Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 placeholder-white/50 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                            placeholder="Enter your new password" oninput="checkPasswordStrength(this.value)">
                        <div class="password-strength">
                            <div id="strength-meter" class="strength-meter"></div>
                        </div>
                        <p id="password-feedback" class="mt-1 text-xs text-white/60"></p>
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-white" for="confirm_password">
                        <i class="mr-2 fas fa-lock"></i>Confirm Password
                    </label>
                    <div class="relative">
                        <input type="password" name="confirm_password" id="confirm_password" required
                            class="w-full px-4 py-3 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 placeholder-white/50 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                            placeholder="Confirm your new password" oninput="checkPasswordMatch()">
                        <p id="match-feedback" class="mt-1 text-xs text-white/60"></p>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-pink-600 text-white py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200">
                    Reset Password
                </button>

                <!-- Back to Login Link -->
                <p class="text-sm text-center text-white">
                    Remember your password? 
                    <a href="signin.php" class="font-medium text-red-200 transition duration-200 hover:text-red-100">Sign in</a>
                </p>
            </form>
        </div>
    </div>

    <!-- Back to Home Button -->
    <a href="index.php" class="fixed z-50 p-3 transition duration-200 rounded-full top-6 left-6 bg-white/10 hover:bg-white/20 backdrop-blur-sm">
        <i class="text-white fas fa-arrow-left"></i>
    </a>

    <script>
        function checkPasswordStrength(password) {
            const meter = document.getElementById('strength-meter');
            const feedback = document.getElementById('password-feedback');
            
            // Remove all classes
            meter.className = 'strength-meter';
            
            if (password.length === 0) {
                meter.style.width = '0%';
                feedback.textContent = '';
                return;
            }
            
            // Check password strength
            let strength = 0;
            const patterns = [
                /[a-z]+/, // lowercase
                /[A-Z]+/, // uppercase
                /[0-9]+/, // numbers
                /[^A-Za-z0-9]+/ // special characters
            ];
            
            patterns.forEach(pattern => {
                if (pattern.test(password)) {
                    strength++;
                }
            });
            
            if (password.length < 8) {
                meter.classList.add('weak');
                feedback.textContent = 'Password is too short (minimum 8 characters)';
                return;
            }
            
            // Set meter class based on strength
            switch (strength) {
                case 1:
                    meter.classList.add('weak');
                    feedback.textContent = 'Password is weak';
                    break;
                case 2:
                    meter.classList.add('medium');
                    feedback.textContent = 'Password is medium strength';
                    break;
                case 3:
                    meter.classList.add('strong');
                    feedback.textContent = 'Password is strong';
                    break;
                case 4:
                    meter.classList.add('very-strong');
                    feedback.textContent = 'Password is very strong';
                    break;
            }
        }
        
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const feedback = document.getElementById('match-feedback');
            
            if (confirmPassword.length === 0) {
                feedback.textContent = '';
                return;
            }
            
            if (password === confirmPassword) {
                feedback.textContent = 'Passwords match';
                feedback.style.color = '#2ecc71';
            } else {
                feedback.textContent = 'Passwords do not match';
                feedback.style.color = '#ff4d4d';
            }
        }
    </script>
</body>
</html>