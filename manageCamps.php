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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background-color: #050505;
            color: white;
            position: relative;
            overflow-x: hidden;
        }

        .gradient-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
        }

        .gradient-sphere {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
        }

        .sphere-1 {
            width: 40vw;
            height: 40vw;
            background: linear-gradient(40deg, rgba(255, 0, 128, 0.8), rgba(255, 102, 0, 0.4));
            top: -10%;
            left: -10%;
            animation: float-1 15s ease-in-out infinite alternate;
        }

        .sphere-2 {
            width: 45vw;
            height: 45vw;
            background: linear-gradient(240deg, rgba(72, 0, 255, 0.8), rgba(0, 183, 255, 0.4));
            bottom: -20%;
            right: -10%;
            animation: float-2 18s ease-in-out infinite alternate;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .form-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-input:focus {
            border-color: rgba(239, 68, 68, 0.5);
            ring-color: rgba(239, 68, 68, 0.5);
        }

        @keyframes float-1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(10%, 10%) scale(1.1); }
        }

        @keyframes float-2 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-10%, -5%) scale(1.15); }
        }
    </style>
</head>
<body>
    <div class="gradient-background">
        <div class="gradient-sphere sphere-1"></div>
        <div class="gradient-sphere sphere-2"></div>
    </div>

    <!-- Navigation Bar -->
    <nav class="fixed top-0 left-0 z-50 w-full bg-transparent border-b backdrop-blur-sm border-white/10">
        <div class="container flex items-center justify-between p-4 mx-auto">
            <a href="index.php" class="text-2xl font-bold text-white transition-colors hover:text-red-500">Hemova</a>
            <div class="flex items-center space-x-4">
                <!-- <a href="manageCamps.php" class="transition text-white/90 hover:text-red-500">Manage Camps</a> -->
                <a href="view_registrations.php" class="transition text-white/90 hover:text-red-500">View Registrations</a>
                <a href="logout.php" class="px-4 py-2 text-white transition rounded bg-red-600/80 hover:bg-red-700">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container relative z-10 px-4 py-20 mx-auto">
        <h1 class="mb-8 text-3xl font-bold text-center text-white">Manage Blood Donation Camps</h1>

        <!-- Add New Camp Section -->
        <div class="p-6 mb-8 glass-effect rounded-xl">
            <h2 class="mb-6 text-2xl font-bold text-white/90">Add New Camp</h2>
            <?php if ($addMessage): ?>
                <div class="mb-4"><?php echo $addMessage; ?></div>
            <?php endif; ?>
            <form action="manageCamps.php" method="POST">
                <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-white/80">Camp Name</label>
                        <input class="w-full px-4 py-2 rounded-lg form-input" 
                               type="text" name="name" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-white/80">Location</label>
                        <input class="w-full px-4 py-2 rounded-lg form-input" 
                               type="text" name="location" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-white/80">Date</label>
                        <input class="w-full px-4 py-2 rounded-lg form-input" 
                               type="date" name="date" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-white/80">Time</label>
                        <input class="w-full px-4 py-2 rounded-lg form-input" 
                               type="time" name="time" required>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-white/80">Description</label>
                    <textarea class="w-full px-4 py-2 rounded-lg form-input" 
                              name="description" rows="3" required></textarea>
                </div>
                <button type="submit" name="add_camp" 
                    class="w-full py-2 text-white transition duration-200 transform rounded-lg bg-gradient-to-r from-red-600 to-red-700 hover:shadow-lg hover:-translate-y-0.5">
                    Add Camp
                </button>
            </form>
        </div>

        <!-- Existing Camps Section -->
        <div class="p-6 glass-effect rounded-xl">
            <h2 class="mb-6 text-2xl font-bold text-white/90">Existing Camps</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-white/10">
                            <th class="p-3 text-sm font-medium text-white/80">Camp Name</th>
                            <th class="p-3 text-sm font-medium text-white/80">Location</th>
                            <th class="p-3 text-sm font-medium text-white/80">Date</th>
                            <th class="p-3 text-sm font-medium text-white/80">Time</th>
                            <th class="p-3 text-sm font-medium text-white/80">Description</th>
                            <th class="p-3 text-sm font-medium text-white/80">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): while ($row = $result->fetch_assoc()): ?>
                            <tr class="border-b border-white/10">
                                <td class="p-3 text-white/70"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td class="p-3 text-white/70"><?php echo htmlspecialchars($row['location']); ?></td>
                                <td class="p-3 text-white/70"><?php echo htmlspecialchars($row['date']); ?></td>
                                <td class="p-3 text-white/70"><?php echo htmlspecialchars($row['time']); ?></td>
                                <td class="p-3 text-white/70"><?php echo htmlspecialchars($row['description']); ?></td>
                                <td class="p-3">
                                    <form action="manageCamps.php" method="POST" class="inline">
                                        <input type="hidden" name="camp_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete_camp" 
                                            class="px-4 py-1 text-sm text-white transition rounded-full bg-red-500/20 hover:bg-red-500/30">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr>
                                <td colspan="6" class="p-3 text-center text-white/50">No camps available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>