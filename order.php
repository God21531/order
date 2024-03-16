<?php include('partials-front/menu.php'); ?>

<style>
.food-search {
    background-image: url('your-background-image-url.jpg');
    background-size: cover;
    background-position: center;
    padding: 50px 0;
}

.food-search .container {
    max-width: 800px;
    margin: 0 auto;
    background-color: rgba(255, 255, 255, 0.8); /* Add transparency to the container */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.food-search h2 {
    font-size: 2em;
    font-weight: bold;
    color: #333;
    text-align: center;
    margin-bottom: 30px;
}

.order {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

fieldset {
    border: none;
    margin-bottom: 20px;
}

legend {
    font-size: 1.2em;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.food-menu-img img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
}

.food-menu-desc {
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.food-menu-desc h3 {
    font-size: 1.2em;
    margin-bottom: 10px;
}

.food-price {
    font-size: 1.1em;
    color: #f00;
    margin-bottom: 10px;
}

.order-label {
    font-weight: 500;
    margin-bottom: 5px;
    font-size:x-large;
}

.input-responsive {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.btn-primary {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
}




</style>

<?php
    if(isset($_GET['food_id'])){
        $food_id = $_GET['food_id'];

        $sql = "SELECT * FROM tbl_food WHERE id=$food_id ";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        if($count==1){
            $row=mysqli_fetch_assoc($res);
            $title = $row['title'];
            $price = $row['price'];
            $image_name=$row['image_name'];
        }
        else{
            header('location:'.SITEURL);
        }
    }
    else{
        header('location:'.SITEURL);
    }
?> 

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>
                    <div class="food-menu-img">
                        <?php
                            if($image_name==""){
                                echo "<div class='error'>Image not available.</div>";
                            }
                            else{
                                ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">

                                <?php
                            }
                        ?>


    
                    <div class="food-menu-desc">
                        <h3 style="text-align:center; font-size:x-large;"><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">
                        <p class="food-price" style="text-align:center; font-size:xx-medium;">$<?php echo $price; ?></ </p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">


                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Charmmy" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9841xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. joshua21531@gmail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>
            <?php
            if(isset($_POST['submit'])){
                $food = $_POST['food'];
                $price= $_POST['price'];
                $qty = $_POST['qty'];
                $total = $price*$qty;
                $order_date = date("Y-m-d h:i:sa");
                $status = "Ordered";
                $customer_name = $_POST['full-name'];
                $customer_contact = $_POST['contact'];
                $customer_email=$_POST['email'];
                $customer_address=$_POST['address'];

                $sql2="INSERT INTO tbl_order SET
                        food = '$food',
                        price='$price',
                        qty=$qty,
                        total=$total,
                        order_date='$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email='$customer_email',
                        customer_address='$customer_address'
                ";
                    //echo $sql2; die();
                $res2 = mysqli_query($conn, $sql2);
                if($res2==true){
                    $_SESSION['order'] = "<div class='success'>Food Ordered Successfully.</div>";
                    //header('location:'http://localhost/food-order/main.php);
                    //header("location:" .SITEURL.'/main.php');
                }
                else{
                    $_SESSION['order'] = "<div class='error'>Failed to Order Food.</div>";
                    //header('location:http://localhost/food-order/main.php');
                }
            }
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <?php include('partials-front/footer.php'); ?>