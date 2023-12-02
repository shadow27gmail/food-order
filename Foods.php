<?php include('partials-front/menu.php');?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL;?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Available Meals</h2>

            <?php 
                // get food items from DB with active and featured status set to yes
                // create SQL query to get data
                $sql = "SELECT * FROM tbl_food WHERE active='yes'";
                // execute the query
                $res = mysqli_query($conn,$sql);
                $count=mysqli_num_rows($res);
                // check if data exist
                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        // get values from food table
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];                        
                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    if ($image_name == "") 
                                    {
                                        // no image uploaded
                                        echo "<div class='error'>No image available</div>";
                                    } 
                                    else 
                                    {
                                        // image uploaded (value not blank)
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food_item/<?php echo $image_name; ?>" 
                                        alt="" class="img-responsive cat-img-display">
                                        <?php
                                    }
                                ?>                                     
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price"><?php echo 'PH'.$price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>
                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>    

                        <?php
                    }
                } 
                else 
                {
                    echo "<div class='error'>No food item in database yet</div>";
                }
            ?> 
            <div class="clearfix"></div>   
        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php');?>