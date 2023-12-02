<?php include('partials-front/menu.php'); ?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
                <br/><br/>
                <?php 
                    // check if order button was clicked prior to coming back here
                    if (isset($_SESSION['order']))
                    {
                        echo $_SESSION['order'];
                        unset($_SESSION['order']);
                    } 
                ?>
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Meal Categories</h2>

            <?php 
                // populate categories from items in the database
                // query the database but limit the return to maximum of 3
                $sql = "SELECT * FROM tbl_category WHERE active='yes' and featured='yes' LIMIT 3";
                // execute query
                $res = mysqli_query($conn,$sql);
                $count=mysqli_num_rows($res);
                if ($count > 0)                 
                {
                    // categories available
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        // get the values from table
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                   
                        // display obtained values in html document
                        ?>
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php 
                                    // check if there are image in the data (image name not blank)
                                    if ($image_name=="") 
                                    {
                                        // no image in data
                                        echo "<div class='error'>No image available</div>";
                                    }
                                    else 
                                    {
                                        // we found an image
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" 
                                        alt="Pizza" class="img-responsive cat-img-display-home">
                                        <?php

                                    }
                                ?>                            
                                <h3 class="float-text text-white"><?php echo $title;?></h3>
                            </div>
                        </a>    
                        <?php
                    }                  

                }
                else 
                {
                    // no categories yet
                    echo "<div class='error'>No categories yet</div>";
                }

            ?>                    

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        
        <div class="container">
            <h2 class="text-center">Featured Meals</h2>
            <?php 
            // get food items from DB with active and featured status set to yes
            // create SQL query to get data
            $sql2 = "SELECT * FROM tbl_food WHERE active='yes' AND featured = 'yes' LIMIT 6";

            // execute the query
            $res2 = mysqli_query($conn,$sql2);
            $count2=mysqli_num_rows($res2);
            // check if data exist
            if ($count2 > 0) 
            {
                while ($row2 = mysqli_fetch_assoc($res2)) 
                {
                    // get values from food table
                    $id = $row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $image_name = $row2['image_name'];
                    ?>
                       <a href="<?php echo SITEURL;?>category-foods.php?category_id=<?php echo $id;?>">                      
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
                       </a>
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

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>
