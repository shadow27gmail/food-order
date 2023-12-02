<?php include('partials\menu.php')?>
<div class="main-content">
        <div class="wrapper">
            <h1>Manage Meal Items</h1>

            <br />
            <?php
            if (isset($_SESSION['upload'])) 
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            if (isset($_SESSION['add'])) 
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            
            if (isset($_SESSION['deleted'])) 
            {
                echo $_SESSION['deleted'];
                unset($_SESSION['deleted']);
            }

            if (isset($_SESSION['update'])) 
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if (isset($_SESSION['delete-food-item'])) 
            {
                echo $_SESSION['delete-food-item'];
                unset($_SESSION['delete-food-item']);
            }

            if (isset($_SESSION['remove-current'])) 
            {
                echo $_SESSION['remove-current'];
                unset($_SESSION['remove-current']);
            }
            ?>
            </br>
           <!--Button to add food item -->
           <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary"><i class="fa-solid fa-bowl-rice fa-beat"></i>&nbsp;&nbsp;&nbsp; Add meal item</a>
           <br /> <br /> <br />
           <table class="tbl-full">
            <tr>
              <th>Number</th>
              <th>Title</th>
              <th>Price</th>
              <th>Image</th>
              <th>Featured</th>
              <th>Active</th>
              <th>Actions</th>
            </tr>

            <!-- Populate the list with actual data from food item table -->
            <?php
                // create an SQL query
                $sql = "SELECT * FROM tbl_food";
                // execute the query
                $res = mysqli_query($conn, $sql);
                // count retruned rows (if any)
                $count = mysqli_num_rows($res);
                if ($count > 0) {
                    // we have food items in DB
                    $sn = 1;        // series number (just a number)
                    while ($row = mysqli_fetch_assoc($res)) 
                    {
                        // get all data i+n array format
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        // display values in table row
                        ?>
                        <tr>                        
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo '<b>'.$title.'</b>'; ?></td>
                            <td><?php echo '<b>PH '.$price.'</b>'; ?></td>
                            <td>                            
                                <?php 
                                        // check if image has been uploaded
                                        if ($image_name!="") {
                                            // image name is not empty?
                                            ?>
                                            <img src="<?php echo SITEURL ?>images/food_item/<?php echo $image_name;?>" class="category-img-display">
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
                                <!-- Update Food Item -->
                                <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-secondary">Update meal item</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete meal item</a>                        
                            </td>
                        </tr>
                        <?php
                        
                    }
                } 
                else
                {
                    // no food item data in DB
                    echo "<tr><td colspan='7' class='error'>No food item data in database yet.</td></tr>";
                }
            ?>
                                                                      
            
           </table>
        </div>        
</div>

<?php include('partials\footer.php')?>