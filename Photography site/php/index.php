<?php  include 'config.php';

session_start();

$user_id=$_SESSION['user_id'];

if(!isset($user_id)){


    header('location:login.php');

};

if(isset($_GET['logout'])){
    unset($user_id);
    session_destroy();
    header('location:login.php');
    
};


if(isset($_POST['BOOK_NOW'])){
 
    $pg_name=$_POST['product_name'];
    $pg_price=$_POST['product_price'];
    $pg_image=$_POST['product_image'];




$select_cart=mysqli_query($conn, "SELECT * FROM `cart` WHERE name ='$pg_name' AND user_id='$user_id'")or die('Query faild!!');


if(mysqli_num_rows($select_cart)>0){
    $message[]='Photographer already added to cart!';

}else{
    mysqli_query($conn, "INSERT INTO `cart`(user_id,name,price,image)VALUES('$user_id','$pg_name','$pg_price','$pg_image')")or die('Query faild!!');
    $message[]='Photographer Booked!!';
}


};

if(isset($_GET['remove'])){
  $remove_id=$_GET['remove'];
  mysqli_query($conn, "DELETE FROM `cart` WHERE id='$remove_id'")or die('Query Faild!!');
  header('location:index.php');
}

if(isset($_GET['delete_all'])){
  mysqli_query($conn, "DELETE FROM `cart` WHERE user_id='$user_id'")or die('Query Faild!!');
  header('location:index.php');
}
   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Photographer</title>
    <link rel="stylesheet" href="login-style.css">
</head>
<body>


<?php

if(isset($message)){


   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();" >'.$message.'</div>';
   }
}


?>
<div class="container"> 
    <div class="user-profile">
      <?php

         $select_user=mysqli_query($conn,"SELECT *FROM `user_form` WHERE id = '$user_id'") or die ('Query faild!!!');

         if(mysqli_num_rows($select_user)>0){
            $fetch_user =mysqli_fetch_assoc($select_user);
         };
       
      ?>



<p> Username: <span> <?php echo $fetch_user['name']; ?></span></p>
<p> Email: <span> <?php echo $fetch_user['email']; ?></span></p>
   
 <div class="flex">
    <a href="login.php" class="btn">Login</a>
    <a href="register.php" class="option-btn">register</a>
    <a href="index.php?logout=<?php echo $user_id; ?>"onclick="return confirm('are you sure you want to logout ? ');" class="delete-btn">logout</a>
    
    </div>

    </div> 

    <div class="photographers">

    <h1 class="heading">BOOK  PHOTOGRAPHERS </h1>
        <div class="box-container">

<?php

 $select_photographer=mysqli_query($conn,"SELECT * FROM `photographers`") or die ('Query faild!!!');

     if(mysqli_num_rows($select_user)>0){
     while($fetch_product=mysqli_fetch_assoc($select_photographer)){
?>

<form method="post" class="box" action="">
    <img src="photographers/<?php echo $fetch_product['image']; ?>" alt="">
    <div class="name"><?php echo $fetch_product['name']; ?></div>
    <div class="price">RS:<?php echo $fetch_product['price']; ?>.00/-</div>
    <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>"> 
    <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>"> 
    <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>"> 
    <input type="submit" value="Book now" name="BOOK_NOW" class="btn">

</form>
<?php
    
     };
   }; 
?>


      </div>
    </div>

    <div class="shopping-cart">
      <h1 class="heading">Photographer Cart</h1>
      <table>
         <thead>
            <th>image</th>
            <th>name</th>
            <th>price</th>
            
            <th>action</th>
         </thead>

 <tbody>

         <?php
          $garnd_total=0;
          $cart_query=mysqli_query($conn,"SELECT * FROM `cart` WHERE user_id='$user_id' ") or die ('Query faild!!!');

          if(mysqli_num_rows($cart_query)>0){
          while($fetch_cart=mysqli_fetch_assoc($cart_query)){
          ?>

        <tr>

          <td><img src="photographers/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
          <td><?php echo $fetch_cart['name'];?></td>  
          <td>RS:<?php echo $fetch_cart['price'];?>.00/-</td>    
       
          <td>
            <form action="" method="post">
                <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id'];?>">
                
            </form>
          
            <a href="index.php?remove=<?php echo $fetch_cart['id'];?>"
            class="delete-btn" onclick="return confirm('remove item from cart?');">remove
            </a>
          </td>
        </tr>

         <?php
              $total=number_format($fetch_cart['price']); 
              $garnd_total=(int)$garnd_total+(int)$fetch_cart['price'];
          };
        }else{
          echo '<tr><td colspan="6">No item Added</td></tr>';
        }
           
         
         ?>

         <tr class="table-bottom">
            <td colspan="2">Grand total:</td>
            <td>RS:<?php echo $garnd_total;?>.00/-</td>
            <td><a href="index.php?delete_all" onclick="return confirm('delete all from cart?');" class="delete-btn">delete all</a></td>
         </tr>
      </tbody>
      </table>
      
      <div class="cart-btn">
        <a href="#" class="btn<?php echo ($garnd_total>1)?'':'disabled'; ?>">proceed to checkout</a>

      </div>
       
    </div>
</div>   
</body>
</html>