<?php 
    // include constants.php
    include('../config/constants.php');
    // 1. remove all sessions
    session_destroy();
    // 2. Redirect to login page
    header("location:".SITEURL.'admin/login.php');
?>