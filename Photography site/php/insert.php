<?php
include 'config.php';

if(isset($_POST['add_photographer'])){
    $p_name=$_POST['p_name'];
    $p_price=$_POST['p_price'];
    $p_image=$_FILES['p_image']['name'];
    $p_image_tmp_name=$_FILES['p_image']['tmp_name'];
    $p_image_folder= 'photographers/'.$p_image;




$insert_query=mysqli_query($conn, "INSERT INTO `photographers`(name,price,image)VALUES
('$p_name','$p_price','$p_image')")or die ('query faild');



if($insert_query){
    move_uploaded_file($p_image_tmp_name,$p_image_folder);
    $message[]='image added succsesfully!!';
}
else{

    $message[]='cannot add the product!!';
}


}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert products</title>
</head>
<body>
<div class="container">

   <form action="" method="post" class="add-photographer-form" enctype="multipart/form-data">
    <h3>Add a new Photographer</h3>
    <input type="text" name="p_name" placeholder="Enter photographer name" class="box" required>
    <input type="number" name="p_price" min="0" placeholder="Enter photographer price" class="box">
    <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
    <input type="submit"  value="add the product" name="add_photographer" class="btn">
   </form>
    
</div>
    
    
</body>
</html>