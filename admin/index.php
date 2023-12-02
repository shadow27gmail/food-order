<?php include('partials/menu.php'); ?>
        <!-- Menu section ends-->
        <!-- Main content section start-->
        <div class="main-content">
            <div class="wrapper">
                <H1><i class="fa-regular fa-address-card fa-xl"></i>&nbsp;&nbsp;&nbsp;Dashboard</H1>
                <br/><br/>
                <?php
                if (isset($_SESSION['login'])) {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                ?>
                <br/><br/>
                <div class="col-4 text-center dash-box">
                    <?php                    
                        $sql = "SELECT * from tbl_category";
                        $res = mysqli_query($conn, $sql);
                        $row = mysqli_num_rows($res);
                    ?>
                    <h1><?php echo $row; ?></h1>
                    <br>
                    Meal Categories
                </div>
                <div class="col-4 text-center dash-box">
                    <?php                    
                        $sql2 = "SELECT * from tbl_food";
                        $res2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_num_rows($res2);
                    ?>
                    <h1><?php echo $row2; ?></h1>                     
                    <br>
                    Invidual Meals
                </div>
                <div class="col-4 text-center dash-box">
                    <?php                    
                        $sql3 = "SELECT * from tbl_orders";
                        $res3 = mysqli_query($conn, $sql3);
                        $row3 = mysqli_num_rows($res3);
                    ?>
                    <h1><?php echo $row3; ?></h1>
                    <br>
                    Number of Orders
                </div>
                <div class="col-4 text-center dash-box">
                    <?php
                        $sql4 = "SELECT SUM(total) AS Total FROM tbl_orders WHERE status='delivered'";
                        $res4 = mysqli_query($conn, $sql4);
                        $row4 = mysqli_fetch_assoc($res4);
                        // get total revenue
                        $total_revenue = $row4['Total'];
                    ?>
                    <h1>PH <?php echo $total_revenue; ?></h1>
                    <br>
                    Revenue to date
                </div>   
                <div class="clearfix"></div>             
            </div>
            
        </div>
        
        <!-- Main content section ends-->
<?php include('partials/footer.php'); ?>
    