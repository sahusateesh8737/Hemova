<?php
session_start();
include 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Add your admin credentials
    if ($username === "admin" && password_verify($password, '$2y$12$.gQ/5YIBeRQ4sXks/an6Y.8Zhz9ITkvWiR5xh2kk7VqgHbJAxIwVC')) {
        $_SESSION['admin_id'] = 1;
        $_SESSION['admin_username'] = $username;
        header("Location: admin.php");
        exit();
    } else {
        $error_message = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Hemova</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Base Styles */
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

        .glass-effect {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="gradient-background">
        <div class="gradient-sphere sphere-1"></div>
        <div class="gradient-sphere sphere-2"></div>
        <div class="grid-overlay"></div>
    </div>

    <div class="w-full max-w-md p-8 glass-effect rounded-2xl">
        <h2 class="mb-8 text-2xl font-bold text-center text-white">Admin Login</h2>
        
        <?php if (isset($error_message)): ?>
            <div class="p-4 mb-4 text-red-100 rounded-lg bg-red-500/20">
                <p class="flex items-center">
                    <i class="mr-2 fas fa-exclamation-circle"></i>
                    <?php echo $error_message; ?>
                </p>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block mb-2 text-sm font-medium text-white">
                    <i class="mr-2 fas fa-user"></i>Username
                </label>
                <input type="text" name="username" required 
                    class="w-full px-4 py-2 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                    placeholder="Enter admin username">
            </div>
            
            <div>
                <label class="block mb-2 text-sm font-medium text-white">
                    <i class="mr-2 fas fa-lock"></i>Password
                </label>
                <input type="password" name="password" required 
                    class="w-full px-4 py-2 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                    placeholder="Enter admin password">
            </div>

            <button type="submit" 
                class="w-full py-3 font-medium text-white transition duration-200 transform bg-gradient-to-r from-red-600 to-pink-600 rounded-lg hover:shadow-xl hover:-translate-y-0.5">
                Login to Dashboard
            </button>
        </form>
    </div>
</body>
</html>