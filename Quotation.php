<?php
include "fpdf.php";
class Quotation{
    
public function generateQuotationNumber(){
    $conn = new mysqli("localhost", "root", "", "project" );
$query="select max(quotationNumber) as quotationNumber from Quotation";
$num=mysqli_query($conn, $query);
    if($num->num_rows>0){
        $row=$num->fetch_assoc();
        $row=$row["quotationNumber"];
        return $row+1; 
    }else{
        return "1";
    }
    mysqli_close($conn);
}



function generateQuotation(){
    
// Get details of advert
    $conn = new mysqli("localhost", "root", "", "project" );
$advertQuery="select * from advertisement where Advertisement_ID='".$_SESSION["advertID"]."'";
$advertResult=mysqli_query($conn, $advertQuery);
if($advertResult->num_rows>0){
$adDetails=$advertResult->fetch_assoc();
}
//Get details of item owner
$sellerQuery="select * from users where userID=".$adDetails["userID"];
$sellerResult=mysqli_query($conn, $sellerQuery);
if($sellerResult->num_rows>0){
$sellerDetails=$sellerResult->fetch_assoc();
}
//Get details of buyer
$buyerQuery="select * from users where userID=".$_SESSION["user_id"];
$buyerResult=mysqli_query($conn, $buyerQuery);
if($buyerResult->num_rows>0){
$buyerDetails=$buyerResult->fetch_assoc();
}

    $quo=new Quotation();
    $date=date("Y-m-d");
    $num=$quo->generateQuotationNumber();//generate next quotation ID for database
    $fpdf=new FPDF();
    $fpdf->AddPage();

    // title for quotation
    $fpdf->SetFont("Arial","B",20);
    $fpdf->Cell(190,10,"Donedeal",0,0,'C');
    $fpdf->Ln(10);
    $fpdf->SetFont("Arial","",14);
    $fpdf->Cell(190,10,"Quotation Number: ".$num,0,0,'C');
    $fpdf->Ln(10);
    $fpdf->Cell(190,10,"Date: ".$date,0,0,'C');
    $fpdf->Ln(10);

    // details of the seller
    $fpdf->SetFont("Arial","B",16);
    $fpdf->Cell(20,10,"Seller Details",0);
    $fpdf->Cell(170,10,"Buyer Details",0,1,'R');
    $fpdf->SetFont("Arial","",14);
    
    $fpdf->Cell(20,10,"Name: ".$sellerDetails["Firstname"]." ".$sellerDetails["lastName"],0);
      $fpdf->Cell(170,10,"Name: ".$buyerDetails["Firstname"]." ".$buyerDetails["lastName"],0,1,'R');
  
    $fpdf->Cell(20,10,"Phone Number: ".$sellerDetails["phoneNumber"],0);
     $fpdf->Cell(170,10,"Phone Number: ".$buyerDetails["phoneNumber"],0,1,'R');    

    //details of the buyer
    $fpdf->SetFont("Arial","B",16);
    $fpdf->SetFont("Arial","",14); 
    $fpdf->Ln(10);

    // details of advert
    $fpdf->SetFont("Arial","B",16);
    $fpdf->Cell(185,10,"Item Details",1,0,'C');
    $fpdf->SetFont("Arial","",12);
    $fpdf->Ln(10);
$fpdf->Cell(35,10,"Item Number",1);
    $fpdf->Cell(150,10,$adDetails["Advertisement_ID"],1);
    $fpdf->Ln(10);
    $fpdf->Cell(35,10,"Brand",1);
     $fpdf->Cell(150,10,$adDetails["brand"],1);
     $fpdf->Ln(10);
     $fpdf->Cell(35,10,"Make",1);
    $fpdf->Cell(150,10,$adDetails["productName"],1);
    $fpdf->Ln(10);
    $fpdf->Cell(35,10,"Details ",1);
    $fpdf->Cell(150,10,$adDetails["description"],1);
    $fpdf->SetFont("Arial","B",16);
    $fpdf->Ln(10);
    $fpdf->Cell(35,10,"Total Price",1);
    $fpdf->Cell(150,10,"MWK ".$adDetails["price"],1);

$fileName="quotationNumber-".$num." - ".time().".pdf";// set quotation file name
$filePath="C:/wamp64/www/Project/Quotations/";// quotation file path
    $fpdf->Output('F',$filePath.$fileName);// generate and save quotation in path

    $buyerQuery="insert into quotation (quotationFileName,user,Advertisement_ID,dateCreated,brand,make,totalPrice)
     values('".$fileName."','".$buyerDetails["userID"]."','".$adDetails["Advertisement_ID"]."','$date',
     '".$adDetails["brand"]."','".$adDetails["productName"]."','".$adDetails["price"]."')";
    mysqli_query($conn, $buyerQuery);// insert quotation details in database

    return $fileName;
}

function loadQuotations($userID,$advertID){

//connect to MySQL database to retrieve quotations.
$conn = new mysqli("localhost", "root", "", "project" );
//query to retrieve quotations related to logged in user user
if($userID=="*"){
    $query = "select * from quotation";
}
elseif($advertID==""){
  $query = "select * from quotation where user='$userID'";
}
else{
    $query = "select quotationFileName as filename from quotation where user='$userID' and Advertisement_ID=$advertID";
  }

   if($result=mysqli_query($conn, $query)){
    $result =$result->fetch_assoc();
    if(isset($result["filename"])){
   return $result["filename"];
}
   }
   return "";
}

function validateQuotations(){
    $threeDaysAgo = date('Y-m-d', strtotime('-3 days'));
    $conn = new mysqli("localhost", "root", "", "project" );
    $query="delete from quotation where dateCreated<'$threeDaysAgo'";// delete quotations more than three days old
    mysqli_query($conn, $query);
        mysqli_close($conn);
}

}


$quotation=new Quotation();
?>