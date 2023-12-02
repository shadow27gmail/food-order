<?php 
    include('../config/constants.php'); 
    include('login-check.php');
?>

<html>
    <head>
        <title>Food Order Website - Home Page</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <!-- Menu section start-->
        <div class="menu text-center">
            <div class="wrapper">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="manage-admin.php">Admin</a></li>
                    <li><a href="manage-category.php">Categories</a></li>
                    <li><a href="manage-food.php">Meals</a></li>
                    <li><a href="manage-order.php">Orders</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            
        </div>

