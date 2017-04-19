<?php
    // log user out by unsetting session variable called email, and destroying the session
    
    session_start();
    /*if (isset($_SESSION['orderid'])) {
        unset($_SESSION['orderid']);
    }*/
    session_destroy();
    
    // redirect user to login page
    header("Location: index.php");
    exit;
?>