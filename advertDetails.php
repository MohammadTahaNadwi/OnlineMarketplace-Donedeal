<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Advert | Donedeal</title>
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


  include "Feedback.php";

  //run insert advert comment
  if(isset($_POST["insertComment"]) && isset($_SESSION["username"])){
    if(strlen($_POST["review"])<=500){
  $feedback->insertAdvertComment($_POST["review"],$_SESSION["advertID"],$_SESSION["username"]);
    }
    else{      
      echo "<script> alert('Comment length is too long');</script>";
    }
  }
// run delete comment code
  if(isset($_POST["deleteComment"])){
    $feedback->deleteAdvertComment($_POST["deleteComment"]);
  }
?>

    </header>
    <hr>
    <div class="col-12 centerText"><h1>Advert Details</h1></div>
<div class="col-2"><p></p></div>

<?php
// import the php files needed to run the codes below
include "Item.php";
include "Quotation.php";
if(isset($_POST["advertID"])){
$_SESSION["advertID"]=$_POST["advertID"];
unset($_POST["advertID"]);
}
if(isset($_SESSION["advertID"])){
    //load advert to which the posted ID belongs
$result=$item->loadItems($_SESSION["advertID"],"ad");
        
if ($result->num_rows > 0) {
   //output data 
   $row = $result->fetch_assoc();
   $image=$item->loadImages($_SESSION["advertID"]);
 if($img=$image->fetch_assoc()){
    while($img) {
       echo "  <div class='col-8'>
       <div class='adSlideshow'>
       <img  src='advertImages/".$img["imageName"]."'>
     </div>
     
  <a class='prev' onclick='plusSlides(-1)'>&#10094;</a>
  <a class='next' onclick='plusSlides(1)'>&#10095;</a>
     </div>
";
       $img=$image->fetch_assoc();
   }}
     echo "<div class='col-4'><p></p></div>
     <table class='col-4'>
     <tr><td>Brand </td><td> ".$row['brand']."</td></tr>
     <tr><td>Product Name </td><td> ".$row['productName']."</td></tr>
     <tr><td>Price </td><td> ".$row['price']."</td></tr>
     <tr><td>Description </td><td> ".$row['description']."</td></tr>
     <tr><td>Date </td><td> ".$row['dateCreated']."</td></tr>
     <tr><td>Category </td><td> ".$row['category']."</td></tr>
     </table>";
     // if user is not logged disallow the generation of a quotation by removing 'Generate Quotation' button
    if(isset($_SESSION['user_id'])){
     echo "<h2 class='col-12 centerText'>Willing to buy? </h2> "; 
    }else{
        echo "<h3 class='col-12 centerText'>Please log in to generate quotation</h3>";
    }
 
   
   }}
   //when user clicks generate quotation, the below code runs and produces a quotation.
   if(isset($_SESSION["user_id"])){
   $fileName=$quotation->loadQuotations($_SESSION["user_id"],$_SESSION["advertID"]);
   
if(!$fileName==false){
     echo "<a class='col-12 centerText' href='Quotations/".$fileName."' >".$fileName."</a>";

}
   elseif(isset($_GET["generateQuotation"]) && $fileName==false){

   $fileName=$quotation->generateQuotation();
 
     echo "<a class='col-12 centerText' href='Quotations/".$fileName."' >".$fileName."</a>";
    }
    else{
      echo "<form action='#' method='GET' class='col-12 centerText'>
      <input type='submit' name='generateQuotation'  class='AdvertButton' value='Generate Quotation'>
      </form>";
    }}

   
?>

<div class="col-12 error centerText"><p>Be informed: Quotations will expire after 3 days of generating</p></div>


<hr>
<h2 class='col-12 centerText'>Customer Comments</h2>
<?php
if(isset($_SESSION["advertID"])){
    //load advert to which the posted ID belongs
$result=$feedback->loadAdvertComments($_SESSION["advertID"]);
        
if ($result->num_rows > 0) {
   //output data 
   while($row = $result->fetch_assoc()){
   echo "<div class='col-12'><div class='col-3'><p></p></div><div class='col-6 leftAlign comment'>
   <p><strong>@".$row['username']."</strong></p>
   <h5>Date: ".$row['Date']."</h5>
   <p> Comment : " . $row["Comment"]."</p>
   ";
   if(str_contains($_SESSION["username"],"admin") ||$row['username']===$_SESSION["username"] ){
   echo "<p><form action='#' method='POST'>
   <input type='text' value='".$row["ID"]."' name='deleteComment' hidden>
   <input type='submit' class='AdvertButton' value='Delete Comment'>
   </form>
   </p></div></div>";   
   }
}}else{
  echo "<div class='col-12 centerText'>Customers have not commented on this product</div>";
}
}
?>



<h2 class='col-12 centerText'>Make a comment</h2>
<div class="col-4"><p></p></div>
<form class='col-4 centerText' action="#" method="POST" >
<?php
if(!isset($_SESSION["user_id"])){    
    echo "<h4>Please log in to send feedback</h4>";
}
?>
<textarea name="review" placeholder="Your Message" rows="8" required></textarea>
<input type="submit" value="Add Comment" class="AdvertButton">
<input type="text" name="insertComment" value="insert" id="" hidden>
</form>


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
<script>
let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("adSlideshow");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }

  slides[slideIndex-1].style.display = "block";
}

</script>
</body>
</html>