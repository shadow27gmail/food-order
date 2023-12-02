<?php include('partials/menu.php'); ?>
    <div class="main-content">        
        <div class="wrapper">
            <h1>Add Administrator</h1>
            <br /><br />
            <form action="" method="post">
                <table class="tbl-30 table-add-admin">
                    <tr>
                        <td><div class='text-prompt'>Full Name</div></td>
                        <td><input type="text" name="full_name" placeholder="Full Name" class="text-input"></td>
                    </tr>
                    <tr>
                        <td><div class='text-prompt'>UserName</div></td>
                        <td><input type="text" name="username" placeholder="User Name" class="text-input"></td>
                    </tr>

                    <tr>
                        <td><div class='text-prompt'>Password</div></td>
                        <td><input type="password" name="password" placeholder="Password" class="text-input"></td>
                    </tr>

                    <tr>
                        <td colspan=2 halign="center">
                            <br /> <br />
                            <input type="submit" name="submit" value="Add Admin" class="btn-secondary btn-add-admin">
                            <br />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php include('partials/footer.php'); ?>

<?php   
    // process the value from from and save it in the database
    // check whether the sub,it button is clicked 

if (isset($_POST['submit'])) 
{
     // button clicked
    // echo "Button clicked";

    // get the data from form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    // password encrypted with md5

    // create SQL query to save data into database

    $sql = "INSERT INTO tbl_admin SET
        full_name = '$full_name',
        username = '$username',
        password= '$password' 
    ";

    // execute query to save data in database

    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    // check if data is successfully inserted

    if ($res==TRUE) 
    {
        // echo "Data successfully inserted";
        //create a variable to display message

        $_SESSION['add'] = "<div class='success'>Administrator added successfully</div>";
        // redirect page to manage admin
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else 
    {
        // echo "There was an error";

        $_SESSION['add'] = "<div class='error'>Failed to add Administrator.</div>";
        // redirect page to add admin page
        header("location:".SITEURL.'admin/add-admin.php');
    }
    
} 

?> 