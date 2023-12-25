 <?php

class Payment{
function insertPaymentDetails(){

$it=new Item();
  $conn = new mysqli("localhost", "root", "", "project" );
  $advertID=$it->generateAdvertisementID();         
  // insert payment details into payments table 
  $query = "insert into payment (Advertisement_ID,userID) values ($advertID,".$_SESSION["user_id"].")";
  $SESSION["newAdvertID"]=$advertID;// set session value holding advertID for inserting advert tat is about to be made
  if(mysqli_query($conn, $query)){
  echo "<script>alert('Payment was successful');</script>";
  }              
  mysqli_close($conn);          
    }
}
$payment= new Payment();

?>