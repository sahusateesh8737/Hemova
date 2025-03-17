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
    <title>Hospital Login</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-red-600">Hospital Login</h1>
        </div>
        <div class="bg-red-100 p-6 rounded-lg">
            <?php if (isset($error_message)): ?>
                <div class="text-red-600 mb-4"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form action="hospitalLogin.php" method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                    <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                           type="email" name="email" id="email" placeholder="Enter email" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
                    <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                           type="password" name="password" id="password" placeholder="Enter password" required>
                </div>
                
                <input class="w-full bg-red-600 text-white p-2 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 cursor-pointer" 
                       type="submit" value="Login">
            </form>
        </div>
    </div>
</body>
</html>
