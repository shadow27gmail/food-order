<?php include('../config/constants.php')?>
<html>
    <head>
        <title>Login - Food Ordering System</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <div class="login login-bg" >
            <h1><img src="../images/logo.png"></h1>
            <br/>
            <h1 class="text-center">Login &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-lock"></i></h1> 
            
            <?php
                if (isset($_SESSION['login'])) {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
            ?>
            <?php
                if (isset($_SESSION['not-logged-on'])) {
                    echo $_SESSION['not-logged-on'];
                    unset($_SESSION['not-logged-on']);
                }
            ?>
            <br/> <br/>
            <!-- Create a simple form -->
            <form action="" method="post">
                <table>
                    <tr>
                        <td>
                            <table>
                                <td width="30"><i class="fa-solid fa-user fa-xl"></i></td>
                                <td><div class="text-prompt">User Name</div></td>
                                
                            </table>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>                            
                            <input type="text" name="username" placeholder="UserName" class="text-input"><br/>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <table>
                                <td width="30"><i class="fa-solid fa-key fa-xl"></i></td>
                                <td><div class="text-prompt">Password</div></td>
                            </table>                        
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" name="password" placeholder="Password" class="text-input">
                            <br/><br/><br/>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <input type="submit" name="submit" 
                            value="Login" class="btn-primary btn-add-admin">
                        </td>
                    </tr>
                
                </table>
            </form>
            <!-- Form ends -->
            <br/><br/>
            <p class="text-center">Created by <a href="#">BSIT 2nd year 2023</a></p>
        </div>
    </body>
</html>


<!-- Add functionality -->
<?php  
    // check if submit button was clicked
if (isset($_POST['submit'])) {
    // process login
    // 1. Get the data from login form
    $username = $_POST['username'];
    $password = $_POST['password'];
    // 2. create the SQL query to check if the typed values matches those in the DB

    $sql = "SELECT * from tbl_admin WHERE username='$username' AND password=md5('$password')";
    // 3. Execute the query
    $res = mysqli_query($conn, $sql);

    // 4. Check if user exist
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        // user is in db        
        $_SESSION['login'] = "<div class='success'>Login Successful</div>";
        $_SESSION['user'] = $username;   // this will only be unset when we log out
        // Login Successful. Redirect to home page
        header("location:".SITEURL.'admin/');

    }
    else {
        // user does not exist        
        $_SESSION['login']="<div class='error'>Invalid Credentials!</div>";
        // Login failed. redirect to the same page
        header("location:".SITEURL.'admin/login.php');
        

    }
}
?>