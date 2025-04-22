<?php
// Script to create the password_resets table for OTP-based password recovery
include 'dbconnection.php';

// SQL to create the password_resets table
$sql = "CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

// Execute the SQL
if ($connection->query($sql) === TRUE) {
    echo "Table 'password_resets' created successfully or already exists.";
} else {
    echo "Error creating table: " . $connection->error;
}

$connection->close();
?>