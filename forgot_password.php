<?php
session_start();
// Prevent any output buffering issues
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Hemova</title>
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
        include 'dbconnection.php';
        
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        
        if (!$email) {
            echo '<div class="fixed px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded top-4 right-4">
                <strong class="font-bold">Warning!</strong>
                <span class="block sm:inline"> Please enter a valid email address.</span>
            </div>';
        } else {
            // Check if email exists in database
            $sql = "SELECT id, name FROM users WHERE email = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                // Generate OTP (6-digit number)
                $otp = rand(100000, 999999);
                $otp_expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                
                // Store OTP in database
                $insert_sql = "INSERT INTO password_resets (email, otp, expires_at) VALUES (?, ?, ?) 
                              ON DUPLICATE KEY UPDATE otp = ?, expires_at = ?";
                $insert_stmt = $connection->prepare($insert_sql);
                $insert_stmt->bind_param("sssss", $email, $otp, $otp_expires, $otp, $otp_expires);
                
                if ($insert_stmt->execute()) {
                    // Send email with OTP
                    $to = $email;
                    $subject = "Hemova: Password Reset OTP";
                    $message = "Hello " . $user['name'] . ",\n\n";
                    $message .= "Your OTP for password reset is: " . $otp . "\n\n";
                    $message .= "This OTP will expire in 15 minutes.\n\n";
                    $message .= "If you did not request a password reset, please ignore this email.\n\n";
                    $message .= "Regards,\nHemova Team";
                    $headers = "From: noreply@hemova.com";
                    
                    // Store email in session for verification page
                    $_SESSION['reset_email'] = $email;
                    
                    // DEVELOPMENT MODE: Display OTP on screen for testing
                    echo '<div class="fixed px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded top-4 right-4">
                        <strong class="font-bold">Development Mode:</strong>
                        <span class="block sm:inline"> Your OTP is: ' . $otp . ' (This will only show in development)</span>
                    </div>';
                    
                    // Attempt to send email, but proceed even if it fails in development
                    mail($to, $subject, $message, $headers);
                    
                    // Debug the session variables before redirect
                    error_log("Session reset_email set to: " . $_SESSION['reset_email']);
                    
                    // Flush output buffer and redirect with exit
                    ob_end_flush();
                    
                    // Use JavaScript redirect for better reliability
                    echo "<script>setTimeout(function() { window.location.href = 'verify_otp.php'; }, 2000);</script>";
                    exit();
                } else {
                    echo '<div class="fixed px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded top-4 right-4">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline"> Failed to generate OTP. Please try again.</span>
                    </div>';
                }
            } else {
                echo '<div class="fixed px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded top-4 right-4">
                    <strong class="font-bold">Warning!</strong>
                    <span class="block sm:inline"> No account found with that email address.</span>
                </div>';
            }
        }
    }
    ?>
    
    <div class="content-container">
        <!-- Logo Section -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-white">Forgot Password</h2>
            <p class="text-white/80">Enter your email to receive a password reset OTP</p>
        </div>

        <!-- Forgot Password Form -->
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

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-pink-600 text-white py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200">
                    Send OTP
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
</body>
</html>