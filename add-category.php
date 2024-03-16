<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1> Add Category</h1>

        <br><br>

        <?php

        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

?>

<br><br>

        <!-- Add Category form starts -->

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" placeholder="Category Title">
                </td>
            </tr>

            <tr>
                <td>Select Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            
            <tr>
                            <td>Price: </td>
                            <td>
                                <input type="number" name="price">
                            </td>
                        </tr>

            <tr>
                <td>Featured: </td>
                <td> 
                    <input type="radio" name="featured" value="Yes"> Yes
                    <input type="radio" name="featured" value="No"> No

                </td>

</tr>


<tr>
    <td>Active: </td>
    <td>
        <input type="radio" name="active" value="Yes"> Yes
        <input type="radio" name="active" value="No"> No
    </td>
</tr>

<tr>
    <td colspan="2">
        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
    </td>
</tr>
        </table>
</form>   
        <!-- Add Category form ends -->

        <?php 
            //check wheather the submit button is clicked or not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";

                //1. Get the value from form Category form
                $title = $_POST['title'];
                $price = $_POST['price'];

                //For radio input type we need to check wheather the button is selectted or not
                if(isset($_POST['featured']))
                {
                    //Get the value from form
                    $featured=$_POST['featured'];

                }
                else{
                    //Set the default value
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }
                

                //Check wheather the immage is selected or not and set the value for image name accordingly
                //print_r($_FILES['image']); //print_r displayes value of array

                //die(); //Break thr code here

                if(isset($_FILES['image']['name']))
                {
                    //Upload the image
                    //  To upload image we need image name, sourse path, destination path
                    $image_name = $_FILES['image']['name'];

                    // upload image only if image is selected
                    if($image_name != ""){

                    


                    //Auto rename our image
                    //Get the extension of our image(jpg, png,gif, etc)eg. "specialfood1.jpg"
                    $ext = end(explode('.', $image_name));
                    
                    //Rename the image
                    $image_name="Food_Category_".rand(000, 999).'.'.$ext; //e.g. Food_Catefory_834.jpg.

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/".$image_name;

                    //Finally upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //check wheather the image is uploaded or not
                    //and if the image is not uploaded then we will stop the process and redirect with error message

                    if($upload==false)
                    {
                        //Set message
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image. </div>";
                        //Redirect to add category page
                        header('location:'.SITEURL.'admin/add-category.php');
                        //Stop the process
                        die();
                    }

                }
            }
                else{
                    ///Don't upload image and set the image value as blank
                    $image_name="";
                }


                //2. Create SQL Query to insert  category into database
                $sql = "INSERT INTO tbl_category SET
                        title='$title',
                        image_name='$image_name',
                        price = $price,
                        featured='$featured',
                        active='$active'
                        ";

                        //3. Eecute the query and save the database
                        $res = mysqli_query($conn, $sql);

                        //4. Check wheather the query executed or not and data added or not
                        if($res==true)
                        {
                            //Query executed and category added
                            $_SESSION['add'] = "<div class='success'>Category Added Successfully. </div>";
                            //Redirect to manage category page
                            header('location:'.SITEURL.'admin/manage-category.php');
                        }
                        else{
                            //Failed to add category
                            $_SESSION['add'] = "<div class='error'>Failed to add category. </div>";
                            //Redirect to manage category page
                            header('location:'.SITEURL.'admin/add-category.php');
                        }

            }
        ?>

</div>
</div>

<?php include('partials/footer.php'); ?>/