<?php

require "config/config.php";
include "includes/form_handlers/register_handler.php";
include "includes/form_handlers/login_handler.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <title>Welcome to Faces</title>
</head>
<body>
    <?php 
    if(isset($_POST["register_button"])) {
        echo '
            <script>
            $(document).ready(function() {
                $(".first").hide();
                $(".second").show();
            });
            </script>
        ';
    }
    ?>

    <div class="wrapper">

        <div class="login_box">
            <div class="login_header">
                <h1>Faces</h1>
                <p>Log or sign in below!</p>
            </div>

            <div class="first">
                <form action="register.php" method="POST">
                    <input class="email" type="email" name="log_email" placeholder="Email Address" value="<?php if(isset($_SESSION['log_email'])) {
                            echo ($_SESSION['log_email']);
                        }
                    ?>" required> <br>
                    <input type="password" name="log_password" placeholder="Password" required> <br>
                
                    <input type="submit" name="login_button" value="Login" >
                    <br>
                    <a href="#" id="signup" class="signup">Don`t have an account? Register here!</a>
                     <?php if(in_array("Email or password incorrect<br>", $error_array)) echo "Email or password incorrect<br>"; ?> <!-- if we find this error message in the array than echo it -->
                </form>
            </div>
            <br>

             <div class="second">
                 <form action="register.php" method="POST">  <!--action = send form to "register.php" -->
                    <!-- First Name -->
                    <input type="text" name="reg_fname" placeholder="First Name" value="<?php if(isset($_SESSION['reg_fname'])) {
                            echo $_SESSION['reg_fname'];
                        }
                    ?>" required>
                    <br>
                    <?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "Your first name must be between 2 and 25 characters<br>"; ?>
                    <!-- Last Name -->
                    <input type="text" name="reg_lname" placeholder="Last Name" value="<?php
                        if(isset($_SESSION['reg_lname'])) {
                            echo trim($_SESSION['reg_lname']);
                        }
                    ?>" required>
                    <br>
                    <?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) echo "Your last name must be between 2 and 25 characters<br>"; ?>
                    <!-- Email         -->
                    <input type="email" name="reg_email" placeholder="Email" value="<?php
                        if(isset($_SESSION['reg_email'])) {
                            echo $_SESSION['reg_email'];
                        }
                    ?>
                    " required>
                    <br>
                    <!-- Confirm Email     -->
                    <input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php
                        if(isset($_SESSION['reg_email2'])) {
                            echo $_SESSION['reg_email2'];
                        }
                    ?>
                    " required>
                    <br>
                    <?php if(in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>";
                          else if(in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
                          else if(in_array("Emails don`t match<br>", $error_array)) echo "Emails don`t match<br>";
                    ?>
                    <!-- Password     -->
                    <input type="password" name="reg_password" placeholder="Password" required>
                    <br>
                    <!-- Confirm Password -->
                    <input type="password" name="reg_password2" placeholder="Confirm Password" required>
                    <br>
                    <?php if(in_array("Your passwods do not match<br>", $error_array)) echo "Your passwods do not match<br>";
                    else if(in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "Your password can only contain english characters or numbers<br>";
                    else if(in_array("Your password must be between 5 and 30 characters<br>", $error_array)) echo "Your password must be between 5 and 30 characters<br>"; ?>
                    <!-- Submit Button     -->
                    <input type="submit" name="register_button" value="Register">
                    <br>
                    <?php if(in_array("<span style='color: #14c800'>Username registered succesfuly</span><br>", $error_array)) echo "<span style='color: #14c800'>Username registered succesfuly</span><br>" ?>
                    <a href="#" id="signin" class="signin">Already have an account? Sign in here!</a> 
                 </form>
             </div>
        </div>
    </div>
    <script src="./assets/js/register.js"></script>
</body>
</html>