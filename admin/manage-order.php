<?php include('partials\menu.php')?>
    <div class="main-content">
        <div class="wrapper-full">
            <h1>Manage Orders <i class="fa-solid fa-truck-fast fa-xl"></i></h1>            

            <br /> <br /> 

            <?php 
                if (isset($_SESSION['update'])) 
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            ?>
            <!-- Add one blank line -->
            <br/>    

          
           <table class="tbl-full">
            <tr>
                <!-- Table headers -->
                <th>Number</th>
                <th>Meal</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Date</th>
                <th>Status</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>              
                <th>Action</th>                
            </tr>
            <!-- Get data from database table (orders) -->
            <?php
                $sql = "SELECT * FROM tbl_orders ORDER BY id DESC";
                $res = mysqli_query($conn,$sql);

                // count retuned rows (if any)
                $count = mysqli_num_rows($res);
                $sn = 1;     // just some number that starts with one

                if ($count > 0 ) 
                {
                    // order details available
                    while($row = mysqli_fetch_assoc($res)) 
                    {
                        // get all order details
                        $id = $row['id'];
                        $meal = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        $customer = $row['customer_name'];
                        $contact = $row['customer_contact'];
                        $email = $row['customer_email'];
                        $address = $row['customer_address'];

                        // display data in html doc
                        ?>
                            <!-- Table data -->
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><b><?php echo $meal; ?></b></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><b><?php echo $total; ?></b></td>
                                <td><?php echo "<label style=font-size:14px>".$order_date."</label>"; ?></td>

                                <!--  display status in different colors -->
                                <td><i>
                                    <?php 
                                        if ($status=="ordered") 
                                        {
                                            echo "<label style='color:black'>$status</label>";
                                        } else if ($status=="on-delivery")
                                        {
                                            echo "<label style='color:orange'>$status</label>";
                                        } else if ($status=="delivered") 
                                        {   
                                            echo "<label style='color:green'>$status</label>";
                                        }
                                        else 
                                        {
                                            echo "<label style='color:red'>$status</label>";
                                        }
                                    ?>
                                
                                </i></td>

                                <td><b><?php echo $customer; ?></b></td>
                                <td><?php echo $contact; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo "<label style=font-size:14px>".$address."</label>"; ?></td>                                
                                <td>
                                    <!-- Update Order -->
                                    <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id;?>" class="btn-secondary">Update</a>
                                </td>                                                          
                            </tr>

                        <?php
                    }
                }
                else 
                {
                    // no order comess in yet
                    echo "<tr><td colspan='2' class='error'>No orders yet</td></tr>";
                }

            ?>           
              
           </table>
        </div>        
    </div>

<?php include('partials\footer.php')?>