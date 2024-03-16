<?php

        //  include cpnstants file
        include('../config/constants.php');
        //Check wheather the id and image_name value is set or not
        if(isset($_GET['id']) AND isset($_GET['image_name']))
        {
            //Get the value and delete
            //echo "Get Value and delete";
            $id = $_GET['id'];
            $image_name = $_GET['image_name'];

            //remove the physical image file if available
            if($image_name != "")
            {
                //Image is available ,so remove it
                $path = "../images/category/".$image_name;
                //Remove the image
                $remove = unlink($path);  //outbuts boolean value

                //if failed to remove image then add an error message and stop it
                if($remove==false)
                {
                    //Set thr session message
                    $_SESSION['remove'] = "<div class='error'>Failed to remove category images</div>";
                    //Redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                    //Stop the process
                    die();
                }
            }

            //Delete data from database
            //sql query to delete data from database
            $sql = "DELETE FROM tbl_category WHERE id=$id";

            //Execute the query
            $res = mysqli_query($conn, $sql);

            //Check wheather the data is delete from database or not
            if($res==true){
                //SET successs message and redirect
                $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully. </div>";
                //Redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else{
                //Set fail message and redirect
                $_SESSION['delete'] = "<div class='error'>Failed to delete category </div>";
                //Redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }
       


        }
        else{
            //redirect to manage category page
            header('location:'.SITEURL.'admin/manage-catefory.php');
        }
        ?>


