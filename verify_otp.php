<?php
session_start();
// Enable output buffering
ob_start();

// Debug session variables
error_log("Session variables in verify_otp.php: " . print_r($_SESSION, true));

// Redirect if email is not set in session
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

// Make sure to get the email from the session
$email = $_SESSION['reset_email'];
error_log("Email from session: " . $email);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Hemova</title>
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

        .otp-input {
            width: 100%;
            max-width: 360px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            gap: 8px; /* Add gap between inputs */
        }

        .otp-input input {
            width: 50px;
            height: 60px;
            border-radius: 10px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            display: block; /* Ensure inputs are displayed as blocks */
            padding: 10px 0; /* Add some padding */
            margin: 0; /* Reset margins */
            opacity: 1; /* Ensure visibility */
            background: rgba(255, 255, 255, 0.15) !important; /* Slightly brighter background */
            border: 1px solid rgba(255, 255, 255, 0.3) !important; /* More visible border */
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
        
        // Combine the OTP inputs
        $inputOtp = '';
        for ($i = 1; $i <= 6; $i++) {
            $inputOtp .= $_POST['otp'.$i] ?? '';
        }
        
        $email = $_SESSION['reset_email'];
        
        // Debug the input values
        error_log("Verifying OTP: Email=$email, InputOTP=$inputOtp");
        
        // Get the OTP record and manually verify
        $query = "SELECT * FROM password_resets WHERE email = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $db_otp = $row['otp'];
            $expires_at = $row['expires_at'];
            $current_time = date('Y-m-d H:i:s');
            
            error_log("DB OTP: $db_otp, Input OTP: $inputOtp, Expires: $expires_at, Current: $current_time");
            
            // Check if OTP matches (trimming whitespace just in case)
            if (trim($db_otp) === trim($inputOtp)) {
                // Check if OTP is expired by comparing timestamps
                if (strtotime($expires_at) > strtotime($current_time)) {
                    // OTP is valid and not expired
                    $_SESSION['otp_verified'] = true;
                    error_log("OTP verification successful, redirecting to reset_password.php");
                    header("Location: reset_password.php");
                    exit();
                } else {
                    // OTP has expired
                    error_log("OTP has expired. Expires: $expires_at, Current: $current_time");
                    echo '<div class="fixed px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded top-4 right-4">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline"> The OTP has expired. Please request a new one.</span>
                    </div>';
                }
            } else {
                // OTP doesn't match
                error_log("OTP doesn't match. DB: $db_otp, Input: $inputOtp");
                echo '<div class="fixed px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded top-4 right-4">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline"> Incorrect OTP. Please check and try again.</span>
                </div>';
            }
        } else {
            // No OTP record found
            error_log("No OTP record found for email: $email");
            echo '<div class="fixed px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded top-4 right-4">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"> No password reset request found. Please request a new OTP.</span>
            </div>';
        }
    }
    ?>
    
    <div class="content-container">
        <!-- Logo Section -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-white">Verify OTP</h2>
            <p class="text-white/80">Enter the verification code sent to your email</p>
        </div>

        <!-- OTP Verification Form -->
        <div class="p-8 shadow-2xl glass-effect rounded-2xl">
            <form action="" method="post" class="space-y-6">
                <!-- OTP Field -->
                <div>
                    <label class="block mb-4 text-sm font-medium text-center text-white" for="otp1">
                        Enter 6-digit OTP
                    </label>
                    <div class="otp-input">
                        <input type="text" name="otp1" id="otp1" maxlength="1" required 
                               class="focus:ring-2 focus:ring-red-400 focus:border-transparent" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value.length === 1) document.getElementById('otp2').focus()">
                        <input type="text" name="otp2" id="otp2" maxlength="1" required 
                               class="focus:ring-2 focus:ring-red-400 focus:border-transparent" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value.length === 1) document.getElementById('otp3').focus()">
                        <input type="text" name="otp3" id="otp3" maxlength="1" required 
                               class="focus:ring-2 focus:ring-red-400 focus:border-transparent" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value.length === 1) document.getElementById('otp4').focus()">
                        <input type="text" name="otp4" id="otp4" maxlength="1" required 
                               class="focus:ring-2 focus:ring-red-400 focus:border-transparent" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value.length === 1) document.getElementById('otp5').focus()">
                        <input type="text" name="otp5" id="otp5" maxlength="1" required 
                               class="focus:ring-2 focus:ring-red-400 focus:border-transparent" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value.length === 1) document.getElementById('otp6').focus()">
                        <input type="text" name="otp6" id="otp6" maxlength="1" required 
                               class="focus:ring-2 focus:ring-red-400 focus:border-transparent" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                    </div>
                </div>

                <p class="text-sm text-center text-white/80">
                    Didn't receive the code? <a href="forgot_password.php" class="text-red-200 hover:text-red-100">Resend OTP</a>
                </p>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-pink-600 text-white py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200">
                    Verify OTP
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
        // Script to allow only numbers in OTP fields
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.otp-input input');
            
            // Focus on first input on page load
            inputs[0].focus();
            
            // Handle backspace key
            inputs.forEach((input, index) => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && input.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });
            
            // Debug to verify page is fully loaded
            console.log("OTP page fully loaded");
        });
    </script>
</body>
</html>