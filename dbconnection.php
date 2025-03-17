<?php
$server = "localhost";
$username = "root";
$pass = "";
$database = "hemova";
$connection = mysqli_connect($server, $username, $pass, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connection successful!";
}
?>