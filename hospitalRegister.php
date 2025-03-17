<?php
include 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hashing
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO hospitals (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $password, $phone, $address);
    
    if ($stmt->execute()) {
        echo "Registration successful! <a href='signin.php'>Login here</a>";
    } else {
        echo "Error: " . $connection->error;
    }
}
?>