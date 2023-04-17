<?php
require "config/config.php";

if(isset($_SESSION['username'])) { // check if the session variable "username" has been set 
    $userLoggedIn = $_SESSION['username']; // if set then assign the value to a local variable called '$userLoggedIn'
    $user_detail_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'"); // execute a SQL query to fetch details about the user from the database 
    $user = mysqli_fetch_array($user_detail_query); // transform the result into an array.
} else {
    header("Location: register.php"); // else function that redirects
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Faces!!!</title>
    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <!-- CSS -->
    <script src="https://kit.fontawesome.com/67fce18640.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">    
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">    


</head>

<body>    

<div class="top_bar">
  <div class="logo">
    <a href="index.php">Faces!</a>
  </div>

  <nav>
    <a href="<?php echo $userLoggedIn ?>"><?php echo $user['first_name']; ?></i></i></a>
    <a href="index.php"><i class="fa-solid fa-house"></i></i></a>
    <a href="#"><i class="fa-solid fa-envelope"></i></a>
    <a href="#"><i class="fa-solid fa-bell"></i></a>
    <a href="#"><i class="fa-solid fa-users"></i></i></a>
    <a href="#"><i class="fa-sharp fa-solid fa-gear"></i></a>
    <a href="includes/handlers/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
   

  </nav>
</div>


<div class="wrapper">
  


