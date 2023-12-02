
<?php include('partials/menu.php'); ?>
<?php 
    // check if Id was passed from calling URL
if (isset($_GET['id'])) 
{
    // get details from DB
    $id = $_GET['id'];
    // create query to get selected food details
    // $sql2 because $sql has already been used when fetching category values
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
    // execute the query
    $res2 = mysqli_query($conn,$sql2);
    // get the value from query result into an array
    $row2 = mysqli_fetch_assoc($res2);
    // get individual fields
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
    // value obtained, now display in form       
}
else 
{
    // ID not set, redirect to manage food details page
    header("location:" . SITEURL . 'admin/manage-food.php');
}

?>
    <div class="main-content">           
        <div class="wrapper">
            <h1>Update meal item details</h1>
            <br/>          
            <form action="" method="post" enctype="multipart/form-data">
                <table class="tbl-30 table-add-admin">
                      <!-- Title  -->
                    <tr>
                        <td class="text-prompt" width="80">Title </td>
                        <td><input type="text" name="title" value="<?php echo $title ?>" class="text-input"></td>
                    </tr>

                    <!-- Description -->
                    <tr>
                        <td class="text-prompt" width="80">Description </td>
                        <td>
                            <textarea name="description" cols="30" rows="3" 
                            class="text-area-input"><?php echo $description ?>
                            </textarea>
                        </td>
                    </tr>

                    <!-- Price -->
                    <tr>
                        <td class="text-prompt" width="80">Price </td>
                        <td><input type="number" name="price" 
                        class="text-input" value="<?php echo $price ?>"></td>
                    </tr>

                    <!-- Current Image -->
                    <tr>
                        <td class="text-prompt" width="80">Current Image </td>
                        <td>
                            <?php
                            if ($current_image=="") {
                                echo "<div class='error'>No image available</div>";
                            } else {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food_item/<?php echo $current_image;?>" class="category-img-display" alt="<?php echo $title; ?>">    
                                <?php
                            }
                            ?>                                
                        </td>
                    </tr>

                    <!-- Select new Image -->
                    <tr>
                        <td class="light-text">Select new Image</td>
                        <td>
                            <input type="file" name="image" class="light-text btn-primary">
                        </td>
                    </tr>

                    <!-- Category -->
                    <tr>
                        <td class="text-prompt">Category</td>
                        <td>
                            <select name="category" class="select-text-prompt">
                                 <!-- Get Category from database -->
                                <?php
                                // create SQL query to get all active categories
                                $sql = "SELECT * FROM tbl_category WHERE active='yes'";
                                // execute the query
                                $res = mysqli_query($conn,$sql);
                                // count returned rows (if any)
                                $count = mysqli_num_rows($res);
                                // check for count >0
                                if ($count > 0) {
                                    // we have active categories
                                    // loop thru categories
                                    while ($row = mysqli_fetch_assoc($res)) 
                                    {
                                        // get category details
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];
                                        // echo "<option value='$category_id'>$category_title</option>";
                                        ?>
                                        <!-- drop down uses selected. radio uses checked -->
                                        <option <?php if ($current_category == $category_id) {
                                            echo "selected";}?> value="<?php echo $category_id; ?>">
                                        <?php echo $category_title; ?></option>
                                        <?php
                                        
                                    }
                                }
                                else 
                                {
                                    // we do not have active categories
                                    ?>                                
                                    <option value="0">No meal category found</option>
                                    <?php
                                }                   
                                // display values (from DB) to the dropdown
                                ?>         
                            </select>
                        </td>
                    </tr>

                     <!-- Featured -->
                    <tr>
                        <td class="text-prompt">Featured</td>                    
                        <td>                        
                            <table>
                            <td width="80">
                                <input <?php if ($featured == "yes") {echo "checked";}?> type="radio" name="featured" value="yes">
                                <p class="light-text">Yes</p>                    
                            </td>
                            <td width="80">
                                <input <?php if ($featured == "no") {echo "checked";}?> type="radio" name="featured" value="no">
                                <p class="light-text">No</p>
                            </td>
                            </table>
                        </td>
                    </tr>

                    <!-- Active -->
                    <tr>
                        <td class="text-prompt">Active </td>
                        <td>
                            <table>
                                <td width="80">
                                    <input <?php if ($active == "yes") {echo "checked";}?> 
                                    type="radio" name="active" value="yes">
                                    <p class="light-text">Yes</p>
                                </td>

                                <td width="80">
                                    <input <?php if ($active == "no") {echo "checked";}?> 
                                    type="radio" name="active" value="no">
                                    <p class="light-text">No</p>
                                </td>
                        </table></td>
                    </tr>

                    <!-- Submit button -->
                    <tr>
                        <td colspan="2" align="center">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="submit" name="submit" 
                            value="Update details" class="btn-secondary btn-add-admin">  
                            <br />
                        </td>
                    </tr>
                </table>
            </form>        
            
            <?php 
                // check if submit button is checked
                if (isset($_POST['submit'])) 
                {                    
                    // get all values from form
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $current_image = $_POST['current_image'];
                    $category = $_POST['category'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];                    

                    // remove the current image (if it exist) and upload the new image

                    // upload the image if selected

                    // check if upload button was clicked
                    if (isset($_FILES['image']['name'])) 
                    {
                        $image_name = $_FILES['image']['name']; // new image name
                
                        // check if file is available
                        if ($image_name != "") 
                        {
                            // image is available
                            // $ext = end(explode('.', $image_name));
                            $ext = substr($image_name, -3);
                            // get extension
                
                            // rename the image
                            $image_name = "Food_Item_Name_" . rand(000, 999) . '.' . $ext;
                            // example name: Food_Item_Name_375.jpg        
                
                            $source_path = $_FILES['image']['tmp_name'];
                            $destination_path = "../images/food_item/" . $image_name;
                            //upload the image        
                            $upload = move_uploaded_file($source_path, $destination_path);

                            // check if upload is successfull
                
                            if ($upload == false) {
                                // upload failed
                                $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                                // redirect to manage food 
                                header("location:" . SITEURL . 'admin/manage-food.php');
                                die();           // stop the process to prevent updates to the database
                            }

                            // remove current image if one is present
                            if ($current_image != "") {
                                // current_image exist. Not all entries have image                            
                                $remove_path = "../images/food_item/" . $current_image;
                                $remove = unlink($remove_path);    // effect the deletion
                                if ($remove == false) {
                                    $_SESSION['remove-current'] = "<div class='error'>Failed to remove current image</div>";
                                    // redirect to manage food 
                                    // header("location:" . SITEURL . 'admin/manage-food.php');
                                    echo "<script>                                    
                                            window.location='http://localhost/food-order/admin/manage-food.php'
                                    </script>";
                                    die();
                                }

                            }

                        }
                        else
                        {
                            $image_name = $current_image;
                        // image not changed
                        } 
                    } 
                    else
                    {
                        $image_name = $current_image;
                        // image not changed
                    } 
                    
                    // update food details in the database...
                    // create the query
                    $sql3 = "UPDATE tbl_food SET
                        title='$title',
                        description='$description',
                        price=$price,
                        image_name='$image_name',
                        category_id='$category',
                        featured='$featured',
                        active='$active'
                        WHERE id=$id";
                    // execute the query
                    $res3 = mysqli_query($conn, $sql3);
                    // check for query success
                    if ($res3==true) {
                        // query executed
                        $_SESSION['update'] = "<div class='success'>Food item details updated</div>";
                        echo "<script>
                            window.location='http://localhost/food-order/admin/manage-food.php'
                        </script>";
                    }
                    else 
                    {
                        // query failed
                        $_SESSION['update'] = "<div class='error'>Food item details not updated</div>";
                        echo "<script>
                            window.location='http://localhost/food-order/admin/manage-food.php'
                        </script>";
                    }
                    // redirect to manage food page with success message
                    // header("location:". SITEURL .'admin/manage-food.php' );                    
                }
            ?>
        </div>     
    </div>
    

<?php include('partials/footer.php'); ?>
