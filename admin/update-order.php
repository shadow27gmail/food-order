<?php include("partials/menu.php"); ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Update order &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-pen-to-square fa-beat fa-xl"></i> </h1>
            <br/><br/>
            <?php 
                // check if order id was passed from calling URL.page
                if (isset($_GET['id']))                 
                {
                    // ID passed, get values based on ID
                    $id = $_GET['id'];
                    // get details from table
                    $sql = "SELECT * FROM tbl_orders WHERE id=$id";
                    // execute the query
                    $res = mysqli_query($conn,$sql);
                    // count returned rows if any
                    $count = mysqli_num_rows($res);

                    if ($count == 1) 
                    {
                        // it is supposed to return only 1 row
                        $row = mysqli_fetch_assoc($res);
                        $meal = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];
                    } 
                    else 
                    {
                        // no details provided, order is infirm. redirect to manage order
                        header('location:' . SITEURL . 'admin/manage-order.php');
                    }

                } 
                else 
                {
                    // no ID passed, redirect to manage orders
                    header('location:' . SITEURL . 'admin/manage-order.php');
                }
            ?>

            <form action="" method="post">
                <table class='tbl-30 table-add-admin'> 
                    <!-- Ordered Meal -->
                    <tr>
                        <td><b><p class="text-prompt">Meal</p></b></td>
                        <td><b class="text-prompt"><p><?php echo $meal; ?></b></td>
                    </tr>
                    <!-- Price -->
                    <tr>
                        <td><p class="text-prompt">Price</p></td>
                        <td><p class="text-prompt">PH <?php echo $price; ?></p></td>
                    </tr>
                    <!-- Number of order -->
                    <tr>
                        <td><p class="text-prompt">Qty</p></td>
                        <td>
                            <input type="number" name="qty" value="<?php echo $qty; ?>" class="text-input">
                        </td>
                    </tr>
                    <!-- Order status -->
                    <tr>
                        <td><p class="text-prompt">Status</p></td>
                        <td>
                            <select name="status" class="select-text-prompt">
                                <option 
                                <?php if ($status == "ordered") {echo "selected";}?>
                                value="ordered">Ordered</option>

                                <option
                                <?php if ($status == "on delivery") {echo "selected";}?>                    
                                 value="on-delivery">On delivery</option>
                                <option
                                <?php if ($status == "delivered") {echo "selected";}?>                                
                                value="delivered">Delivered</option>
                                <option
                                <?php if ($status == "cancelled") {echo "selected";}?>
                                 value="cancelled">Cancelled</option>
                            </select>
                        </td>
                    </tr>
                    <!-- Customer's name -->
                    <tr>
                        <td><p class="text-prompt">Customer's name</p></td>
                        <td>
                            <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" class="text-input">
                        </td>
                    </tr>
                    <!-- Customer's number -->
                    <tr>
                        <td><p class="text-prompt">Contact</p></td>
                        <td>
                            <input type="text" name="customer_contact" 
                            value="<?php echo $customer_contact; ?>" class="text-input">
                        </td>
                    </tr>
                    <!-- Customer's email -->
                    <tr>
                        <td><p class="text-prompt">Email</p></td>
                        <td>
                            <input type="text" name="customer_email" 
                            value="<?php echo $customer_email; ?>" class="text-input">
                        </td>
                    </tr>
                    <!-- Customer's address -->
                    <tr>
                        <td><p class="text-prompt">Address</p></td>
                        <td>
                            <textarea name="customer_address" cols="30" rows="5" 
                                class="text-area-input" placeholder="Address">
                                <?php echo $customer_address; ?>
                            </textarea>
                        </td>
                    </tr>
                    <!-- Button to update order -->
                    <tr>
                        <td colspan="2" align="center">                       
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update order" class="btn-secondary btn-add-admin">
                        
                        </td>
                    </tr>
                </table>
            </form>

            <?php
                // check if update button was clicked
                if (isset($_POST['submit'])) {
                    // echo "Button clicked";
                    // get values from form
                    $id = $_POST['id'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    $total = $price * $qty;
                    $status = $_POST['status'];
                    $customer_name = $_POST['customer_name'];
                    $customer_contact = $_POST['customer_contact'];
                    $customer_email = $_POST['customer_email'];
                    $customer_address = $_POST['customer_address'];


                    // update values in table
                    $sql2 = "UPDATE tbl_orders SET
                        qty=$qty,
                        total=$total,
                        status = '$status',
                        customer_name='$customer_name',
                        customer_contact='$customer_contact',
                        customer_email='$customer_email',
                        customer_address='$customer_address'
                        WHERE id=$id
                    ";

                    // execute the query
                    $res2 = mysqli_query($conn, $sql2);
                    // check for query success
                    if ($res2==true)                        
                    {
                        $_SESSION['update'] = "<div class='success'>Order details updated</div>";
                        // redirect to manage order
                        // header("location:" . SITEURL . 'admin/manage-order.php');
                        echo "<script>                                    
                                window.location='http://localhost/food-order/admin/manage-order.php'
                        </script>";
                    }
                    else 
                    {
                        // update fails
                        $_SESSION['update'] = "<div class='error'>Cannot update order details</div>";
                        // header("location:" . SITEURL . 'admin/manage-order.php');
                        echo "<script>                                    
                                window.location='http://localhost/food-order/admin/manage-order.php'
                        </script>";
                    }
                }
            
            ?>
        </div>
    </div>
<?php include("partials/footer.php"); ?>