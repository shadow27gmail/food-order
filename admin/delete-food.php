<?php
    include('../config/constants.php');

    // check if id and image_name was set from calling URL
    if (isset($_GET['id']) AND isset($_GET['image_name'])) 
    {
        // get the value and delete    
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];
        // remove the physical image file if available
        if ($image_name !="") 
        {   
            // image is available
            $path = "../images/food_item/".$image_name;           
            
            // remove the image
            $remove = unlink($path);
            // if remove fails then show error message and stop processing
            if ($remove==false) 
            {
                // set the session message
                $_SESSION['upload'] = "<div class='error'>Failed to remove image</div>";            
                // redirect to Manage Food page
                header("location:".SITEURL.'admin/manage-food.php');
                // stop the process if delete fails
                die();  
            }
        }

        // then delete data from DB
        $sql = "DELETE from tbl_food WHERE id=$id";
        // execute the query
        $res = mysqli_query($conn,$sql);
        // check if query succeeds
        if ($res == true) 
        {
            // display delete confirmed message and redirect to Manage Food
            $_SESSION['deleted'] = "<div class='success'>Food item deleted</div>";
        } else
        {
            $_SESSION['deleted'] = "<div class='error'>Could not delete food item</div>";        
        }
        header("location:".SITEURL.'admin/manage-food.php');
    }
    else 
    {
        // display error message
        $_SESSION['delete-food-item'] = "Access Denied.";
        // redirect to Manage food page
        header("location:" . SITEURL . 'admin/manage-food.php');    
    }

?>