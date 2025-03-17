<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./src/output.css">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
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

                    echo '<div>
                    <strong>Success!</strong> Correct credentials.
                  </div>';
                    header("Location: profile.php");
                    exit();
                } else {
                    echo '<div>
                    <strong>Warning!</strong> Incorrect password.
                  </div>';
                }
            } else {
                echo '<div>
                <strong>Warning!</strong> No account found with that email.
              </div>';
            }

            mysqli_close($conn);
        }
    }
    ?>
    
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class="text-center mb-6">
            <h3 class="text-2xl font-bold text-red-600">Sign In</h3>
        </div>
        
        <div class="bg-red-100 p-6 rounded-lg">
            <form action="" method="post">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                    <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                           type="email" name="email" id="email" placeholder="Enter your email" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
                    <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                           type="password" name="password" id="password" placeholder="Enter your password" required>
                </div>
                
                <input class="w-full bg-red-600 text-white p-2 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 cursor-pointer" 
                       type="submit" name="submit" value="Sign In">

                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">Do not have an account?</p>
                    <a href="./signup.php" class="text-sm text-red-600 hover:text-red-800 font-medium">Register</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>