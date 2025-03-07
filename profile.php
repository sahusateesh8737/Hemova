<?php
session_start();

// Check if user is logged in
// if (!isset($_SESSION['currUserID'])) {
//     header("Location: login.php");
//     exit();
// }

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
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">User Profile</h1>
        <div>
            <p class="mb-2"><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p class="mb-2"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p class="mb-2"><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phoneno']); ?></p>
            <p class="mb-2"><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
            <p class="mb-2"><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
            <p class="mb-2"><strong>Blood Group:</strong> <?php echo htmlspecialchars($user['blood_group']); ?></p>
            <p class="mb-2"><strong>Has Disease:</strong> <?php echo htmlspecialchars($user['disease']); ?></p>
        </div>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>

<?php
mysqli_close($connection);
?>