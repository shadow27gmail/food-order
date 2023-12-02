<?php include('partials/menu.php'); ?> 

<div class="main-content">
<div class="wrapper" >
        <h1>Add food category</h1>
        <br/><br/>

        <?php
        if (isset($_SESSION['add'])) 
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['upload'])) 
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        ?>
        <br/><br/>
        <!-- Add category form  -->
        <form action="" method="post" enctype="multipart/form-data">    
             <!-- multipart/form-data allows us to upload file   -->
            <table class="tbl-30 table-add-admin">
                <tr>
                    <td class="text-prompt">Title</td>
                    <td><input type="text" class="text-input"
                    name="title" placeholder="Category title"></td>
                </tr>
                <tr>
                    <td class="light-text">Select Image</td>
                    <td>
                        <input type="file" name="image" class="light-text">
                    </td>
                </tr>
                
                <tr>
                    <td class="light-text">Featured</td>                    
                    <td>                        
                        <table>
                        <td width="80"><input type="radio" name="featured" value="yes"><p class="light-text">Yes</p>                    
                        <td width="80"><input type="radio" name="featured" value="no"><p class="light-text">No</p>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="light-text">Active </td>
                    <td>
                        <table>
                            <td width="80">
                    <input type="radio" name="active" value="yes"><p class="light-text">Yes</p></td>
                    <td width="80">
                    <input type="radio" name="active" value="no"><p class="light-text">No</p></td>
                    </table></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" name="submit" 
                        value="Add category" class="btn-secondary btn-add-admin">  
                        <br />
                    </td>
                </tr>
            </table>            
        </form>

        <!-- Form ends here -->
        <?php 
        // check if submit button was clicked
        if (isset($_POST['submit'])) 
        {
            // 1. Get the value from form
            $title = $_POST['title'];
            // for radio input, check if the value is set
            if (isset($_POST['featured'])) {
              // radio is selected  
              $featured = $_POST['featured'];
            } else {
                // set the default value
                $featured = 'No';
            }

            if (isset($_POST['active'])) {
              // radio is selected  
              $active = $_POST['active'];
            } else {
                // set the default value
                $active = 'No';
            }

            // check if an image/file is selected and set the value for image_name accordingly
           
            if (isset($_FILES['image']['name'])) 
            {   
                // upload the image
                // we need image name 
                // source path and destination path
                $image_name = $_FILES['image']['name'];

                // check if image is selected before uploading
                if ($image_name != "") {

                    // auto rename the image **** added after image upload is working ****
        
                    // 1. Get the image's extension
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
                        header("location:" . SITEURL . 'admin/add-category.php');
                        die();   // stop the process and not save to database
                    }
                }  // image name is not blank

            } 
            else 
            {
                // do not upload image and set the image_name value as blank
                $image_name = "";
            }          

            // 2. Create SQL query to insert data into DB
        
            $sql = "INSERT INTO tbl_category set
            title='$title',
            image_name = '$image_name',
            featured='$featured',
            active='$active'";

            //3.  excute the query and save data in DB
            $res = mysqli_query($conn,$sql);
            // 4. check if the query succeeds
            if ($res == true) 
            {
                // Category added
                // set session message
                $_SESSION['add'] = "<div class='success'>Category added</div>";
                // redirect page to Manage Category
                header("location:" . SITEURL . 'admin/manage-category.php');
            } else 
            {
                // Failed to insert data into DB
                $_SESSION['add'] = "<div class='error'>Failed to add Category</div>";
                // redirect page to Add Category
                header("location:" . SITEURL . 'admin/add-category.php');
            }   



        } 
        
        ?>
        
    </div>
</div>

<?php include('partials/footer.php'); ?>