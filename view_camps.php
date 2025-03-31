<?php
session_start();
include 'dbconnection.php';

// Check if user is logged in
if (!isset($_SESSION['currUserID'])) {
    header("Location: signin.php");
    exit();
}

// Fetch future camps from the database
$sql = "SELECT camps.*, hospitals.name AS hospital_name 
        FROM camps 
        JOIN hospitals ON camps.hospital_id = hospitals.id 
        WHERE camps.date >= CURDATE() 
        ORDER BY camps.date ASC, camps.time ASC";
$result = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Blood Donation Camps - Hemova</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="font-sans bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="fixed top-0 z-10 w-full bg-white shadow-md">
        <div class="container flex items-center justify-between p-4 mx-auto">
            <a href="index.php" class="text-2xl font-bold text-red-600">Hemova</a>
            <div class="space-x-4">
                <a href="profile.php" class="text-gray-700 transition duration-300 hover:text-red-600">Profile</a>
                <a href="check_blood_availability.php" class="text-gray-700 transition duration-300 hover:text-red-600">Check Blood Availability</a>
                <a href="view_camps.php" class="text-gray-700 transition duration-300 hover:text-red-600">View Camps</a>
                <a href="logout.php" class="px-4 py-2 text-white transition duration-300 bg-red-600 rounded hover:bg-red-700">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container p-4 pt-20 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">Upcoming Blood Donation Camps</h1>
        
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-sm font-medium tracking-wider text-left text-gray-700 uppercase bg-gray-100 border-b border-gray-200">Camp Name</th>
                            <th class="px-4 py-3 text-sm font-medium tracking-wider text-left text-gray-700 uppercase bg-gray-100 border-b border-gray-200">Location</th>
                            <th class="px-4 py-3 text-sm font-medium tracking-wider text-left text-gray-700 uppercase bg-gray-100 border-b border-gray-200">Date</th>
                            <th class="px-4 py-3 text-sm font-medium tracking-wider text-left text-gray-700 uppercase bg-gray-100 border-b border-gray-200">Time</th>
                            <th class="px-4 py-3 text-sm font-medium tracking-wider text-left text-gray-700 uppercase bg-gray-100 border-b border-gray-200">Hospital</th>
                            <th class="px-4 py-3 text-sm font-medium tracking-wider text-left text-gray-700 uppercase bg-gray-100 border-b border-gray-200">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $date = date('d F Y', strtotime($row['date']));
                                $time = date('h:i A', strtotime($row['time']));
                                
                                echo "<tr class='hover:bg-gray-50'>";
                                echo "<td class='px-4 py-3 border-b border-gray-200'>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td class='px-4 py-3 border-b border-gray-200'>" . htmlspecialchars($row['location']) . "</td>";
                                echo "<td class='px-4 py-3 border-b border-gray-200'>" . $date . "</td>";
                                echo "<td class='px-4 py-3 border-b border-gray-200'>" . $time . "</td>";
                                echo "<td class='px-4 py-3 border-b border-gray-200'>" . htmlspecialchars($row['hospital_name']) . "</td>";
                                echo "<td class='px-4 py-3 border-b border-gray-200'>" . htmlspecialchars($row['description']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='px-4 py-3 text-center text-gray-600 border-b border-gray-200'>No upcoming camps available</td></tr>";
                        }
                        mysqli_free_result($result);
                        mysqli_close($connection);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>