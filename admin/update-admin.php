
<?php include('partials/menu.php'); ?>
    <div class="main-content">   
        <div class="wrapper">
            <h1>Update Admin Details</h1>
            <br/> <br/>

            <!-- get administrator details -->
            <?php 
                // get selected ID
                $id = $_GET['id'];
                // create SQL query to get details
                $sql = "SELECT * FROM tbl_admin WHERE id=$id";
                // execute the query
                $res = mysqli_query($conn,$sql);

                // check for query success
                if ($res == TRUE) {
                    // check if data is available
                    $count = mysqli_num_rows($res);
                    // check if database has data
                    if ($count ==1 ) {
                        // get the details from db fields
                        // echo "Gotten admin details";                        
                        $row = mysqli_fetch_assoc($res);
                        $full_name = $row['full_name'];
                        $username = $row['username'];

                    } else {
                        // redirect to manage admin page
                    header("location:" . SITEURL . 'admin/manage-admin.php');
                    }
                }
            
            ?>

            <form action="" method="post">
                <!-- <br /> <br /> -->
                <table class="tbl-30 table-add-admin">
                    <tr>
                        <td width=200><div class='text-prompt'>Full Name</div></td>
                        <td><input type="text" name="full_name" class="text-input" value="<?php echo $full_name; ?>"></td>
                    </tr>
                    <tr>
                        <td width=200><div class='text-prompt'>UserName</div></td>
                        <td>
                        <input type="text" name="username" class="text-input" 
                        value="<?php echo $username; ?>"></td>
                    </tr>                

                    <tr>
                        <td colspan=2>
                            <br /> <br />
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Update Details" class="btn-secondary btn-add-admin">
                            <br />
                        </td>
                    </tr>
                </table>
            </form>
        </div>     
    </div>
    
<?php
// if submit button is clicked, we update admin details

if (isset($_POST['submit'])) 
{
    // echo "Button clicked";
    // get values from form to update
    $id        = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username  = $_POST['username'];

    //create SQL query to udpate values in DB
    $sql = "UPDATE tbl_admin SET full_name = '$full_name', username = '$username' WHERE id = '$id' ";
    // execute the query
    $res = mysqli_query($conn,$sql);

    if ($res == TRUE) 
    {
        // query succeed
        $_SESSION['update'] = "<div class='success'>Details Changed.</div>";
        // redirect to Manage Admin page
        header("location:" . SITEURL . 'admin/manage-admin.php');
    }
    else 
    {
        // query failed
        $_SESSION['update'] = "<div class='error'>Update failed!</div>";
    }

}
 ?>
<?php include('partials/footer.php'); ?>
