<?php include('partials-front/menu.php'); ?>
    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Meal Categories</h2>

            <?php 
                // display the contents of category table with active set to yes
            
                $sql = "SELECT * FROM tbl_category WHERE active='yes'";
                // execute the query
                $res= mysqli_query($conn,$sql);
                // count the returned rows
                $count = mysqli_num_rows($res);

                if ($count > 0) 
                {
                    // categories inputted..loop thru avialable data
                    while($row = mysqli_fetch_assoc($res)) {
                        // get values from table
                        $id = $row["id"];
                        $title = $row["title"];
                        $image_name = $row["image_name"];
                        ?>

                        <a href="<?php echo SITEURL;?>category-foods.php?category_id=<?php echo $id;?>"> 
                            <div class="box-3 float-container">
                                <?php 
                                    if ($image_name == "") 
                                    {
                                        // no image uploaded
                                        echo "<div class='error'>No image available</div>";
                                    } 
                                    else 
                                    {
                                        // image upload (value not blank)
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" 
                                        alt="" class="img-responsive cat-img-display-home">

                                        <?php
                                    
                                    }
                                ?>                                                            
                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>   

                        <?php

                    }
                }
                else 
                {
                    // no categories yet
                    echo "<div class='error'>No food categories yet</div>";
                }

            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->
    <?php include('partials-front/footer.php'); ?>