<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'dbconnection.php';

if (!isset($_SESSION['hospital_id'])) {
    header("Location: hospitalLogin.html");
    exit();
}

$hospital_id = $_SESSION['hospital_id'];

// Modified query to include camp ID and registration ID
$sql = "SELECT 
            cr.id as registration_id,
            cr.status,
            cr.registration_date,
            c.id as camp_id,
            c.name as camp_name, 
            c.date, 
            u.name as user_name, 
            u.email, 
            u.phoneno, 
            u.blood_group
        FROM camp_registrations cr
        JOIN camps c ON cr.camp_id = c.id
        JOIN Users u ON cr.user_id = u.id
        WHERE c.hospital_id = ?
        ORDER BY c.date DESC, cr.registration_date DESC";

try {
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $connection->error);
    }

    $stmt->bind_param("i", $hospital_id);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $registrations = $stmt->get_result();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camp Registrations - Hemova</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Add the same styles as other pages */
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

        .glass-effect {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
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
                <a href="manageCamps.php" class="transition text-white/90 hover:text-red-500">Manage Camps</a>
                <a href="view_registrations.php" class="text-red-500 transition">View Registrations</a>
                <a href="logout.php" class="px-4 py-2 text-white transition rounded bg-red-600/80 hover:bg-red-700">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container relative z-10 px-4 py-20 mx-auto">
        <h1 class="mb-8 text-3xl font-bold text-center text-white">Camp Registrations</h1>
        
        <?php if ($registrations && $registrations->num_rows > 0): ?>
        <div class="p-6 glass-effect rounded-xl">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-white/10">
                            <th class="p-3 text-sm font-medium text-white/80">Camp Name</th>
                            <th class="p-3 text-sm font-medium text-white/80">Date</th>
                            <th class="p-3 text-sm font-medium text-white/80">User Name</th>
                            <th class="p-3 text-sm font-medium text-white/80">Blood Group</th>
                            <th class="p-3 text-sm font-medium text-white/80">Contact</th>
                            <th class="p-3 text-sm font-medium text-white/80">Registration Date</th>
                            <th class="p-3 text-sm font-medium text-white/80">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($reg = $registrations->fetch_assoc()): ?>
                        <tr class="border-b border-white/10 hover:bg-white/5">
                            <td class="p-3 text-white/70"><?php echo htmlspecialchars($reg['camp_name']); ?></td>
                            <td class="p-3 text-white/70"><?php echo date('d M Y', strtotime($reg['date'])); ?></td>
                            <td class="p-3 text-white/70"><?php echo htmlspecialchars($reg['user_name']); ?></td>
                            <td class="p-3 text-white/70"><?php echo htmlspecialchars($reg['blood_group']); ?></td>
                            <td class="p-3 text-white/70">
                                <div class="flex flex-col">
                                    <span><?php echo htmlspecialchars($reg['email']); ?></span>
                                    <span class="text-white/50"><?php echo htmlspecialchars($reg['phoneno']); ?></span>
                                </div>
                            </td>
                            <td class="p-3 text-white/70"><?php echo date('d M Y', strtotime($reg['registration_date'])); ?></td>
                            <td class="p-3 text-white/70">
                                <span class="px-2 py-1 text-sm rounded-full <?php echo $reg['status'] === 'confirmed' ? 'bg-green-500/20' : 'bg-yellow-500/20'; ?>">
                                    <?php echo ucfirst($reg['status']); ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php else: ?>
        <div class="p-8 text-center glass-effect rounded-xl">
            <p class="text-white/70">No registrations found for your camps.</p>
        </div>
        <?php endif; ?>
    </div>

    <?php mysqli_close($connection); ?>
</body>
</html>