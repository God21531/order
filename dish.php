<?php include('partials-front/menu.php'); ?>

<!--dishes section starts-->

<section class="dishes" id="dishes">

    <h3 class="sub-heading">our Chaats</h3>
    <h3 class="heading">Chaat items:- </h3>
    
        <?php 
        $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' ";

        $res= mysqli_query($conn, $sql);
        
        $count = mysqli_num_rows($res);

        if($count>0)
        {
            //categry available
            while($row=mysqli_fetch_assoc($res)){
                $id = $row['id'];
                $title = $row['title'];
                $image_name=$row['image_name'];
                $price = $row['price'];

                ?>
            
            

                 

            <?php 
            if($image_name==""){
                echo "<div class='error'>Image not availale</div>";
            }
            else{
                ?>

<div class="box-container">
<div class="box">
        <a href="#" class="fas fa-heart"></a>
        <a href="#" class="fas fa-eye"></a>
                 <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="hiii" >
                 <h3><?php echo $title; ?> </h3>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                
            </div>
            <span class="price">$<?php echo $price; ?></span>
            <a href="<?php echo SITEURL; ?>order-category.php?food_id=<?php echo $id; ?>" class="btn">add to cart</a>
        </div>
        </div>

                <?php  
            }
            ?>
           
           

                <?php

            }
        }
        else{
            //category not available
            echo"<div class='error'>Category not added. </div>";
        }
        ?>

            

        
</section>



<!--dishes section ends-->

<?php include('partials-front/footer.php'); ?>