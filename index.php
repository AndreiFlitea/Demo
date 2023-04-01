<?php
$con = mysqli_connect("localhost", "root", "", "social"); //connection to database : 4 param (1.host, 2.username, 3.password, 4.databaseName )

if(mysqli_connect_errno()) { // returns the error that was found when connect to database
    echo "Failed to connect: " . mysqli_connect_errno(); 
    // error = 0 (false, code does not execute) or 1=>infinit
}

$query = mysqli_query($con, "INSERT INTO test VALUES('', 'Andrei')"); //query to insert ino table: function(connection $, query);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello Andrei!!!??</h1>
</body>
</html>