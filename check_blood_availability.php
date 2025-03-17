<?php
session_start();
include 'dbconnection.php';

// Fetch data from the database
$sql = "SELECT name, blood_group, disease, phoneno FROM users";
$result = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Blood Availability</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Hemova</a>
            <div>
                <a href="profile.php" class="text-gray-700 hover:text-gray-900 mx-2">Profile</a>
                <a href="settings.php" class="text-gray-700 hover:text-gray-900 mx-2">Settings</a>
                <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4 text-center">Check Blood Availability</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Name</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Blood Group</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Disease</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Phone Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['blood_group']) . "</td>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['disease']) . "</td>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['phoneno']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='py-2 px-4 border-b border-gray-200 text-center'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($connection);
?>