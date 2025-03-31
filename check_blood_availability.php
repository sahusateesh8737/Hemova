<?php
session_start();
include 'dbconnection.php';

// Define available blood groups
$blood_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

// Handle search
$selected_blood_group = isset($_GET['blood_group']) ? $_GET['blood_group'] : '';

// Modify query based on search
if (!empty($selected_blood_group)) {
    $sql = "SELECT name, blood_group, disease, phoneno FROM users WHERE blood_group = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $selected_blood_group);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT name, blood_group, disease, phoneno FROM users";
    $result = mysqli_query($connection, $sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Blood Availability - Hemova</title>
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
            transition: all 0.3s ease-in-out;
        }

        @keyframes float-1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(10%, 10%) scale(1.1); }
        }

        @keyframes float-2 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-10%, -5%) scale(1.15); }
        }

        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            z-index: 2;
        }

        /* Table Styles */
        .custom-table {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .custom-table th {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .custom-table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
        }

        .custom-table tr:hover td {
            background: rgba(255, 255, 255, 0.05);
        }

        /* Select dropdown styling */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }

        select option {
            background-color: #1a1a1a;
            color: white;
        }

        /* Animation for results */
        tr {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        tr:nth-child(1) { animation-delay: 0.1s; }
        tr:nth-child(2) { animation-delay: 0.2s; }
        tr:nth-child(3) { animation-delay: 0.3s; }
        tr:nth-child(4) { animation-delay: 0.4s; }
        tr:nth-child(5) { animation-delay: 0.5s; }
    </style>
</head>
<body>
    <div class="gradient-background">
        <div class="gradient-sphere sphere-1"></div>
        <div class="gradient-sphere sphere-2"></div>
        <div class="grid-overlay"></div>
    </div>

    <!-- Navigation Bar -->
    <nav class="fixed top-0 left-0 z-50 w-full bg-transparent border-b backdrop-blur-sm border-white/10">
        <div class="container flex items-center justify-between p-4 mx-auto">
            <a href="index.php" class="text-2xl font-bold text-white transition-colors hover:text-red-500">Hemova</a>
            <div class="flex items-center space-x-4">
                <a href="index.php" class="transition text-white/90 hover:text-red-500">Home</a>
                <a href="profile.php" class="transition text-white/90 hover:text-red-500">Profile</a>
                <a href="check_blood_availability.php" class="transition text-white/90 hover:text-red-500">Check Blood</a>
                <a href="logout.php" class="px-4 py-2 text-white transition rounded bg-red-600/80 hover:bg-red-700">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container relative z-10 px-4 py-20 mx-auto md:py-24">
        <h1 class="mb-8 text-3xl font-bold text-center text-white">Check Blood Availability</h1>
        
        <!-- Search Form -->
        <div class="w-full max-w-md p-6 mx-auto mb-8 glass-effect rounded-xl">
            <form action="" method="GET" class="flex flex-col gap-4 md:flex-row md:items-end">
                <div class="flex-1">
                    <label for="blood_group" class="block mb-2 text-sm font-medium text-white">
                        Select Blood Group
                    </label>
                    <select name="blood_group" id="blood_group" 
                        class="w-full px-4 py-2 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 focus:ring-2 focus:ring-red-400 focus:border-transparent">
                        <option value="">All Blood Groups</option>
                        <?php foreach($blood_groups as $blood_group): ?>
                            <option value="<?php echo $blood_group; ?>" 
                                <?php echo ($selected_blood_group === $blood_group) ? 'selected' : ''; ?>>
                                <?php echo $blood_group; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" 
                    class="px-6 py-2 text-white transition duration-200 transform rounded-lg bg-gradient-to-r from-red-600 to-red-700 hover:shadow-lg hover:-translate-y-0.5">
                    Search
                </button>
            </form>
        </div>

        <!-- Results count -->
        <?php if (!empty($selected_blood_group)): ?>
            <div class="mb-4 text-center text-white/80">
                <?php
                $count = mysqli_num_rows($result);
                echo "Found " . $count . " donor(s) with blood group " . htmlspecialchars($selected_blood_group);
                ?>
            </div>
        <?php endif; ?>

        <!-- Results Table -->
        <div class="overflow-hidden glass-effect rounded-2xl">
            <table class="w-full custom-table">
                <thead>
                    <tr>
                        <th class="p-4 text-sm font-medium tracking-wider text-left uppercase">Name</th>
                        <th class="p-4 text-sm font-medium tracking-wider text-left uppercase">Blood Group</th>
                        <th class="p-4 text-sm font-medium tracking-wider text-left uppercase">Disease</th>
                        <th class="p-4 text-sm font-medium tracking-wider text-left uppercase">Phone Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='transition-colors hover:bg-white/5'>";
                            echo "<td class='p-4'>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td class='p-4'>" . htmlspecialchars($row['blood_group']) . "</td>";
                            echo "<td class='p-4'>" . htmlspecialchars($row['disease']) . "</td>";
                            echo "<td class='p-4'>" . htmlspecialchars($row['phoneno']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='p-4 text-center text-white/60'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>

<?php mysqli_close($connection); ?>