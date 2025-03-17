<?php
session_start();
include 'dbconnection.php';

// Fetch camps from the database
$sql = "SELECT camps.*, hospitals.name AS hospital_name FROM camps JOIN hospitals ON camps.hospital_id = hospitals.id";
$result = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Camps</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4 text-center">Blood Donation Camps</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Camp Name</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Location</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Date</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Time</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Hospital</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['location']) . "</td>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['date']) . "</td>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['time']) . "</td>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['hospital_name']) . "</td>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['description']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='py-2 px-4 border-b border-gray-200 text-center'>No camps available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>