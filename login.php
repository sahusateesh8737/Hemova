<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
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
            $sql = "SELECT * FROM `signup` WHERE `email` = '$email'";
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
    <div>
        <h3>Sign In</h3>
        <div>
            <form action="" method="post">
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" required="">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="*****" required="">
                </div>
                <input type="submit" name="submit" value="Sign In">

                <!-- <a href="#"><small>Forgot your password?</small></a> -->
                <p><small>Do not have an account?</small></p>
                <a href="./signup.php"><small>Register</small></a>
            </form>
        </div>
    </div>
</body>

</html>