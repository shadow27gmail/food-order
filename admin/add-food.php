<?php include('partials/menu.php'); ?> 

<div class="main-content">
    <div class="wrapper" >
      <h1>Add food item</h1>
        <br/>
        <form action="" method="POST" enctype="multipart/form-data"> 
            <table class="tbl-30 table-add-admin">

                <!-- Title  -->
                <tr>
                    <td class="text-prompt" width="80">Title </td>
                    <td><input type="text" name="title" 
                    placeholder="Food item title" class="text-input"></td>
                </tr>

                <!-- Description -->
                <tr>
                    <td class="text-prompt" width="80">Description </td>
                    <td>
                        <textarea name="description" cols="30" rows="3" 
                        class="text-area-input" placeholder="Food item description">
                        </textarea>
                    </td>
                </tr>

                <!-- Price -->
                <tr>
                    <td class="text-prompt" width="80">Price </td>
                    <td><input type="number" name="price" 
                     class="text-input"></td>
                </tr>

                <!-- Image -->
                <tr>
                    <td class="text-prompt" width="80">Add image </td>
                    <td><input type="file" name="image" class="btn-primary"> 
                   </td>
                </tr>

                <!-- Category -->
                <tr>
                    <td class="text-prompt" width="80">Category</td>
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
                                    $id = $row['id'];
                                    $title = $row['title'];

                                    ?>
                                    <option value="<?php echo $id; ?>">
                                        <?php echo $title; ?></option>
                                    <?php
                                }
                            }
                            else 
                            {
                                // we do not have active categories
                                ?>                                
                                <option value="0">No food category found</option>
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
                        <td width="80"><input type="radio" name="featured" value="yes"><p class="light-text">Yes</p>                    
                        <td width="80"><input type="radio" name="featured" value="no"><p class="light-text">No</p>
                        </table>
                    </td>
                </tr>

                <!-- Active -->
                <tr>
                    <td class="text-prompt">Active </td>
                    <td>
                        <table>
                            <td width="80">
                    <input type="radio" name="active" value="yes"><p class="light-text">Yes</p></td>
                    <td width="80">
                    <input type="radio" name="active" value="no"><p class="light-text">No</p></td>
                    </table></td>
                </tr>

                <!-- Submit button -->
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" name="submit" 
                        value="Add food item" class="btn-secondary btn-add-admin">  
                        <br />
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add data to database -->
        <?php
        if (isset($_POST['submit']))
        {
            // add the food item in the database
            // get data from form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            // check if radio button is checked (for active and featured)
            if (isset($_POST['featured'])) 
            {
                $featured = $_POST['featured'];
            } 
            else {
                $featured = "no";  // this is the defaault value
            }

            if (isset($_POST['active'])) 
            {
                $active = $_POST['active'];
            } 
            else {
                $active = "no";  // this is the defaault value
            }

            // upload the image (if one is selected)
            if (isset($_FILES['image']['name'])) 
            {
                // image is selected, get details
                $image_name = $_FILES['image']['name'];
                // upload image only if button was clicked and image have been selected
                if ($image_name != "") 
                {
                    // image is selected and is not cancelled
                    // rename the image. First, get the extension
                    // $ext = explode('.',$image_name);
                    $ext = substr($image_name,-3);                   

                    $image_name = "Food_Item_Name_" . rand(000, 999) . '.' . $ext;
                    // example name: Food_Item_Name_375.jpg        

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/food_item/" . $image_name;

                    //upload the image
        
                    $upload = move_uploaded_file($source_path, $destination_path);

                    // check if the image is uploaded
                    // if the image fails to upload, we redirect with an error message 
                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Upload failed</div>";
                        header("location:" . SITEURL . 'admin/add-food.php');
                        die();   // stop the process and not save to database
                    }

                }

            }
            else 
            {
                // image is not selected
                $image_name = "";
            }
            // insert data into DB

            // cretae the SQL query to insert data into DB
            // numeric values need not add quotation marks
            $sql2 = "INSERT into tbl_food SET 
                title='$title',
                description='$description',
                price=$price,
                image_name='$image_name',
                category_id=$category,
                featured='$featured',
                active='$active'
            ";

            // execute the query
            $res2=mysqli_query($conn,$sql2);
            // check if query succeeds
            if ($res2==true) 
            {
                // data inserted successfully
                $_SESSION['add'] = "<div class='success'>Food item added to the database</div>";                                
            }
            else 
            {
                // failed to insert data
                $_SESSION['add'] = "<div class='error'>Failed to add food item to the database</div>";                
            }
            // redirect with message to manage food             
            // header("location:".SITEURL.'admin/manage-food.php');
            echo "<script>
                window.location='http://localhost/food-order/admin/manage-food.php'
                </script>";

        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>