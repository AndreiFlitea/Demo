<?php

session_start();

$con = mysqli_connect("localhost", "root", "", "social"); //connection to database : 4 param (1.host, 2.username, 3.password, 4.databaseName )

if(mysqli_connect_errno()) { // returns the error that was found when connect to database
    echo "Failed to connect: " . mysqli_connect_errno(); 
    // error = 0 (false, code does not execute) or 1=>infinit
}

//Declaring variables to prevent errors
$fname = ""; //First Name
$lname = ""; //Last Name
$em = ""; //email
$em2 = ""; //email 2
$password = ""; //password
$password2 = ""; //password 2
$date = ""; //Sign up date
$error_array = array(); //Holds err messages


//check if a form has been submitted, specifically when a button named "register_button" is pressed
//isset(): This is a built-in PHP function that checks if a variable is set, meaning it has been assigned a value and is not NULL. In this case, it's checking if the 'register_button' key in the $_POST array has been set.
//$_POST: This is a superglobal variable in PHP, which means it's available in all scopes throughout a script. It's an associative array containing data submitted by an HTML form using the POST method. The --keys-- in this array are the --names-- of the form elements, and the --values-- are the --submitted data--.

//So, putting it all together, this line of code can be read as: "If the 'register_button' has been set in the $_POST array (meaning the form has been submitted with the register_button being pressed), then execute the following code block within the curly braces {}."
if(isset($_POST['register_button'])) { 

    //Registration form values

    //First name
    $fname = strip_tags($_POST['reg_fname']); //Security - remove html tags
    $fname = str_replace(' ', '', $fname); //Remove spaces
    $fname = ucfirst(strtolower($fname));//Uppercase first letter only
    $_SESSION['reg_fname'] = $fname; // Stores first name into session variable

    //Last name
    $lname = strip_tags($_POST['reg_lname']); //Security - remove html tags
    $lname = str_replace(' ', '', $lname); //Remove spaces
    $lname = ucfirst(strtolower($lname));//Uppercase first letter only
    $_SESSION['reg_lname'] = $lname; // Stores last name into session variable

    //Email
    $em = strip_tags($_POST['reg_email']); //Security - remove html tags
    $em = str_replace(' ', '', $em); //Remove spaces
    $em = ucfirst(strtolower($em));//Uppercase first letter only
    $_SESSION['reg_email'] = $em; // Stores email into session variable

    //Email 2
    $em2 = strip_tags($_POST['reg_email2']); //Security - remove html tags
    $em2 = str_replace(' ', '', $em2); //Remove spaces
    $em2 = ucfirst(strtolower($em2));//Uppercase first letter only
    $_SESSION['reg_email2'] = $em2; // Stores email2 into session variable

    //Password
    $password = strip_tags($_POST['reg_password']); //Security - remove html tags

    //Password 2
    $password2 = strip_tags($_POST['reg_password2']); //Security - remove html tags

    $date = date("Y-m-d"); //Current date

    if($em == $em2) {
        //Check if email is in valid format

        //if(filter_var($em, FILTER_VALIDATE_EMAIL)) {: Inside the outer if block, this line is checking if the email address stored in the $em variable is in a valid format. The filter_var() function is a built-in PHP function used to filter and validate data. It takes two arguments:

        //$em: The variable we want to filter or validate.
        //FILTER_VALIDATE_EMAIL: A --constant-- representing the specific filter to apply. In this case, we're using it to validate an email address.
        //If the email address is valid, filter_var() will return the filtered data (the valid email address); otherwise, it will return false.
        
        if(filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

            //Check if email exists

            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

            //Count number of rows returned
            $num_rows = mysqli_num_rows($e_check);

            if($num_rows > 0) {
                array_push($error_array, "Email already in use<br>");
            }
        } else{
            array_push($error_array, "Invalid email format<br>");
        }
    } else {
        array_push($error_array, "Emails don`t match<br>");
    }

    //Validate name
    if(strlen($fname) > 25 || strlen($fname) < 2 ) {
        array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
    }

    if(strlen($lname) > 25 || strlen($lname) < 2 ) {
        array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
    }
    //Validate password
    if($password != $password2) {
        array_push($error_array, "Your passwods do not match<br>");
    } else {
        if(preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, "Your password can only contain english characters or numbers<br>");
        }
    }

    if(strlen($password) > 30 || strlen($password) < 5) {
        array_push($error_array, "Your password must be between 5 and 30 characters<br>");
    } 

    //Encrypt password before sending to database
    if(empty($error_array)) {
        $password = md5($password);

    //Generate username by concatenating first name and last name
    $username = strtolower($fname . '_' . $lname);    

    //Check username for duplicates
    $u_check = mysqli_query($con, "SELECT username from users WHERE username = '$username'");
    
    $i = 0;
    while(mysqli_num_rows($u_check) != 0) {
        $i++;
        $username = $username . '_' . $i;
        $u_check = mysqli_query($con, "SELECT username FROM users WHERE username ='$username'");
    }

    //Profile picture assignment
    $rand = rand(1,2); //Random number between 1 and 2

    if($rand == 1)
         $profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
    else if($rand == 2)
         $profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";   
    
    $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no',',')"); 
    
    array_push($error_array, "<span style='color: #14c800'>Username registered succesfuly</span><br>");

    //Clear session variables
    session_unset();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Faces</title>
</head>
<body>
     <form action="register.php" method="POST">  <!--action = send form to "register.php" -->
        <!-- First Name -->
        <input type="text" name="reg_fname" placeholder="First Name" value="<?php 
            if(isset($_SESSION['reg_fname'])) {
                echo $_SESSION['reg_fname']; 
            };
        ?>
        " required>
        <br>       
        <?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "Your first name must be between 2 and 25 characters<br>"; ?>        
        <!-- Last Name -->
        <input type="text" name="reg_lname" placeholder="Last Name" value="<?php 
            if(isset($_SESSION['reg_lname'])) {
                echo $_SESSION['reg_lname']; 
            };
        ?>
        " required>
        <br>
        <?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) echo "Your last name must be between 2 and 25 characters<br>"; ?>
        <!-- Email         -->
        <input type="email" name="reg_email" placeholder="Email" value="<?php 
            if(isset($_SESSION['reg_email'])) {
                echo $_SESSION['reg_email']; 
            };
        ?>
        " required>
        <br>        
        <!-- Confirm Email     -->
        <input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php 
            if(isset($_SESSION['reg_email2'])) {
                echo $_SESSION['reg_email2']; 
            };
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
    </form>
</body>
</html>