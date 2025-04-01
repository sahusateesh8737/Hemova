<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'dbconnection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch statistics
$stats = [
    'users' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as count FROM Users"))['count'],
    'hospitals' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as count FROM hospitals"))['count'],
    'camps' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as count FROM camps"))['count']
];

// Fetch recent users
$recent_users = mysqli_query($connection, "SELECT id, name, email, blood_group FROM Users ORDER BY id DESC LIMIT 5");

// Fetch recent hospitals
$recent_hospitals = mysqli_query($connection, "SELECT id, name, email, phone FROM hospitals ORDER BY id DESC LIMIT 5");

// Fetch upcoming camps
$upcoming_camps = mysqli_query($connection, "
    SELECT c.*, h.name as hospital_name 
    FROM camps c 
    JOIN hospitals h ON c.hospital_id = h.id 
    WHERE c.date >= CURDATE() 
    ORDER BY c.date ASC 
    LIMIT 5
");

// Fetch all users
$all_users = mysqli_query($connection, "SELECT id, name, email, blood_group, phoneno, age, gender FROM Users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hemova</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Base Styles */
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

        /* Add existing gradient and glass effect styles */
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

        /* Admin Dashboard specific styles */
        .stat-card {
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .action-button {
            background: linear-gradient(to right, rgba(239, 68, 68, 0.8), rgba(225, 29, 72, 0.8));
            transition: all 0.3s ease;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
    </style>
</head>
<body>
    <div class="gradient-background">
        <div class="gradient-sphere sphere-1"></div>
        <div class="gradient-sphere sphere-2"></div>
        <div class="grid-overlay"></div>
    </div>

    <!-- Side Navigation -->
    <nav class="fixed top-0 left-0 z-50 w-64 h-full glass-effect">
        <div class="p-6">
            <h2 class="mb-8 text-2xl font-bold">Hemova Admin</h2>
            <ul class="space-y-4">
                <li>
                    <a href="#dashboard" class="flex items-center transition text-white/90 hover:text-red-500">
                        <i class="w-6 fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#users" class="flex items-center transition text-white/90 hover:text-red-500">
                        <i class="w-6 fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="#hospitals" class="flex items-center transition text-white/90 hover:text-red-500">
                        <i class="w-6 fas fa-hospital"></i>
                        <span>Hospitals</span>
                    </a>
                </li>
                <li>
                    <a href="#donations" class="flex items-center transition text-white/90 hover:text-red-500">
                        <i class="w-6 fas fa-tint"></i>
                        <span>Donations</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="flex items-center transition text-white/90 hover:text-red-500">
                        <i class="w-6 fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative z-10 p-8 ml-64">
        <!-- Stats Section -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
            <div class="p-6 rounded-xl glass-effect stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg text-white/60">Total Users</h3>
                        <p class="text-3xl font-bold"><?php echo $stats['users']; ?></p>
                    </div>
                    <i class="text-4xl fas fa-users text-red-500/50"></i>
                </div>
            </div>
            <div class="p-6 rounded-xl glass-effect stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg text-white/60">Total Hospitals</h3>
                        <p class="text-3xl font-bold"><?php echo $stats['hospitals']; ?></p>
                    </div>
                    <i class="text-4xl fas fa-hospital text-red-500/50"></i>
                </div>
            </div>
            <div class="p-6 rounded-xl glass-effect stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg text-white/60">Blood Camps</h3>
                        <p class="text-3xl font-bold"><?php echo $stats['camps']; ?></p>
                    </div>
                    <i class="text-4xl fas fa-campground text-red-500/50"></i>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <!-- Recent Users -->
            <div class="p-6 glass-effect rounded-xl">
                <h3 class="mb-4 text-xl font-semibold">Recent Users</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left border-b border-white/10">
                                <th class="p-3">Name</th>
                                <th class="p-3">Email</th>
                                <th class="p-3">Blood Group</th>
                                <th class="p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($user = mysqli_fetch_assoc($recent_users)): ?>
                            <tr class="border-b border-white/10">
                                <td class="p-3"><?php echo htmlspecialchars($user['name']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($user['blood_group']); ?></td>
                                <td class="p-3">
                                    <a href="view_user.php?id=<?php echo $user['id']; ?>" 
                                       class="px-3 py-1 text-sm transition rounded-full bg-red-500/20 hover:bg-red-500/30">
                                        View
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Hospitals -->
            <div class="p-6 glass-effect rounded-xl">
                <h3 class="mb-4 text-xl font-semibold">Recent Hospitals</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left border-b border-white/10">
                                <th class="p-3">Name</th>
                                <th class="p-3">Contact</th>
                                <th class="p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($hospital = mysqli_fetch_assoc($recent_hospitals)): ?>
                            <tr class="border-b border-white/10">
                                <td class="p-3"><?php echo htmlspecialchars($hospital['name']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($hospital['phone']); ?></td>
                                <td class="p-3">
                                    <a href="view_hospital.php?id=<?php echo $hospital['id']; ?>" 
                                       class="px-3 py-1 text-sm transition rounded-full bg-red-500/20 hover:bg-red-500/30">
                                        View
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- All Users Section -->
        <div class="w-full p-6 mt-4 mb-8 glass-effect rounded-xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold">All Users</h3>
                <div class="flex gap-4">
                    <input type="text" 
                        id="userSearch" 
                        class="px-4 py-2 text-white transition duration-200 border rounded-lg bg-white/10 border-white/20 focus:ring-2 focus:ring-red-400 focus:border-transparent"
                        placeholder="Search by name, email, blood group..."
                        autocomplete="off"
                    >
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-white/10">
                            <th class="p-3">Name</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Blood Group</th>
                            <th class="p-3">Phone</th>
                            <th class="p-3">Age</th>
                            <th class="p-3">Gender</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        <?php while($user = mysqli_fetch_assoc($all_users)): ?>
                        <tr class="border-b border-white/10" data-user-id="<?php echo $user['id']; ?>">
                            <td class="p-3"><?php echo htmlspecialchars($user['name']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($user['blood_group']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($user['phoneno']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($user['age']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($user['gender']); ?></td>
                            <td class="p-3">
                                <div class="flex gap-2">
                                    <button onclick="deleteUser(<?php echo $user['id']; ?>)"
                                        class="px-3 py-1 text-sm text-white transition rounded-full bg-red-500/20 hover:bg-red-500/30">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                fetch('delete_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + userId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                        if (row) {
                            row.remove();
                        }
                        // Show success message
                        alert('User deleted successfully');
                    } else {
                        alert(data.message || 'Error deleting user');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting user');
                });
            }
        }

        // Search functionality
        document.getElementById('userSearch').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const tbody = document.getElementById('userTableBody');
            const rows = tbody.getElementsByTagName('tr');

            for (let row of rows) {
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let cell of cells) {
                    if (cell.textContent.toLowerCase().includes(searchText)) {
                        found = true;
                        break;
                    }
                }

                row.style.display = found ? '' : 'none';
                
                // Add fade effect
                if (found) {
                    row.style.opacity = '1';
                    row.style.transform = 'translateX(0)';
                } else {
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(-20px)';
                }
            }
        });

        // Add transition styles to table rows
        const rows = document.querySelectorAll('#userTableBody tr');
        rows.forEach(row => {
            row.style.transition = 'all 0.3s ease-in-out';
        });
    </script>
</body>
</html>

<?php mysqli_close($connection); ?>