<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br /><br />

        <?php 
            if (isset($_GET['id'])) 
            {
                $id = $_GET['id'];
            } 
        ?>
        <form action="" method="post">
            <table class="tbl-30 table-add-admin">
                <!-- Current Password -->
                <tr>
                    <td><div class="text-prompt">Current Password</div></td>
                    <td><input type="password" name="current_password" placeholder="Current password" class="text-input"></td>
                </tr>
                <!-- New Password -->
                <tr>
                    <td><div class="text-prompt">New Password</div></td>
                    <td><input type="password" name="new_password" placeholder="New password" class="text-input"></td>
                </tr>
                <!-- Confirm Password -->
                <tr>
                    <td><div class="text-prompt">Confirm Password</div></td>
                    <td><input type="password" name="confirm_password" placeholder="Confirm password" class="text-input"></td>
                </tr>
                <!-- Button to effect the update -->

                <tr>
                    <td colspan="2">
                        <br /> <br />
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Submit Changes" class="btn-secondary btn-add-admin">
                        <br />
                        </td>
                </tr>
            </table>
        </form>
    </div>
</div>


<?php include('partials/footer.php'); ?>

<!-- Check if change password button got clicked -->

<?php
    // check if submit button was clicked

    if (isset($_POST['submit'])) 
    {
        // echo 'Submit button clicked';
        // get data from form
        $id= $_POST['id'];
        $current_password=md5($_POST['current_password']);
        $new_password=md5($_POST['new_password']);
        $confirm_password=md5($_POST['confirm_password']);

        // check if the current password is correct
        $sql = "SELECT * from tbl_admin WHERE id = $id AND password = '$current_password'";
        // id is an integer value so single quote is not nescessary. password is a string value, hence, the single quote
        
        // execute the query
        $res = mysqli_query($conn,$sql);
        if ($res == true) 
        {
            // check if data is available
            $count  = mysqli_num_rows($res);
            if ($count == 1) 
            {
                // user is confirmed to be in DB. Password CAN be changed

                // check if new password and confirm password matches
                if ($new_password == $confirm_password) 
                {
                    // echo "Password matches";
                    // update database record to effect change
                    // create another SQL query to update password
                    $sql2 = "UPDATE tbl_admin SET password = '$new_password' WHERE id=$id";
                    // execute the query
                    $res2 = mysqli_query($conn,$sql2);
                    if ($res2 == true) 
                    {
                        $_SESSION['password-changed'] = "<div class='success'>Password changed!</div>";                        
                        header("location:" . SITEURL . 'admin/manage-admin.php');
                    } else {
                        $_SESSION['password-changed'] = "<div class='error'>There was an error.</div>";                        
                        header("location:" . SITEURL . 'admin/manage-admin.php');
                    }
                }
                else {
                    $_SESSION['password-did-not-match'] = "<div class='error'>Passwords did not match</div>";
                    // redirect to manage admin page
                    header("location:" . SITEURL . 'admin/manage-admin.php');
                }
                
            } 
            else 
            {
                $_SESSION['user-not-found'] = "<div class='error'>Invalid Credentials!</div>";
                // redirect to manage admin page
                header("location:" . SITEURL . 'admin/manage-admin.php');
            }
        }
        
    }
?>