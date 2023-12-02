<?php include('partials-front/menu.php');?>
    <?php
        // check if category id was passed fromm calling URL
        if (isset($_GET['category_id'])) 
        {
            // category_id passed
            $category_id = $_GET['category_id'];
            // get category title
            $sql = "SELECT title FROM tbl_category WHERE id=$category_id";
            // execute the query
            $res = mysqli_query($conn,$sql);
            // check if query returned anything
            $row = mysqli_fetch_assoc($res);
            $category_title = $row['title'];            
        } 
        else 
        {
            // no id passed, redirect to home page
            header("location:" . SITEURL);
        }
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Meals suitable for <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Available Meals</h2>
            <!-- Get the meals that matches the clicked category -->
            <?php 
                // create query. $category_id gotten from home page when one of the 3 categories was clicked
                $sql2 = "SELECT * from tbl_food WHERE category_id=$category_id";
                // execute the query
                $res2 = mysqli_query($conn,$sql2);
                // count returned rows (if any)
                $count2 = mysqli_num_rows($res2);
                // check if count2 has anything on it
                if ($count2 > 0) 
                {
                    while($row2 = mysqli_fetch_assoc($res2)) 
                    {
                        // get title, price, description and image name
                        $title = $row2['title'];
                        $id = $row2['id'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];                        
                        // display these details in HTML
                        ?>
                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <!-- check if image have been provided -->
                                    <?php 
                                        if ($image_name=="") 
                                        {
                                            // no image
                                            echo "<div class='error'>No meal image</div>";
                                        } 
                                        else 
                                        {
                                            // an image exist
                                            ?>
                                            <img src="<?php echo SITEURL; ?>images/food_item/<?php echo $image_name; ?>" alt="" class="img-responsive category-img-display">
                                            <?php
                                        }
                                    ?>
                                    
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="food-price"><?php echo 'PH'.$price; ?></p>
                                    <p class="food-detail"><?php echo $description; ?></p>
                                    <br>
                                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>
                        <?php
                    }
                }
                else
                {
                    // no meal in that category
                    echo "<div class='error'>No available meals in that category at this moment</div>";
                }
            ?>

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php');?>