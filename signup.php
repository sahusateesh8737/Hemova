<?php
session_start();
include 'dbconnection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<!-- php code -->
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
    if ($password != $confirm_password) {
        echo "<p class='text-red-600'>Passwords didn't match</p>";
    } else {
        if ($name && $email && $phoneno && $age && $gender && $blood_group && $disease && $password && $confirm_password) {
            // Hash the password before storing it in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`id`, `name`, `email`, `phoneno`, `age`, `gender`, `blood_group`, `disease`, `password`) VALUES (NULL, '$name', '$email', '$phoneno', '$age', '$gender', '$blood_group', '$disease', '$hashed_password')";

            if (mysqli_query($connection, $sql)) {
                // Store user information in session variables
                $_SESSION['currUserID'] = mysqli_insert_id($connection);
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;

                // Redirect to home page
                header("Location: index.php");
                exit();
            } else {
                echo "<p class='text-red-600'>Error: " . $sql . "<br>" . mysqli_error($connection) . "</p>";
            }
        } else {
            echo "<p class='text-red-600'>All fields are required.</p>";
        }
    }
}
?>

<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-red-600">Sign Up</h1>
    </div>
    <form action="" method="POST" class="bg-red-100 p-6 rounded-lg">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700" for="name">Name</label>
            <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                   type="text" name="name" id="name" placeholder="Enter your name" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
            <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                   type="email" name="email" id="email" placeholder="Enter your email" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700" for="phoneno">Phone Number</label>
            <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                   type="tel" name="phoneno" id="phoneno" placeholder="Enter your phone number" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700" for="age">Age</label>
            <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                   type="number" name="age" id="age" placeholder="Enter your age" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Gender</label>
            <div class="mt-2 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="gender" value="male" required class="form-radio text-red-600">
                    <span class="ml-2">Male</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="gender" value="female" required class="form-radio text-red-600">
                    <span class="ml-2">Female</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="gender" value="other" required class="form-radio text-red-600">
                    <span class="ml-2">Other</span>
                </label>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700" for="blood_group">Blood Group</label>
            <select class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                    name="blood_group" id="blood_group" required>
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
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Are you currently suffering from any disease?</label>
            <div class="mt-2 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="disease" value="yes" required class="form-radio text-red-600">
                    <span class="ml-2">Yes</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="disease" value="no" required class="form-radio text-red-600">
                    <span class="ml-2">No</span>
                </label>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
            <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                   type="password" name="password" id="password" placeholder="Enter your password" required>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700" for="confirm_password">Confirm Password</label>
            <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                   type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required>
        </div>
        
        <input class="w-full bg-red-600 text-white p-2 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 cursor-pointer" 
               type="submit" value="Sign Up">
    </form>
    <div class="text-center mt-4">
        <p class="text-sm text-gray-600">Already have an account?</p>
        <a href="./signin.php" class="text-sm text-red-600 hover:text-red-800 font-medium">Sign In</a>
    </div>
</div>

</body>
</html>