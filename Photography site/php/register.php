 
 <?php
 
 include 'config.php';



 if(isset($_POST['submit'])){


   $name=mysqli_real_escape_string($conn,$_POST['name']);
   $email=mysqli_real_escape_string($conn,$_POST['email']);
   $pass=mysqli_real_escape_string($conn,md5($_POST['password']));
   $cpass=mysqli_real_escape_string($conn,md5($_POST['cpassword']));
   

$select = mysqli_query($conn,"SELECT * FROM `user_form` WHERE email='$email'AND password='$pass'")or die ('query faild!!');


if(mysqli_num_rows($select)>0){

   $message[]='User already exist';
}else{

    mysqli_query($conn, "INSERT INTO `user_form`(name,email,password)VALUES('$name','$email','$pass')") or die ('Query Faild!!');
    $message[]='registed successfully!!!';
    header('location:login.php');

   }


 }
 
 ?>
 
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title> 
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


     <h3>Register Now</h3>
     <input type="text" name="name" required placeholder="Enter Username" class="box">
     <input type="email" name="email" required placeholder="Enter Email" class="box">
     <input type="password" name="password" required placeholder="Enter Password" class="box">
     <input type="password" name="cpassword" required placeholder="Confirm Password" class="box">
     <input type="submit" name="submit" class="btn" value="register now"> 
     <p>Already have account ? <a href="login.php">log now </a></p>
     </form>

       
    </div >
            

 </body>
 </html>