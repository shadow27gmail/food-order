<?php include('partials-front/menu.php');?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">

            <?php 
             // get the search keyword
             $search = $_POST['search'];
            ?>
            
            <h2>Meals that match(es) <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Available Meals</h2>

            <?php 
               
                // create SQL query to get food based on search
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
                // execute query
                $res = mysqli_query($conn, $sql);
                // check if the query returns anything
                $count = mysqli_num_rows($res);
                if ($count > 0) 
                { 
                    // search yields positive result. Get all values from table
                    while ($row = mysqli_fetch_assoc($res)) 
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];

                        // break the php and start it again. Type the htm in between
                        ?>
                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <!-- check if image is available first -->
                                    <?php
                                        if ($image_name == "") 
                                        {
                                            // no image
                                            echo "<div class='error'>Meal image not available </div>";
                                        } 
                                        else 
                                        {                                            
                                            // image exist 
                                            ?>
                                             <img src="<?php echo SITEURL; ?>images/food_item/<?php echo $image_name;?>" alt="" class="img-responsive img-curve">
                                           
                                            <?php                                    
                                        }
                                    ?>
                                    
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="food-price"><?php echo $price; ?></p>
                                    <p class="food-detail"><?php echo $description; ?></p>
                                    <br>
                                    <a href="#" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>
                        <?php                
                    }   
                    // while loop ends
                }
                else
                {
                    // negative result
                echo "<div class='error'>Sorry. We do not have that food in our database</div>";
                }
            ?> 

            <div class="clearfix"></div>  

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php');?>