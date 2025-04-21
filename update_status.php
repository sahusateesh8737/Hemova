<?php
session_start();
include 'dbconnection.php';

// Check if hospital is logged in
if (!isset($_SESSION['hospital_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authorized']);
    exit();
}

// Check if request is POST and has the required data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registration_id'])) {
    $registration_id = intval($_POST['registration_id']);
    $new_status = $_POST['new_status'] ?? 'confirmed';
    
    // Validate registration_id belongs to a camp owned by this hospital
    $hospital_id = $_SESSION['hospital_id'];
    
    $check_sql = "SELECT cr.id 
                 FROM camp_registrations cr
                 JOIN camps c ON cr.camp_id = c.id
                 WHERE cr.id = ? AND c.hospital_id = ?";
                 
    $check_stmt = $connection->prepare($check_sql);
    $check_stmt->bind_param("ii", $registration_id, $hospital_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Registration not found or not authorized']);
        exit();
    }
    
    // Update the status
    $update_sql = "UPDATE camp_registrations SET status = ? WHERE id = ?";
    $update_stmt = $connection->prepare($update_sql);
    $update_stmt->bind_param("si", $new_status, $registration_id);
    
    if ($update_stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating status: ' . $connection->error]);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>