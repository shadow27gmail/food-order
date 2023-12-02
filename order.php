<?php include('partials-front/menu.php');?>

    <?php
        // check if food id is set
        if (isset($_GET['food_id']))
        {
            $food_id = $_GET['food_id'];
            // get meal details
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
            // execute the query
            $res = mysqli_query($conn,$sql);
            
            // check if query netted us something
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                // id matches. there should only be one value
                // get data from table
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
                // display data in form
            }
            else 
            {
                // display warning
                echo "<div class='error'>That meal is no longer available</div>";
                // redirect to homepage
                header("location:" . SITEURL);
            }
        }
        else 
        {
            // redirect to home page
            header("location:" . SITEURL);
        }
    ?>



    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" class="order" method="post">
                <fieldset>
                    <legend>Selected Meal</legend>

                    <div class="food-menu-img">
                        <!-- display meal image if available -->
                        <?php
                        if ($image_name == "") 
                        {
                            // image is blank
                            echo "<div class='error'>No meal image</div>";
                                
                        }
                        else 
                        {
                            ?>
                                <img src="<?php echo SITEURL;?>images/food_item/<?php echo $image_name; ?>"
                                alt="" class="img-responsive cat-img-display">
                            <?php

                        }
                        ?>
                        
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="meal_name" value="<?php echo $title; ?>">

                        <p class="food-price"><?php echo 'PH '.$price; ?></p>
                        <input type="hidden" name="meal_price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Your fullname" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 0926xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. handle@youremail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>                    
                    
                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class='fa-regular fa-thumbs-up fa-beat fa-lg'></i>
                </fieldset>

            </form>

            <!-- check if customer confirm order -->
            <?php
            if (isset($_POST['submit'])) 
            {
                // Confirm order button clicked
                // get details from form
                $meal_name = $_POST['meal_name'];
                $meal_price = $_POST['meal_price'];
                $qty = $_POST['qty'];
                $total = $meal_price * $qty;
                $order_date = date("Y-m-d h:i:sa");   // PC's date and time  h-hour i-minute s-second a-am/pm
                
                $status = 'ordered';  // ordered, on-delivery, delivered, cancelled
                $customer_name= $_POST['full-name'];
                $customer_contact = $_POST['contact'];
                $customer_email = $_POST['email'];
                $customer_address = $_POST['address'];
                //----------- details gotten-------------------------   

                // put order detais in database              
                // create SQL query to save data
                $sql2 = "INSERT INTO tbl_orders SET                     
                    food='$meal_name',
                    price=$meal_price,
                    qty=$qty,
                    total=$total,
                    order_date='$order_date',
                    status='$status',                    
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'                    
                ";               

                // execute the query
                $res2 = mysqli_query($conn,$sql2);                
                // check if query succeeds                
                if ($res2==true)
                {
                    // query good, order saved
                    $_SESSION['order'] = "<div class='success'>Order placed.</div>";
                    // redirect to home page                    
                } 
                else 
                {
                    // failed to save order                    
                    $_SESSION['order'] = "<div class='error'>Failed to record order.</div>";
                    // redirect to home page                    
                }
                ?>
                <!-- Javascript to redirect page -->
                <script>
                    window.location='http://localhost/food-order/'
                </script>";
                <?php

            }

            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->
<?php include('partials-front/footer.php');?>
   