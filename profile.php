<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['currUserID'])) {
    header("Location: signin.php");
    exit();
}

// Database connection
include 'dbconnection.php';

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
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <a href="home.php" class="text-2xl font-bold">Hemova</a>
            <div>
                <a href="profile.php" class="text-gray-700 hover:text-gray-900 mx-2">Profile</a>
                <a href="settings.php" class="text-gray-700 hover:text-gray-900 mx-2">Settings</a>
                <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4 text-center">User Profile</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <p class="text-lg font-semibold"><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            </div>
            <div class="mb-4">
                <p class="text-lg font-semibold"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            <div class="mb-4">
                <p class="text-lg font-semibold"><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phoneno']); ?></p>
            </div>
            <div class="mb-4">
                <p class="text-lg font-semibold"><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
            </div>
            <div class="mb-4">
                <p class="text-lg font-semibold"><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
            </div>
            <div class="mb-4">
                <p class="text-lg font-semibold"><strong>Blood Group:</strong> <?php echo htmlspecialchars($user['blood_group']); ?></p>
            </div>
            <div class="mb-4">
                <p class="text-lg font-semibold"><strong>Has Disease:</strong> <?php echo htmlspecialchars($user['disease']); ?></p>
            </div>
        </div>
        <div class="text-center mt-6">
            <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</a>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($connection);
?>