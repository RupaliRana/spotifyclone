<?php

include '_db_connect.php';
session_start();

if (isset($_POST['submit'])) {
   echo "start";
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if (mysqli_num_rows($select) > 0) {
      echo "inside";
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['user_id'];
      if ($_SESSION['user_id'] != '500') {
         header('location:explore.php');
      } else {
         header('location:admin.php');
      }

   } else {
      echo "failed";
      $message[] = 'incorrect password or email!';
   }

}
;

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="login.css">

</head>

<body>

   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
      }
   }
   ?>

   <div class="form-container">

      <form action="" method="post">
         <h3>Login</h3>
         <div class="user">
            <input type="email" name="email" required class="box">
            <label>Email</label>
         </div>
         <div class="user">
            <input type="password" name="password" required class="box">
            <label>Password</label>
         </div>

         <input type="submit" name="submit" class="btn" value="login now">
         <div class="signup">
            <p>don't have an account? <a href="register.php">register now</a></p>
         </div>

      </form>

   </div>

</body>

</html>