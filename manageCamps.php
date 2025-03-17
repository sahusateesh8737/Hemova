<?php
session_start();
include 'dbconnection.php';

// Check if hospital is logged in
if (!isset($_SESSION['hospital_id'])) {
    header("Location: hospitalLogin.html");
    exit();
}

$hospital_id = $_SESSION['hospital_id'];

// Handle form submission for adding a new camp
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_camp'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $description = $_POST['description'];

    $sql = "INSERT INTO camps (hospital_id, name, location, date, time, description) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("isssss", $hospital_id, $name, $location, $date, $time, $description);
    $stmt->execute();
}

// Handle form submission for deleting a camp
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_camp'])) {
    $camp_id = $_POST['camp_id'];

    $sql = "DELETE FROM camps WHERE id = ? AND hospital_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $camp_id, $hospital_id);
    $stmt->execute();
}

// Fetch camps from the database
$sql = "SELECT * FROM camps WHERE hospital_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $hospital_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Camps</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4 text-center">Manage Blood Donation Camps</h1>
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-bold mb-4">Add New Camp</h2>
            <form action="managecamps.php" method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="name">Camp Name</label>
                    <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                           type="text" name="name" id="name" placeholder="Enter camp name" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="location">Location</label>
                    <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                           type="text" name="location" id="location" placeholder="Enter location" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="date">Date</label>
                    <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                           type="date" name="date" id="date">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="time">Time</label>
                    <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                           type="time" name="time" id="time">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="description">Description</label>
                    <textarea class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                              name="description" id="description" placeholder="Enter description" required></textarea>
                </div>
                <input class="w-full bg-red-600 text-white p-2 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 cursor-pointer" 
                       type="submit" name="add_camp" value="Add Camp">
            </form>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Existing Camps</h2>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Camp Name</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Location</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Date</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Time</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Description</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['location']) . "</td>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['date']) . "</td>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['time']) . "</td>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>" . htmlspecialchars($row['description']) . "</td>";
                            echo "<td class='py-2 px-4 border-b border-gray-200'>";
                            echo "<form action='manage_camps.php' method='POST' class='inline'>";
                            echo "<input type='hidden' name='camp_id' value='" . $row['id'] . "'>";
                            echo "<input type='submit' name='delete_camp' value='Delete' class='bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 cursor-pointer'>";
                            echo "</form>";
                            echo "</td>";
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