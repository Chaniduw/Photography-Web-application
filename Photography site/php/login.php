 
 <?php
 
 include 'config.php';
 session_start();



 if(isset($_POST['submit'])){


   
   $email=mysqli_real_escape_string($conn,$_POST['email']);
   $pass=mysqli_real_escape_string($conn,md5($_POST['password']));

   
 
$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email='$email'AND password='$pass'")or die ('query faild!!');


if(mysqli_num_rows($select) > 0){

    $row=mysqli_fetch_assoc($select);
    $_SESSION['user_id']=$row['id'];
    header('location:index.php');
   
}else{

    
    $message[]='Incorrect password or email !!!';
  
   }


 }
 
 ?>
 
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title> 
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




    <div class="form-container">
      
     <form action="" method="post">


     <h3>Login Now</h3> 
     <input type="email" name="email" required placeholder="Enter Email" class="box">
     <input type="password" name="password" required placeholder="Enter Password" class="box">
     <input type="submit" name="submit" class="btn" value="Login"> 
     <p>Don't have account ? <a href="register.php">Register Now </a></p>
     </form>

       
    </div >
            

 </body>
 </html>