<?php
session_start(); // Add session start at the beginning
include 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO hospitals (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $password, $phone, $address);
    
    if ($stmt->execute()) {
        // Get the hospital ID of the newly registered hospital
        $hospital_id = $connection->insert_id;
        
        // Set session variables
        $_SESSION['hospital_id'] = $hospital_id;
        $_SESSION['hospital_name'] = $name;
        $_SESSION['is_hospital'] = true;
        
        // Redirect to index page
        header("Location: index.php");
        exit(); // Add exit after redirect
    } else {
        echo "Error: " . $connection->error;
    }
    
    $stmt->close();
    $connection->close();
}
?>