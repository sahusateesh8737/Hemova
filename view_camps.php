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

// Fetch registered camps for the current user
$user_id = $_SESSION['currUserID'];
$registrations = mysqli_query($connection, 
    "SELECT camp_id FROM camp_registrations WHERE user_id = $user_id"
);
$registered_camps = array();
while ($reg = mysqli_fetch_assoc($registrations)) {
    $registered_camps[] = $reg['camp_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Blood Donation Camps - Hemova</title>
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
                <a href="profile.php" class="transition text-white/90 hover:text-red-500">Profile</a>
                <a href="check_blood_availability.php" class="transition text-white/90 hover:text-red-500">Check Blood</a>
                <a href="view_camps.php" class="transition text-white/90 hover:text-red-500">View Camps</a>
                <a href="logout.php" class="px-4 py-2 text-white transition rounded bg-red-600/80 hover:bg-red-700">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container relative z-10 px-4 py-20 mx-auto">
        <h1 class="mb-8 text-3xl font-bold text-center text-white">Upcoming Blood Donation Camps</h1>
        
        <div class="p-6 glass-effect rounded-xl">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-white/10">
                            <th class="p-3 text-sm font-medium text-white/80">Camp Name</th>
                            <th class="p-3 text-sm font-medium text-white/80">Location</th>
                            <th class="p-3 text-sm font-medium text-white/80">Date</th>
                            <th class="p-3 text-sm font-medium text-white/80">Time</th>
                            <th class="p-3 text-sm font-medium text-white/80">Hospital</th>
                            <th class="p-3 text-sm font-medium text-white/80">Description</th>
                            <th class="p-3 text-sm font-medium text-white/80">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): while ($row = mysqli_fetch_assoc($result)): 
                            $date = date('d F Y', strtotime($row['date']));
                            $time = date('h:i A', strtotime($row['time']));
                        ?>
                            <tr class="border-b border-white/10 hover:bg-white/5">
                                <td class="p-3 text-white/70"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td class="p-3 text-white/70"><?php echo htmlspecialchars($row['location']); ?></td>
                                <td class="p-3 text-white/70"><?php echo $date; ?></td>
                                <td class="p-3 text-white/70"><?php echo $time; ?></td>
                                <td class="p-3 text-white/70"><?php echo htmlspecialchars($row['hospital_name']); ?></td>
                                <td class="p-3 text-white/70"><?php echo htmlspecialchars($row['description']); ?></td>
                                <td class="p-3">
                                    <?php if (in_array($row['id'], $registered_camps)): ?>
                                        <button class="px-4 py-1 text-sm text-white transition rounded-full bg-green-500/20" disabled>
                                            Registered
                                        </button>
                                    <?php else: ?>
                                        <button onclick="registerForCamp(<?php echo $row['id']; ?>)" 
                                            class="px-4 py-1 text-sm text-white transition rounded-full bg-red-500/20 hover:bg-red-500/30">
                                            Register
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr>
                                <td colspan="7" class="p-3 text-center text-white/50">No upcoming camps available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    function registerForCamp(campId) {
        if (confirm('Are you sure you want to register for this camp?')) {
            fetch('register_camp.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'camp_id=' + campId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Registration successful!');
                    location.reload();
                } else {
                    alert(data.message || 'Registration failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Registration failed');
            });
        }
    }
    </script>
</body>
</html>