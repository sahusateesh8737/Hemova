<?php
session_start();
include 'dbconnection.php';

if (!isset($_SESSION['currUserID'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $camp_id = filter_input(INPUT_POST, 'camp_id', FILTER_VALIDATE_INT);
    $user_id = $_SESSION['currUserID'];

    try {
        $stmt = $connection->prepare("INSERT INTO camp_registrations (camp_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $camp_id, $user_id);
        $success = $stmt->execute();

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Registration successful' : 'Already registered'
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Registration failed']);
    }
}
?>