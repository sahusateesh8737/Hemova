<?php
session_start();
include 'dbconnection.php';

// Check if hospital is logged in
if (!isset($_SESSION['hospital_id'])) {
    header("Location: hospitalLogin.html");
    exit();
}

$hospital_id = $_SESSION['hospital_id'];
$addMessage = '';

// Handle form submission for adding a new camp
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_camp'])) {
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $description = trim($_POST['description']);

    if (empty($name) || empty($location) || empty($date) || empty($time) || empty($description)) {
        $addMessage = "<p class='text-red-600'>All fields are required.</p>";
    } else {
        try {
            $sql = "INSERT INTO camps (hospital_id, name, location, date, time, description) 
                   VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("isssss", $hospital_id, $name, $location, $date, $time, $description);
            
            if ($stmt->execute()) {
                $addMessage = "<p class='text-green-600'>Camp added successfully!</p>";
                // Clear form data after successful submission
                $_POST = array();
            } else {
                $addMessage = "<p class='text-red-600'>Error adding camp. Please try again.</p>";
            }
            $stmt->close();
        } catch (Exception $e) {
            $addMessage = "<p class='text-red-600'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}

// Handle form submission for deleting a camp
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_camp'])) {
    $camp_id = filter_input(INPUT_POST, 'camp_id', FILTER_VALIDATE_INT);
    if ($camp_id) {
        try {
            $sql = "DELETE FROM camps WHERE id = ? AND hospital_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ii", $camp_id, $hospital_id);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            $addMessage = "<p class='text-red-600'>Error deleting camp. Please try again.</p>";
        }
    }
}

// Fetch camps from the database
try {
    $sql = "SELECT * FROM camps WHERE hospital_id = ? ORDER BY date DESC";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $hospital_id);
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    $addMessage = "<p class='text-red-600'>Error fetching camps. Please try again.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Camps - Hemova</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="font-sans bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="fixed top-0 z-10 w-full bg-white shadow-md">
        <div class="container flex items-center justify-between p-4 mx-auto">
            <a href="index.php" class="text-2xl font-bold text-red-600">Hemova</a>
            <div class="space-x-4">
                <a href="manageCamps.php" class="text-gray-700 transition duration-300 hover:text-red-600">Manage Camps</a>
                <a href="logout.php" class="px-4 py-2 text-white transition duration-300 bg-red-600 rounded hover:bg-red-700">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container p-4 pt-20 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">Manage Blood Donation Camps</h1>

        <!-- Add New Camp Section -->
        <div class="p-6 mb-8 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-2xl font-bold text-red-600">Add New Camp</h2>
            <?php if ($addMessage): ?>
                <div class="mb-4"><?php echo $addMessage; ?></div>
            <?php endif; ?>
            <form action="manageCamps.php" method="POST">
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="name">Camp Name</label>
                        <input class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                               type="text" name="name" id="name" placeholder="Enter camp name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="location">Location</label>
                        <input class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                               type="text" name="location" id="location" placeholder="Enter location" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="date">Date</label>
                        <input class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                               type="date" name="date" id="date">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="time">Time</label>
                        <input class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                               type="time" name="time" id="time">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="description">Description</label>
                    <textarea class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                              name="description" id="description" rows="3" placeholder="Enter description" required></textarea>
                </div>
                <input class="w-full p-2 text-white transition duration-300 bg-red-600 rounded-md cursor-pointer hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" 
                       type="submit" name="add_camp" value="Add Camp">
            </form>
        </div>

        <!-- Existing Camps Section -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-2xl font-bold text-red-600">Existing Camps</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-sm font-medium tracking-wider text-left text-gray-700 uppercase bg-gray-100 border-b border-gray-200">Camp Name</th>
                            <th class="px-4 py-3 text-sm font-medium tracking-wider text-left text-gray-700 uppercase bg-gray-100 border-b border-gray-200">Location</th>
                            <th class="px-4 py-3 text-sm font-medium tracking-wider text-left text-gray-700 uppercase bg-gray-100 border-b border-gray-200">Date</th>
                            <th class="px-4 py-3 text-sm font-medium tracking-wider text-left text-gray-700 uppercase bg-gray-100 border-b border-gray-200">Time</th>
                            <th class="px-4 py-3 text-sm font-medium tracking-wider text-left text-gray-700 uppercase bg-gray-100 border-b border-gray-200">Description</th>
                            <th class="px-4 py-3 text-sm font-medium tracking-wider text-left text-gray-700 uppercase bg-gray-100 border-b border-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='px-4 py-3 border-b border-gray-200'>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td class='px-4 py-3 border-b border-gray-200'>" . htmlspecialchars($row['location']) . "</td>";
                                echo "<td class='px-4 py-3 border-b border-gray-200'>" . htmlspecialchars($row['date']) . "</td>";
                                echo "<td class='px-4 py-3 border-b border-gray-200'>" . htmlspecialchars($row['time']) . "</td>";
                                echo "<td class='px-4 py-3 border-b border-gray-200'>" . htmlspecialchars($row['description']) . "</td>";
                                echo "<td class='px-4 py-3 border-b border-gray-200'>";
                                echo "<form action='manageCamps.php' method='POST' class='inline'>";
                                echo "<input type='hidden' name='camp_id' value='" . $row['id'] . "'>";
                                echo "<input type='submit' name='delete_camp' value='Delete' class='px-4 py-2 text-white transition duration-300 bg-red-600 rounded cursor-pointer hover:bg-red-700'>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='px-4 py-3 text-center text-gray-600 border-b border-gray-200'>No camps available</td></tr>";
                        }
                        $stmt->close();
                        $connection->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>