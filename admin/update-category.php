
<?php include('partials/menu.php'); ?>
    <div class="main-content">   
        
        <div class="wrapper">
            <h1>Update Food Category</h1>

            <br/><br/>
            <?php 
                if(isset($_GET['id'])) {
                    $id = $_GET['id'];
                    // echo "Id passed from calling URL";
                    // create query to get other details
                    $sql = "SELECT * from tbl_category WHERE id=$id";
                    // excute the query
                    $res = mysqli_query($conn,$sql);
                    // count returned rows (if any)
                    $count = mysqli_num_rows($res);
                    if ($count == 1) 
                    {
                        // get data from form
                        $row = mysqli_fetch_assoc($res);
                        $title = $row['title'];                        
                        $current_image = $row['image_name'];
                        $featured = $row['featured'];   
                        $active = $row['active'];   
                        
                    } 
                    else 
                    {
                        // there was an error as there should only be one row returned (or nothing)
                        // redirect to manage category page
                        $_SESSION['no-category-found'] = "<div class='error'>Cannot find category</div>";
                        header("location:".SITEURL.'admin/manage-category.php');
                    }
                } 
                else 
                {
                    // redirect to Manage Category page
                    $_SESSION['upload'] = "<div class='error'>Upload failed</div>";
                    header("location:".SITEURL.'admin/manage-category.php');
                }
            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <table class="tbl-30 table-add-admin">
                    <tr>
                        <td class="text-prompt">Title</td>
                        <td><input type="text" class="text-input"
                        name="title" 
                        placeholder="Category title" 
                        value="<?php echo $title; ?>"></td>
                    </tr>
                    <tr>
                        <td class="light-text">Current Image</td>
                        <td>
                            <?php
                            if ($current_image != "") {
                                // image name is not empty?
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image;?> " width="150px">
                                <!-- remove forward slash before images -->
                                <?php

                            } 
                            else 
                            {
                                // just display that the image is not available                                
                                echo "<div class='error'>Image not added.</div>";
                            }

                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="light-text">New Image</td>
                        <td>
                            <input type="file" name="image" class="light-text">
                        </td>
                    </tr>
                    <!-- Radio Buttons -->
                    <tr>
                        <td class="light-text">Featured</td>                    
                        <td>                        
                            <table>
                                <td width="80">                                
                                    <input <?php if ($featured == "yes") {echo "checked";}?> 
                                    type="radio" name="featured" value="yes">
                                    <p class="light-text">Yes</p>                    
                                    <td width="80">
                                    <input <?php if ($featured == "no") {echo "checked";}?> type="radio" name="featured" value="no">
                                    <p class="light-text">No</p>
                                </td>
                            </table>
                        </td>
                        
                    </tr>
                
                    <tr>
                        <td class="light-text">Active </td>
                        <td>
                            <table>
                                <td width="80">
                                    <input <?php if ($active == "yes") {echo "checked";}?> 
                                    type="radio" name="active" value="yes">
                                    <p class="light-text">Yes</p>
                                </td>
                                <td width="80">
                                    <input <?php if ($featured == "no") {echo "checked";}?> 
                                    type="radio" name="active" value="no">
                                    <p class="light-text">No</p>
                                </td>
                            </table>
                        </td>
                    </tr>
                    <!-- Button to update -->
                    <tr>
                        <td colspan="2" align="center">                            
                            <input type="hidden" name="current_image" 
                            value="<?php echo $current_image; ?>">
                            <input type="hidden" name="id" value="<?php echo $id?>">
                            <input type="submit" name="submit" 
                            value="Update category" 
                            class="btn-secondary btn-add-admin">  
                            <br />
                        </td>
                    </tr>
                </table>
            </form>

            <!-- Checked if button was clicked  -->
            <?php 
            if (isset($_POST['submit'])) {
                // process the form
                $title = $_POST['title'];
                $id = $_POST['id'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];           

                // updating the image if selected
                if (isset($_FILES['image']['name'])) 
                {
                    // get the image details
                    $image_name = $_FILES['image']['name'];                  
                  
                    if ($image_name != "") 
                    {
                        // upload the new image
                        // $ext = end(explode('.', $image_name));
                        $ext = substr($image_name,-3);
                        // 2. rename the image
                        $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;
                        // example name: Food_Category_375.jpg
            
    
                        $source_path = $_FILES['image']['tmp_name'];
    
                        $destination_path = "../images/category/" . $image_name;
    
                        //upload the image
            
                        $upload = move_uploaded_file($source_path, $destination_path);
    
                        // check if the image is uploaded
                        // if the image fails to upload, we redirect with an error message 
                        if ($upload == false) {
                            $_SESSION['upload'] = "<div class='error'>Upload failed</div>";
                            header("location:" . SITEURL . 'admin/manage-category.php');
                            die();   // stop the process and not save to database
                        }
                        // remove the current image
                        $remove_path="../images/category/".$current_image;
                        $remove = unlink($remove_path);
                        echo $remove_path;

                        // check if the image is removed
                        // display an error if  the rmove fails
                        if ($remove == false) 
                        {
                            $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image</div>";
                            header("location:".SITEURL.'admin/manage-category.php');
                            die();   // stop the process and not save to database
                        }

                    }
                    else 
                    {                     
                        $image_name = $current_image;    
                    }  // image name is not blank
                   
                } 
                else 
                {
                    // no change in image
                    $image_name = $current_image;
                }
                

                // update the database
                $sql2 = "UPDATE tbl_category SET title = '$title', 
                image_name = '$image_name',
                featured='$featured', active='$active' WHERE id=$id" ;

                // excute the query
                $res2 = mysqli_query($conn, $sql2);
                
                // check if query executed
                if ($res2==true) 
                {
                    // category updated
                    $_SESSION['update'] = "<div class='success'>Category Updated</div>";  
                }
                else 
                {
                    // failed to update category
                    $_SESSION['update'] = "<div class='error'>Category Update Failed</div>";
                }
                // redirect to Manage Category with messsage 
                // header('location:'.SITEURL.'admin/manage-category.php');
                echo "<script>
                window.location='http://localhost/food-order/admin/manage-category.php'
                </script>";
                // we try JavaScript
            }
        ?>
            
        </div>     
    </div>
    

<?php include('partials/footer.php'); ?>
