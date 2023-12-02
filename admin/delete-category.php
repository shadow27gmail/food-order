<?php
    include('../config/constants.php');

    // check if id and image_name was set from calling URL
if (isset($_GET['id']) AND isset($_GET['image_name'])) 
{
    // get the value and delete
    // echo "Get value and delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    // remove the physical image file if available
    if ($image_name !="") 
    {   
        // image is available
        $path = "../images/category/".$image_name;
        // remove the image
        $remove = unlink($path);
        // if remove fails then show error message and stop processing
        if ($remove==false) 
        {
            // set the session message
            $_SESSION['remove'] = "<div class='error'>Failed to remove image</div>";
            
            // redirect to Manage Category page
            header("location:".SITEURL.'admin/manage-category.php');
            die();
        }

    }

    // then delete data from DB
    $sql = "DELETE from tbl_category WHERE id=$id";
    // execute the query
    $res = mysqli_query($conn,$sql);
    // check if query succeeds
    if ($res == true) 
    {
        // display delete confirmed message and redirect to Manage Category
        $_SESSION['deleted'] = "<div class='success'>Category deleted</div>";
        header("location:".SITEURL.'admin/manage-category.php');

    } else
    {
        $_SESSION['deleted'] = "<div class='error'>Category Deletion Failed</div>";
        header("location:".SITEURL.'admin/manage-category.php');
    }

    
}
else 
{
    // redirect to Manage category page
    header("location:" . SITEURL . 'admin/manage-category.php');    
}

?>