<?php
    session_start();

    if(isset($_POST['Logout'])){
       
        $_SESSION = array(); //Unset all of the session variables
        session_destroy(); //Destroy the session
        echo '<script>alert("Account has logged out");</script>';
        echo '<script>window.location.href="Login.php";</script>'; //Redirect to the login page when logout
        exit();
    }   
?>