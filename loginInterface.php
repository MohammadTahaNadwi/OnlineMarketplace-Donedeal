<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login | Donedeal</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
    <link rel="shortcut icon" href="Images/logo.jpg" type="image/x-icon">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/25b272a164.js" crossorigin="anonymous"></script>
</head>
<body>
    <header class="col-12">
        <a href="index.php"><img src="Images/logo.jpg" class="col-1 logo" alt="Company Logo"></a>
<nav id="headerNav" class="col-10">
    <p class="col-1"></p>
    <a class="col-2" href="index.php">Home</a>
    <a class="col-2" href="deals.php">Deals</a>
    <a class="col-2" href="reviews.php">Reviews</a>
    <a class="col-2" href="contact.php">Contact Us</a>
    <a class="col-2" href="about.php">About Us</a>

</nav>
<?php
if (isset($_SESSION['username'])) {
    // Write User name on top left corner if user is logged in
    echo "<a href='CustomerDashboard.php'><i class='fa-regular fa-user'></i></a>";
  }  
  else{
    // display an anchor tag referring to login page if user is not logged in
      echo "<a href='loginInterface.php'><i class='fa-regular fa-user'></i></a>";
  }  
?>

    </header>

   <hr>
    <div class="col-12  companyColor">
        
        <div class="col-4"><p></p></div>
        <div class="col-4 white form">
   <h1>Login</h1>
    <form action="#" method="POST">
        <label for="email">Email</label>
      <input type="email" name="email" placeholder="Email" id="email" required>
      <label for="password">Password</label>
      <input type="password" name="password" placeholder="Password" id="password" required>
      <input type="submit" value="Login">
    </form>
Don't have an account? <a href="register.php">Register now</a>
</div>
<?php
include "Users.php";
if(isset($_POST["email"]) && isset($_POST["password"])){
$users->login($_POST["email"],$_POST["password"]);
}
?>
    </div>
    <hr>
    <footer>
        
        <div class="col-4">
         <h3>Our Pages</h3> 
            <a class="col-12" href="index.php">Home</a>
  <a class="col-12" href="deals.php">Deals</a>
  <a class="col-12" href="reviews.php">Reviews</a>
  <a class="col-12" href="contact.php">Contact Us</a>
  <a class="col-12" href="about.php">About Us</a>
  <a class="col-12" href="loginInterface.php">Login</a>
        </div>
        <div class="col-4">
            <h3>Help &amp; Contact</h3>
            
              <a href="privacyPolicy.php" class="col-12">Privacy Policy</a>
              
              <a href="contact.php" class="col-12">Contact us</a>
          </div>

          <div class="col-4">
          
            <h3>Follow Us</h3>
            
            <a href="https://web.facebook.com/donedealonlinebusiness" class="col-12">Facebook</a>
            <a href="https://twitter.com/donedealmw?t=18NWA57MmeEnW5ARypokAQ&s=09" class="col-12">Twitter</a>
            <a href="https://www.instagram.com/donedealonlinebusiness" class="col-12">Instagram</a>
            <a href="https://www.linkedin.com/in/donedealonlinebusiness" class="col-12">LinkedIn</a>
          
         
          </div>
         <hr>
              <small><p>Copyright &copy; 2010-2023 Donedeal Limited. All Rights Reserved.</p></small>
          
        
      
    </footer>
</body>
</html>