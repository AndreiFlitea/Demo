<?php
ob_start(); //Turns on output buffering
session_start();
$timezone = date_default_timezone_set("Europe/Bucharest");

$con = mysqli_connect("localhost", "root", "", "social"); //connection to database : 4 param (1.host, 2.username, 3.password, 4.databaseName )

if(mysqli_connect_errno()) { // returns the error that was found when connect to database
    echo "Failed to connect: " . mysqli_connect_errno(); 
    // error = 0 (false, code does not execute) or 1=>infinit
}
?>
