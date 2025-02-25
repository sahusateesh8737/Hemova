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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body>
<!-- php code -->
 <?php
 if($_SERVER['REQUEST_METHOD'] =='POST'){
    $name= $_POST['name'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $age =$_POST['age'];
    $gender = $_POST['gender'];
    echo "name is $name";
    echo "$email";
    echo "$phoneno";
    echo "$age";
    echo "$gender";

 }
 ?>

    <div>
        <form action="" method="POST">
            <label for="name">Name</label>
            <input type="text" name="name">
            <br>
            <label for="email">email</label>
            <input type="email" name="email">
            <br>
            <label for="phoneno">PhoneNo</label>
            <input type="tel" name="phoneno">
            <br>
            <label for="age">Age</label>
            <input type="number" name="age">
            <br>
            <label for="gender">gender</label>
            <input type="text" name="gender">
            <br>
            <input type="submit" value="signup">
        </form>
    </div>
</body>
</html>