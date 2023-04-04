<?php

if(isset($_POST['login_button'])) {
    $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); //check if email is in correct format
    
    $_SESSION['log_email'] = $email; //store email into session variable

    $password = md5($_POST['log_password']); //get and encrypt password

    $check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' AND password = '$password'");
    $check_login_query = mysqli_num_rows($check_database_query); // counts the number of rows returned (should be 0 or 1)

    if($check_login_query == 1) {
        $row = mysqli_fetch_array($check_database_query); //access the result of the query and store them as an array inside the $row variable
        $username = $row['username']; //we can access each column of the query

        $user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND user_closed='yes'"); //make a query and fetch the row with email=$email and user_closed = yes
        if(mysqli_num_rows($user_closed_query) == 1) {
            $reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE email='$email'"); // update user_closed=no
        }

        $_SESSION['username'] = $username; //creates a new SESSION variable called 'username' and sets it to #$username 
        header("Location: index.php");
        exit();
    } else {
        array_push($error_array, "Email or password incorrect<br>"); //push the error message to the error array
    }
}

?>