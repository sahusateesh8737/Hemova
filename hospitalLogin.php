<?php
session_start();
include 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, name, password FROM hospitals WHERE email = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['hospital_id'] = $row['id'];
            $_SESSION['hospital_name'] = $row['name'];
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "No hospital found with this email!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Login - Hemova</title>
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
            max-width: 450px;
            padding: 2rem;
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

    <div class="content-container">
        <!-- Logo Section -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-white">Hospital Login</h2>
            <p class="text-white/80">Access your hospital dashboard to manage blood donations</p>
        </div>

        <!-- Login Form -->
        <div class="p-8 shadow-2xl glass-effect rounded-2xl">
            <?php if (isset($error_message)): ?>
                <div class="p-4 mb-4 text-red-100 rounded-lg bg-red-500/20">
                    <p class="flex items-center">
                        <i class="mr-2 fas fa-exclamation-circle"></i>
                        <?php echo $error_message; ?>
                    </p>
                </div>
            <?php endif; ?>

            <form action="hospitalLogin.php" method="POST" class="space-y-6">
                <!-- Email Field -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-white" for="email">
                        <i class="mr-2 fas fa-envelope"></i>Email Address
                    </label>
                    <div class="relative">
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-3 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 placeholder-white/50 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                            placeholder="Enter hospital email">
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
                            placeholder="Enter password">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full py-3 font-medium text-white transition duration-200 transform bg-gradient-to-r from-red-600 to-pink-600 rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                    Login to Dashboard
                </button>

                <!-- Register Link -->
                <div class="mt-6 text-center text-white">
                    <p class="text-white/80">Don't have a hospital account?</p>
                    <a href="hospitalRegister.html" class="font-medium transition duration-200 hover:text-red-200">
                        Register your hospital
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Back to Home Button -->
    <a href="index.php" class="fixed z-50 p-3 transition duration-200 rounded-full top-6 left-6 bg-white/10 hover:bg-white/20 backdrop-blur-sm">
        <i class="text-white fas fa-arrow-left"></i>
    </a>
</body>
</html>
