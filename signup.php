<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <link rel="stylesheet" href="./src/output.css">

    <title>Signup</title>
    <style>
        body {
            background-image: url('blood.jpg');
            background-size: cover;
            background-attachment: fixed;
            /* background-position: center; */
            opacity: 0.9;
        }
    </style>
</head>
<body class="">
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
        echo "password didn't match";
    } else {
        if ($name && $email && $phoneno && $age && $gender && $blood_group && $disease && $password && $confirm_password) {
            $server = "localhost";
            $username = "root";
            $pass = "";
            $database = "hemova";
            $connection = mysqli_connect($server, $username, $pass, $database);

            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            } else {
                // Hash the password before storing it in the database
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `signup` (`id`, `name`, `email`, `phoneno`, `age`, `gender`, `blood_group`, `disease`, `password`) VALUES (NULL, '$name', '$email', '$phoneno', '$age', '$gender', '$blood_group', '$disease', '$hashed_password')";

                if (mysqli_query($connection, $sql)) {
                    // Store user information in session variables
                    $_SESSION['currUserID'] = mysqli_insert_id($connection);
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;

                    echo "Account created successfully";
                    // Redirect to home page
                    header("Location: login.php");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($connection);
                }

                mysqli_close($connection);
            }
        } else {
            echo "All fields are required.";
        }
    }
}
?>

<div class="bg-white rounded-lg p-8  h-7 max-w-md  mb-10 mt-5 ml-130 mx-auto flex flex-col items-center shadow-lg ">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Registration</h1>
    </div>
    <form action="" method="POST" class="w-full ">  
        <div>
            <label for="name" class="block text-gray-700 font-bold">Name</label>
            <input type="text" name="name" class="border border-gray-300 rounded-lg w-full p-2" required>
        </div>
        <div >
            <label for="email" class="block text-gray-700 font-bold">Email</label>
            <input type="email" name="email" class="border border-gray-300 rounded-lg w-full p-2" required>
        </div>
        <div >
            <label for="phoneno" class="block text-gray-700 font-bold">PhoneNo</label>
            <input type="tel" name="phoneno" class="border border-gray-300 rounded-lg w-full p-2" required>
        </div>
        <div >
            <label for="age" class="block text-gray-700 font-bold">Age</label>
            <input type="number" name="age" class="border border-gray-300 rounded-lg w-full p-2" required>
        </div>
        <div class="mb-2">
            <label for="gender" class="block text-gray-700 font-bold">Gender</label>
            <div class="flex items-center space-x-8">
                <label class="flex items-center">
                    <input type="radio" name="gender" value="male" class="mr-2" required> Male
                </label>
                <label class="flex items-center">
                    <input type="radio" name="gender" value="female" class="mr-2" required> Female
                </label>
                <label class="flex items-center">
                    <input type="radio" name="gender" value="other" class="mr-2" required> Other
                </label>
            </div>
        </div>
        <div class="mb-2">
            <label for="blood_group" class="block text-gray-700 font-bold">Blood Group</label>
            <select name="blood_group" class="border border-gray-300 rounded-lg w-full p-2" required>
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
        <div class="mb-2">
            <label for="disease" class="block text-gray-700 font-bold">Are you currently suffering from any disease?</label>
            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="radio" name="disease" value="yes" class="mr-2" required> Yes
                </label>
                <label class="flex items-center">
                    <input type="radio" name="disease" value="no" class="mr-2" required> No
                </label>
            </div>
        </div>
        <div >
            <label for="password" class="block text-gray-700 font-bold">Password</label>
            <input type="password" name="password" class="border border-gray-300 rounded-lg w-full p-2" required>
        </div>
        <div class="mb-2">
            <label for="confirm_password" class="block text-gray-700 font-bold">Confirm Password</label>
            <input type="password" name="confirm_password" class="border border-gray-300 rounded-lg w-full p-2" required>
        </div>
        <div >
            <input type="submit" value="Signup" class="bg-red-500 text-white rounded-lg w-full p-2 hover:bg-red-600">
        </div>
    </form>
    <a href="./login.php" class="text-blue-500 hover:underline">Already registered?</a>
</div>


</body>
</html>