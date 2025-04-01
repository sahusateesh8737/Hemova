<?php
session_start();
include 'dbconnection.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Handle both POST and DELETE methods
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];
    
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'No ID provided']);
        exit();
    }

    $stmt = $connection->prepare("DELETE FROM Users WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    $success = $stmt->execute();
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $success ? 'User deleted successfully' : 'Error deleting user'
    ]);
    
    $stmt->close();
}

mysqli_close($connection);
?>