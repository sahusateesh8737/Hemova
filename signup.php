<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
                $sql = "INSERT INTO `signup` (`id`, `name`, `email`, `phoneno`, `age`, `gender`, `blood_group`, `disease`, `password`) VALUES (NULL, '$name', '$email', '$phoneno', '$age', '$gender', '$blood_group', '$disease', '$password')";

                if (mysqli_query($connection, $sql)) {
                    echo "Account created successfully";
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

<div>
    <form action="" method="POST">
        <label for="name">Name</label>
        <input type="text" name="name" required>
        <br>
        <label for="email">Email</label>
        <input type="email" name="email" required>
        <br>
        <label for="phoneno">PhoneNo</label>
        <input type="tel" name="phoneno" required>
        <br>
        <label for="age">Age</label>
        <input type="number" name="age" required>
        <br>
        <label for="gender">Gender</label>
        <input type="radio" name="gender" value="male" required> Male
        <input type="radio" name="gender" value="female" required> Female
        <input type="radio" name="gender" value="other" required> Other
        <br>
        <label for="blood_group">Blood Group</label>
        <select name="blood_group" required>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
        </select>
        <br>
        <label for="disease">Are you currently suffering from any disease?</label>
        <input type="radio" name="disease" value="yes" required> Yes
        <input type="radio" name="disease" value="no" required> No
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" required>
        <br>
        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" required>
        <br>
        <input type="submit" value="signup">
    </form>
</div>
</body>
</html>