<?php
$server= "localhost";
$username = "root";
$pass = "";
$database = "hemova";
$connection = mysqli_connect($server,$username,$pass,$database);
if($connection){
    echo "connection succesfully";
}
else{
    die("error".mysqli_connect_error());
}
?>