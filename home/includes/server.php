<?php 
//check if user is logged in
if(empty($_SESSION['email']) || !isset($_SESSION['email'])){

    setcookie("msg","Login to continue", time() + 200, "/");
    header('location: ../login.php');
}

//logout user

if(isset($_GET['logout'])){
    //log the user out and destroy the session
    session_destroy();
    header('location: ../login.php');    
}

?>