<?php include('partials\menu.php')?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Meal Categories</h1>

            <br />

            <?php
            if (isset($_SESSION['add'])) 
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if (isset($_SESSION['remove'])) 
            {
                echo $_SESSION['remove'];
                unset($_SESSION['remove']);
            }

            if (isset($_SESSION['deleted'])) 
            {
                echo $_SESSION['deleted'];
                unset($_SESSION['deleted']);
            }
            if (isset($_SESSION['no-category-found'])) 
            {
                echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']);
            }
            if (isset($_SESSION['update'])) 
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            if (isset($_SESSION['upload'])) 
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            if (isset($_SESSION['remove-failed'])) 
            {
                echo $_SESSION['remove-failed'];
                unset($_SESSION['remove-failed']);
            }

            ?>
           <br /> 
           <!--Button to add admin -->
           <a href="<?php echo SITEURL.'admin/add-category.php'?>" class="btn-primary"><i class="fa-solid fa-mug-saucer fa-beat"></i> - Add Meal Category</a>
           <br /> <br /> <br />
           <table class="tbl-full">
            <tr>
                <th>Number</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>                
            </tr>

            <!-- get value from DB -->
            <?php            
                // query the database and get everything
                $sql = "SELECT * FROM tbl_category";
                // execute the query
                $res = mysqli_query($conn,$sql);
                // count returned rows (if any)
                $count = mysqli_num_rows($res);
                $sn = 1;
                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) 
                    {
                        $id = $row['id'];                        
                        $title = $row['title'];                        
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active']; 
                        // break the PHP
                        ?>
                        <!-- This way we can write HTML in between PHP code -->
                        <tr>
                            <td><?php echo $sn++; ?></td>                                       
                            <td><?php echo '<b>'.$title.'</b>'; ?></td>    
                            <!-- Try to display the uploaded image -->
                            <td>
                                <?php 
                                    // check if image has been uploaded
                                    if ($image_name!="") {
                                        // image name is not empty?
                                        ?>
                                        <img src="<?php echo SITEURL ?>images/category/<?php echo $image_name;?>" class="category-img-display">
                                        <!-- remove / from images -->
                                        <?php

                                    } 
                                    else 
                                    {
                                        // just display that the image is not available
                                        echo "<div class='error'>No image available.</div>";
                                    }
                                 ?>
                            </td>

                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <!-- Update Category -->
                                <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?> " class="btn-secondary">Update Category</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?> " class="btn-danger">Delete Category</a>                        
                            </td>                                                          
                        </tr>       

                        <!-- and start PHP again -->
                        <?php

                    }
                } 
                else 
                {
                    // no rows returned 
                    // display message inside the table. Break PHP, and re-start it
                    ?>

                    <tr>
                        <td colspan="6" align="center"><div class='error'>No categories added</div></td>
                    </tr>    

                    <?php 

                    
                }    
            ?>                  

           </table>
        </div>        
    </div>

<?php include('partials\footer.php')?>