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
        .glass-effect {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6 bg-gradient-to-br from-red-500 to-pink-500">
    <div class="w-full max-w-md">
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
                    <a href="hospitalRegister.php" class="font-medium transition duration-200 hover:text-red-200">
                        Register your hospital
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Back to Home Button -->
    <a href="index.php" class="fixed p-3 transition duration-200 rounded-full top-6 left-6 bg-white/10 hover:bg-white/20">
        <i class="text-white fas fa-arrow-left"></i>
    </a>
</body>
</html>
