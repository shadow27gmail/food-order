<?php 
    // authorization or access control
    // check if the user is logged in
    if (!isset($_SESSION['user'])) 
    {   
        // user is not logged in
    $_SESSION['not-logged-on'] = "<div class='error'>Not authorized. Please login.</div>";
        // redirect to login page
        header("location:".SITEURL.'admin/login.php');
    }

?>