<?php 
session_start();
if(!isset($_SESSION["username"])){
  header("Location:loginInterface.php");

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Dashboard | Donedeal</title>
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
        <?php
        include "Item.php";
        include "Users.php";
        include "Category.php";
        
 include "Payment.php";
include "Feedback.php";
if (isset($_SESSION['username'])) {
echo "<p class='whitefont col-3'>@".$_SESSION['username']."</p>";
echo "<h2 class='col-6 whitefont centerText'>Dashboard</h2>";
}

//Code for running delete advert code
if(isset($_POST['deleteAdvert'])){
  $item->deleteAdvert($_POST['id']);
unset($_POST);
}

//Code for running allow advert code
if(isset($_GET["allowAdvert"])){  
$payment->insertPaymentDetails();//add payment to database
  $_SESSION["allowAdvert"]=true;
  header("Location:CustomerDashboard.php");
}

//Code for running delete review code
if(isset($_POST["dr"])){ 
  $feedback->deleteReview($_POST["dr"]);
  unset($_POST);
}

?>
      </div>
        <a href="index.php"><img src="Images/logo.jpg" class="col-1" alt="Company Logo"></a>
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

<div class="col-12 white">
    <div class="col-1">
        <nav>
<a href="#" class="col-12" id="NewAd">New Advert</a>
<a href="#" class="col-12" id="rev">Reviews</a>

<a href="#" class="col-12" id="userAdverts">Adverts</a>
<a href="#" class="col-12" id="userQuotations">Quotations</a>
<?php

if(isset($_SESSION["username"])){
// if user is an admin their username will have the word admin in it
if(strpos($_SESSION["username"], 'admin') !== false){
// if user is admin, there will be an option to load a page for generation of a report.
    echo"<a href='#' class='col-12' id='report'>Report</a>";
}}



?>
<!-- anchor button to log out -->
<a href="CustomerDashboard.php?action=EndSession" class="col-12">LogOut</a>

</nav>
</div>
<?php
//below code run when log out button is pressed
  if(isset($_GET['action'])){
    // unset all session values
    session_unset();
    //destroy the running session
    session_destroy();
    //forward to loginInterface.php after user is logged out
    header("Location:loginInterface.php");
}

// if submit button is clicked on the new advert form, the below code will run
if(isset($_POST["NewAdvert"])){
  unset($_SESSION["allowAdvert"]);
  $item->postAdvert($_POST["Brand"] , $_POST["Name"],$_POST["price"] , $_POST["description"], $_FILES,$_POST['category']);
 //clear the posted value set for insert the new advert
    $_POST=array();
}

?>
<div class="col-11">

<div class="col-12 centerText" id="AdvertPay">
  
<h1>Make an advert</h1>
  <h3><?php
  $amount=5000;
  echo "Fee for an advert is : ".$amount; ?></h3>
 <?php 
 if(!isset($_SESSION["allowAdvert"])){   
 echo"
<form action='payment/src/checkout.php' method='post'>
    <input type='text' name='price' id='price' hidden value='$amount'>
   <button type='submit' class='AdvertButton'>Pay now</button>
</form>";

 }
 else{
   
    echo "<h4>Payment has been made, click 'New Advert' to make an advert</h4>";
 }
    ?>
    
</div>
  <div class="col-12" >

<div class="col-2">
  <p></p>
</div>
<!-- form to insert a new advert-->
  <form class="col-6 centerText hidden advertUpdate" id="NewAdvertForm" action=""  method="POST" enctype="multipart/form-data">
    <h1>New Advert Form</h1>
    <label for="Brand">Brand:</label><br>
    <input type="text" id="Brand" name="Brand" required><br>
    <label for="Name">Product Name:</label><br>
    <input type="text" id="Name" name="Name" required><br>
    <label for="description">Description:</label><br>
    <textarea id="description" rows="8" name="description" required></textarea><br>
    <label for="price">Price:</label><br>
    <input type="number" id="price" name="price" required><br>
    <label for="image">Image:</label><br>
    <input type="file" id="image" name="image[]" class='AdvertButton' multiple required><br>
    <label for="category">Category:</label>
    <select name="category" id="" class='AdvertButton' required>
        <option value="Appliances">Appliances</option>
        <option value="Cosmetics">Cosmetics</option>
        <option value="Electronics">Electronics</option>
        <option value="Fashion">Fashion</option>
        <option value="Furniture">Furniture</option>
        <option value="Groceries">Groceries</option>
        <option value="Travel">Travel</option>
        <option value="Vehicles">Vehicles</option>
        <option value="Other">Other</option>
    </select>
    <input type="text" name="NewAdvert" value="insertAdvert" id="" hidden><br>
    <input type="submit" value="Submit" class='AdvertButton'>
  </form>
  </div>


  <!-- Span to show review related data-->
<span id="Reviews" class="hidden centerText">
<div class="col-12 centerText"><h1>Reviews</h1></div>
<?php 
if(strpos($_SESSION["username"], 'admin')!==false ){
    //if user is admin, load all reviews
    $answers=$feedback->loadReviews("*");
}else{
    // if user is not admin, load only those reviews that were posted by the user.
    $answers=$feedback->loadReviews($_SESSION["username"]);
}
    //print results found after loading reviews
if ($answers->num_rows > 0) {
    //output data of each row
    while($row = $answers->fetch_assoc()) {
    echo "
    <div class='col-4 advert'><strong>@".$row['userName']."</strong><p> " . $row["review"]."</p>
    <form method='POST' action='#'>
    <input type='text' name='dr' value='".$row["reviewID"]."' hidden>
    <input type='submit' class='AdvertButton' value='Delete'>
     </form></div>";
    }
    } else {
      echo "<h3 class='col-12 error centerText'>0 reviews found</h3>";
      echo "<h4 class='col-12 centerText'>To make a review go to <a href='contact.php'>Contact Us</a> page</h4>"; 
    }
?>
</span>


<!-- Span to show already existing adverts-->
<span id="adverts" class="hidden centerText">
    
<div class="col-12 centerText"><h1>Adverts</h1></div>
    <?php

//if user is admin, show all adverts
  if(strpos($_SESSION["username"], 'admin') !== false){
    $result=$category->filterProducts("*");
  }else{
    //if user is not admin, show only adverts posted by the logged in user.
$result=$item->loadItems($_SESSION["user_id"],"user");
  }
      
     if ($result->num_rows > 0) {
        //output data of each row
       
        while($row = $result->fetch_assoc()) {
            //output all user related adverts in form of a table.
              
               echo "<header>";
                $image=$item->loadImages($row["Advertisement_ID"]);
                if($image=$image->fetch_assoc()){   
              
            
          echo "
          <div class='col-4 centerText advert'><img src='advertImages/".$image["imageName"]."'><form action='update.php'
           method='POST'><table class='col-12'>
          <tr><td>Brand:</td><td><input type='text' value='".$row['brand']."' name='brand' readonly></td></tr>
          <tr><td>Product Name:</td><td><input type='text' value='".$row['productName']."' name='name' readonly></td></tr>
          <tr><td>Price:</td><td><input type='text' value='".$row['price']."' name='price' readonly></td></tr>
          <tr><td>Description:</td><td><textarea  name='description' readonly>".$row['description']."</textarea></td></tr>
          <tr><td>Date:</td><td><input type='text' value='".$row['dateCreated']."' readonly></td></tr>
          <tr><td>User ID:</td><td><input type='text' value='".$row['userID']."' readonly></td></tr>
          <tr><td>Category:</td><td><input type='text' value='".$row['category']."' name='' readonly></td></tr>
          <input type='text'value='".$row["Advertisement_ID"]."' name='id' hidden>

          <tr><td>";
          if($_SESSION["user_id"]==$row['userID']){
          echo"<input type='submit' class='AdvertButton' value='Update'>";
          }
          echo "</td><td></form><form action='#' method='POST'>
          <input type='text' value='".$row["Advertisement_ID"]."' name='id' hidden>
          <input type='submit' value='Delete' class='AdvertButton' name='deleteAdvert'></form>
          </table></div>
          ";
echo "</header>";
        }
      
        }
        } else {
            // if no posts were found, print the message below
      echo "<h3 class='col-12 error centerText'>No posts by you</h3>";
        }  
        
        
        
        

?>

</span>

<!-- below span shows quotation related data -->
<span class="hidden centerText" id="quotations">
  
<div class="col-12 centerText"><h1>Quotations</h1></div>

<div class="col-12 error centerText"><p>Be informed: Quotations will expire after 3 days of generating</p></div>

<?php
$conn = new mysqli("localhost", "root", "", "project" );
//query to retrieve quotations related to logged in user user

if(strpos($_SESSION["username"], 'admin') !== false){
  //show all quotations if user is an admin
 $query = "select * from quotation";
}
else{
    //show user related quotations if user is not an admin
  $query = "select * from quotation where user='".$_SESSION["user_id"]."'";
}
   $result=mysqli_query($conn, $query);
   
   if($result->num_rows>0){
   while($row=$result->fetch_assoc()){
    $fileName=$row["quotationFileName"];
    // print links to quotations found in database.
    echo "
    <table class='col-4 quotationInfo'>
    <tr class='quotationTitle'><td>Quotation Number</td><td>".$row["quotationNumber"]."</td></tr>
    <tr class='quotationTitle'><td>Date</td><td>".$row["dateCreated"]."</td></tr>
    <tr class='quotationTitle'><td>Item Number</td><td> ".$row["Advertisement_ID"]."</td></tr>
    <tr class='quotationTitle'><td>Brand </td><td> ".$row["brand"]." </td></tr>
    <tr class='quotationTitle'><td>Make </td><td> ".$row["make"]."</td></tr>
    <tr class='quotationTitle'><td>Total Price </td><td> ".$row["totalPrice"]."</td></tr>
    <tr class='quotationTitle'><td>Quotation </td><td> <a href='Quotations/".$fileName."'> ".$fileName."</a></td></tr>
    </table>
    

    
    
    ";
   }
  }
else{
  echo "<div class='col-12 error centerText'>There was no quotations generated by you</div>";
}
?>

</span>    
<!-- Span for holding information about statistical reports-->
<span class="hidden centerText" id="reportContent">

<h1>Statistical Report</h1>
<p>Click the button below to view a statistical report for the website</p>
<form action="Users.php" method="POST">
  <input type="submit" name="getReport" class="AdvertButton" value="Get Report">
</form>
<div class="col-12">
  <h1>Previous Reports</h1>
  <?php
$conn = new mysqli("localhost", "root", "", "Project" );
$query = "SELECT * FROM report";
$result = $conn->query($query);

if($result->num_rows>0){
  while($row=$result->fetch_assoc()){
   // print links to quotations found in database.
   echo "
   <table class='col-4 quotationInfo'>
   <tr class='quotationTitle'><td>Date</td><td>".$row["date"]."</td></tr>
   <tr class='quotationTitle'><td>Report </td><td> <a href='Reports/".$row["fileName"]."'> ".$row["fileName"]."</a></td></tr>
   </table>
   ";
  }
 }
 else{
  
  echo "<div class='col-12 error centerText'>There was no reports found in the database</div>";
  
 }
  ?>
</div>
</span>

</div>
</div>


<script>
//Javascript code to manage view
//hold action buttons in javascript variables.
let NewAdButton=document.getElementById('NewAd');
let reviewsButton=document.getElementById('rev');
let showUserAds=document.getElementById('userAdverts');
let showQuotations=document.getElementById('userQuotations');
let report=document.getElementById('report');

// to hold span tags where different data will be displayed
let adForm=document.getElementById('NewAdvertForm');
let reviewsLoad=document.getElementById('Reviews');
let advertsLoad=document.getElementById('adverts');
let loadQuotations=document.getElementById('quotations');
let reportContent=document.getElementById('reportContent');
let AdvertPay=document.getElementById('AdvertPay');



// show New Advert Form

NewAdButton.addEventListener('click',()=>{
  <?php
  if(isset($_SESSION["allowAdvert"]) || str_contains($_SESSION['username'],'admin')){
     echo "adForm.style.display='block';
     AdvertPay.style.display='none';";
  }
  else {
    echo "
     AdvertPay.style.display='block';";
  }
  ?>
    
 
    reviewsLoad.style.display="none";
    advertsLoad.style.display="none";
    loadQuotations.style.display="none";
    reportContent.style.display="none";
    
  });

// view reviews
reviewsButton.addEventListener('click',()=>{
    adForm.style.display="none";

    AdvertPay.style.display="none";
    reviewsLoad.style.display="block";
    advertsLoad.style.display="none";
    loadQuotations.style.display="none";
    reportContent.style.display="none";
});

// view user related adverts
showUserAds.addEventListener('click',()=>{

    adForm.style.display="none";
    reviewsLoad.style.display="none";
    advertsLoad.style.display="block";
    loadQuotations.style.display="none";
    reportContent.style.display="none";
    
    AdvertPay.style.display="none";

}


);

// view quotations
showQuotations.addEventListener('click',()=>{

    adForm.style.display="none";
    reviewsLoad.style.display="none";
    advertsLoad.style.display="none";
    loadQuotations.style.display="block";
    reportContent.style.display="none";
     AdvertPay.style.display="none";

});

// view reports generation button
report.addEventListener('click',()=>{
    adForm.style.display="none";
    reviewsLoad.style.display="none";
    advertsLoad.style.display="none";
    loadQuotations.style.display="none";
    reportContent.style.display="block";
    
     AdvertPay.style.display="none";
});


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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>