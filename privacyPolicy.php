<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Privacy Policy | Donedeal</title>
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
    
<div class="col-12 companyColor noBullets">
    <hr>
    <div class="col-1"><p></p></div>
<div class="col-10 white">
<h1>Donedeal Privacy Policy</h1>
<p>
This Privacy Policy describes how Donedeal Inc. ("Donedeal", "we", "us", or "our") collects, uses,
 and shares your personal information when you use our websites, mobile applications, and other 
 services (collectively, the "Services").
</p>
<p>
By using the Services, you agree to the terms of this Privacy Policy. If you do not agree to these 
terms, please do not use the Services.
</p>
<h2>What Personal Information Do We Collect?</h2>
<p>
We collect personal information from you when you:
</p>
<ul>
<li>Create an account on Donedeal</li>
<li>Make a purchase or sell an item on Donedeal</li>
<li>Contact us for customer service</li>
<li>Use our mobile applications</li>
<li>Browse our websites</li>
</ul>
<p>
The personal information we collect may include:
</p>
<ul>
<li>Your name</li>
<li>Your contact information, such as your email address and phone number</li>
<li>Your payment information</li>
<li>Your shipping information</li>
<li>Your product reviews and feedback</li>
<li>Your browsing history</li>
<li>Your IP address</li>
</ul>
<h2>How Do We Use Your Personal Information?</h2>
<p>
We use your personal information to provide you with the Services, to improve the Services, to communicate with you, and to protect our legal rights.
</p>
<p>
We use your personal information to:
</p>
<ul>
<li>Create and manage your account</li>
<li>Process your purchases and sales</li>
<li>Provide customer service</li>
<li>Personalize your experience on Donedeal</li>
<li>Send you marketing communications</li>
<li>Protect our legal rights</li>
</ul>
<h2>How Do We Share Your Personal Information?</h2>
<p>
We may share your personal information with third parties who help us provide the Services to you.</p>
 These third parties may include:
<ul>
<li> Payment processors: We share your payment information with payment processors so that they can process
     your payments.</li>
<li> Shipping companies: We share your shipping information with shipping companies so that they can deliver
     your items.</li>
<li> Customer service providers: We share your contact information with customer service providers so that 
    they can provide you with customer service.</li>
<li> Marketing partners: We share your contact information with marketing partners so that they can send you
     marketing communications.</li>
<li> Analytics providers: We share your browsing history and other information with analytics providers so 
    that they can help us improve the Services.</li>
</ul>
We may also share your personal information with other third parties in the following circumstances:
<ul>
<li> Legal obligations: We may share your personal information when required to do so by law or in response 
    to a valid legal process.</li>
<li> Protection of rights: We may share your personal information when we believe it is necessary to 
    investigate, prevent, or take action regarding potential violations of our terms of service, or to 
    protect the rights, property, or safety of eBay, our users, or others.</li>
<li> Business transfers: If we are involved in a merger, acquisition, or sale of all or a portion of our 
    assets, your personal information may be transferred to the new owner.</li>
</ul>
We may also share aggregated or de-identified information with third parties for research or marketing 
purposes. This information does not contain any personally identifiable information.
</div>
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