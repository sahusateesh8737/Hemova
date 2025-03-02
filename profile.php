<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['currUserID'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$server = "localhost";
$username = "root";
$pass = "";
$database = "hemova";
$connection = mysqli_connect($server, $username, $pass, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user data
$user_id = $_SESSION['currUserID'];
$sql = "SELECT * FROM signup WHERE id = '$user_id'";
$result = mysqli_query($connection, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    <div>
        <h1>User Profile</h1>
        <div>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phoneno']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
            <p><strong>Blood Group:</strong> <?php echo htmlspecialchars($user['blood_group']); ?></p>
            <p><strong>Has Disease:</strong> <?php echo htmlspecialchars($user['disease']); ?></p>
        </div>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>

<?php
mysqli_close($connection);
?>