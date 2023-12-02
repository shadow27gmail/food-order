<?php 
// include contants.php
include('../config/constants.php');


// get admin id to be deleted
echo $id = $_GET['id'];

// create SQL query to effect delete
$sql = "DELETE FROM tbl_admin WHERE id=$id";

// execute the query
$res = mysqli_query($conn, $sql);
// check if query is successfull
if ($res==true) 
{
    // query is successfull
    // echo "Administrator deleted!";
    $_SESSION['delete'] = "<div class='success'>Administrator deleted!</div>";
    // redirect to manage admin page
    header("location:" . SITEURL . 'admin/manage-admin.php');
}
else 
{
    // query failed
    // echo "Administrator delete failed!";
    $_SESSION['delete'] = "<div class='error'>Administrator delete failed!</div>";
    // redirect to manage admin page
    header("location:" . SITEURL . 'admin/manage-admin.php');
}

?>
