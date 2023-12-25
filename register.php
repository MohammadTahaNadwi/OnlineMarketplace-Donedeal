<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>User Registration | Donedeal</title>
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
    
    <div class="col-3"><p></p></div>
    <div class="col-6 form white">
        <h1 class="centerText">Register</h1>

<form action="#" onsubmit="return validatePassword()" method="post">
<?php
include "Users.php";
if(isset($_POST["email"]) ){
  if(strlen($_POST["password"])>7){
  if($_POST["password"] === $_POST["repassword"]){
    if(str_contains($_POST["firstName"],"admin") || str_contains($_POST["lastName"],"admin")){

      echo "<p class=' centerText error'>Name should not contain 'admin'</p>";
    }
    else{
  $users->register($_POST["firstName"],$_POST["lastName"],$_POST["phoneNumber"],$_POST["email"],$_POST["password"]);
    }
  }
  else {
    echo "<p class=' centerText error'>Passwords need to match</p>";
  }}
  else{
    echo "<p class=' centerText error'>Password too short</p>";
  }
}
?>
<label for="firstName">First Name:</label>
    <input type="text" name="firstName" id="firstName" required>
    <br>
    <label for="lastName">Last Name:</label>
    <input type="text" name="lastName" id="lastName" required>
    <br>
    <label for="phoneNumber">Phone Number:</label>
    <input type="number" name="phoneNumber" id="phoneNumber" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" minlength="8" required>
    <h6>Password should have atleast 8 characters</h6>
    
    <label for="repassword">Confirm Password:</label>
    <input type="password" name="repassword" id="repassword" minlength="8" required>
    <br>
    <input type="submit" value="Register">

    Already have an account? <a href="loginInterface.php">Log In</a>
  </form>

</div>
</div>
<script>
  function validatePassword() {
  var password = document.getElementById("password").value;
  var repassword = document.getElementById("repassword").value;

  if (password !== repassword) {
    alert("Passwords do not match!");
    return false; // Prevent form submission
  }
  
  return true; // Allow form submission
}

</script>
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