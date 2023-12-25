<?php 
session_start();
include "Quotation.php";
$quotation->validateQuotations();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Home | Donedeal</title>
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
      <div class="col-12">
<div class="col-6 whitefont">
 
<a href="index.php"><img src="Images/logo.jpg" class="col-2 logo" alt="Company Logo"></a> <h1>Donedeal Online Business</h1>
</div>
<div class="col-5 search"><form action="#"><div class="col-8">
  <input type="text" placeholder="Enter search text here... " name="search" id="">
</div><div class="col-3"><input type="submit" value="Search" class="AdvertButton"></div>
</form></div>

      </div>
<nav id="headerNav" class="col-10">
<p class="col-2"></p>
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

<div class="col-3">
  <nav>
  <a class='col-7'><h3>Select a Category</h3></a>
<a href="index.php?category=*" class="col-7">All</a>
<a href="index.php?category=Appliances" class="col-7">Applicances</a>
<a href="index.php?category=Cosmetics" class="col-7">Cosmetics</a>
<a href="index.php?category=Electronics" class="col-7">Electronics</a>
<a href="index.php?category=Fashion" class="col-7">Fashion</a>
<a href="index.php?category=Furniture" class="col-7">Furniture</a>
<a href="index.php?category=Groceries" class="col-7">Groceries</a>
<a href="index.php?category=Travel" class="col-7">Travel</a>
<a href="index.php?category=Vehicles" class="col-7">Vehicles</a>
<a href="index.php?category=Other" class="col-7">Other</a>
</nav>
</div>
<div class='col-7 centerText'><h1>Buy anything, sell anything</h1></div>



<?php
include "Category.php";
include "Item.php";
if(isset($_GET['category'])||(isset($_GET["search"]) && $_GET["search"]!=null)){

  if(isset($_GET['category'])){
$result=$category->filterProducts($_GET["category"]);
  
// print selected category results
if ($result->num_rows > 0) {
    //output data of each row
    echo "<header>";
    while($row = $result->fetch_assoc()) {
      $image=$item->loadImages($row["Advertisement_ID"]);
      if($image=$image->fetch_assoc()){   
    echo "
    <div class='col-3 centerText advert'><img src='advertImages/".$image["imageName"]."'>
    <p>Brand: ".$row['brand']."</p><p>Product Name: ".$row['productName']."</p>
    <p>Price: " . $row["price"]."</p><form action='advertDetails.php' method='POST'>
    <input type='text' name='advertID' value=". $row["Advertisement_ID"]."  hidden>
    <input type='submit' value='View Details' class='AdvertButton'></form></div>";
    }
  }
  echo "</header>";
    } else {
    echo "<div class='col-7 centerText'>No items found for this category</div>";
    }
  }
if(isset($_GET["search"])){
$search=$item->searchItem($_GET["search"]);
$loopCount=0;
    for($i=0;$i<3;$i++){
    if ($search[$i]->num_rows > 0) {
      $loopCount++;
      $res=$search[$i];
      //output data of each row
      echo "<header>";
      while($row = $res->fetch_assoc()) {
        $image=$item->loadImages($row["Advertisement_ID"]);
        if($image=$image->fetch_assoc()){   
      echo "
      <div class='col-3 centerText advert'><img src='advertImages/".$image["imageName"]."'>
      <p>Brand: ".$row['brand']."</p><p>Product Name: ".$row['productName']."</p>
      <p>Price: " . $row["price"]."</p><form action='advertDetails.php' method='POST'>
      <input type='text' name='advertID' value=". $row["Advertisement_ID"]."  hidden>
      <input type='submit' value='View Details' class='AdvertButton'></form></div>";
      }
    }
    echo "</header>";    
  }
    }if($loopCount==0){
      echo "<div class='col-7 centerText'>No items found for this search term</div>";
    }}
  }
else{
  echo "
  <header class='col-7 white'>
<img src='images/video.gif' alt='Website advert image' autoplay loop>
</header>

  <div class='col-7'>
  <div class='slideshow'>
  <img  src='Images/Categories/Appliances.jpg'>
  <div class='col-4 text'>Applicances</div>
</div>
<div class='slideshow'>
  <img src='Images/Categories/Cosmetics.jpg'>
  <div class='col-4 text'>Cosmetics</div>
  </div>
  <div class='slideshow'>
  <img src='Images/Categories/Clothing.jpg'>
  <div class='col-4 text'>Fashion</div>
  </div>
  <div class='slideshow'>
  <img src='Images/Categories/Electronics.jpg'>
  <div class='col-4 text'>Electronics</div>
  </div>
  <div class='slideshow'>
  <img src='Images/Categories/Furniture.jpg'>
  <div class='col-4 text'>Furniture</div>
  </div>
  <div class='slideshow'>
  <img src='Images/Categories/Grocery.jpg'>
  <div class='col-4 text'>Groceries</div>
  </div>
  <div class='slideshow'>
  <img src='Images/Categories/Travel.jpg'>
  <div class='col-4 text'>Travel</div>
  </div>
  <div class='slideshow'>
  <img src='Images/Categories/Vehicle.jpg'>
  <div class='col-4 text'>Vehicles</div>
  </div>
</div>

";
}
?>

<hr>
<script>
var slideIndex = 0;
carousel();
// slideshow
function carousel() {
  var i;
  var x = document.getElementsByClassName("slideshow");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > x.length) {slideIndex = 1}
  x[slideIndex-1].style.display = "block";
  setTimeout(carousel, 2000); // Change image every 2 seconds
}
   </script>
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