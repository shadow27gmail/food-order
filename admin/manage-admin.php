<?php include('partials/menu.php'); ?>
    <div class="main-content">
        <div class="wrapper">
           <H1>Manage Administrators</H1>  
           <br /> <br /> 

           <?php 
                if (isset($_SESSION['add'])) 
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if (isset($_SESSION['delete'])) 
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }

                if (isset($_SESSION['update'])) 
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }

                if (isset($_SESSION['user-not-found'])) 
                {
                    echo $_SESSION['user-not-found'];
                    unset($_SESSION['user-not-found']);
                }

                if (isset($_SESSION['password-did-not-match'])) 
                {
                    echo $_SESSION['password-did-not-match'];
                    unset($_SESSION['password-did-not-match']);
                }
                if (isset($_SESSION['password-changed'])) 
                {
                    echo $_SESSION['password-changed'];
                    unset($_SESSION['password-changed']);
                }
           ?>
           <br />
           <!--Button to add admin -->
           <a href="add-admin.php" class="btn-primary"> <i class="fa-solid fa-user fa-beat"></i></i>&nbsp;&nbsp;&nbsp;Add Administrator</a>
           <br /> <br /> <br />
           <table class="tbl-full">
            <tr>
              <th>Number</th>
              <th>Full Name</th>
              <th>User Name</th>
            <th>Actions</th>                
            </tr>

            <?php
            // get data from admin table
            $sql = "SELECT * FROM tbl_admin";   // define query
            $res = mysqli_query($conn, $sql);   // execute
            // check for query success
            if ($res == TRUE) 
            {
                // count rows to check whether we have data in database
                $count = mysqli_num_rows($res);   // function to get number of returned rows
                $sn = 1;
                if ($count > 0 )   
                {
                    // we have admins added. let's get em into variables
                    while ($rows = mysqli_fetch_assoc($res)) 
                    {
                        $id = $rows['id'];
                        $full_name= $rows['full_name'];
                        $username = $rows['username'];

                        // display values in a table
                        ?>   
                         <tr>
                            <td><?php echo $sn++; ?></td>     
                            <td><b><?php echo $full_name; ?></b></td>                                       
                            <td><i class="fa-solid fa-user"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php echo $username; ?></td>
                            <td>
                                <!-- Update Admin -->
                                <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>

                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Details</a>
                                
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>                        
                            </td>                                                          
                        </tr>

                        <?php
                            
                       

                    }
                } else 
                {
                    // admins are still missing in action
                }

            }

            ?>              

           </table>
            
        </div>
        <!-- Main content section start-->
        <!-- Main content section ends-->
        
<?php include('partials/footer.php'); ?>