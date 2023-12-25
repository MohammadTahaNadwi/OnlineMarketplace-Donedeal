<?php
class Users {

function NextUserID(){
  $conn = new mysqli("localhost", "root", "", "project" );
  $query="select max(userID) as userID from users";
  $num=mysqli_query($conn, $query);
      if($num->num_rows>0){
          $row=$num->fetch_assoc();
          $row=$row["userID"];
          return $row+1; 
      }else{
          return "1";
      }
      mysqli_close($conn);
}




function register($firstName,$lastName,$phoneNumber,$email,$password) {
  // Check if the email is already taken
  $conn = new mysqli("localhost", "root", "", "Project" );
  $firstName= mysqli_real_escape_string($conn, $firstName);
$lastName= mysqli_real_escape_string($conn, $lastName);
$phoneNumber= mysqli_real_escape_string($conn, $phoneNumber);
$email= mysqli_real_escape_string($conn, $email);
$password= mysqli_real_escape_string($conn, $password);

$user=new Users();
$userID=$user->NextUserID();
  $query = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($conn, $query);
$date=date("d/m/y");
  if (mysqli_num_rows($result) > 0) {
    // The email is already taken
    echo "<div class='col-12 error centerText'>The email is already taken.</div>";
  } else {
    // The email is not taken, so create the account

    $query = "INSERT INTO users (userID,firstName,lastName,phoneNumber,email, password,dateCreated) 
    VALUES ($userID,'$firstName','$lastName','$phoneNumber','$email', '$password','$date')";
    if(mysqli_query($conn, $query)>0){
      $username =$firstName." ".$lastName;

      // Create a session for the user
      session_start();
      $_SESSION['user_id'] = $userID;
      $_SESSION['username'] = $username;
      $query="INSERT INTO useradvert (userID,AvailableAdverts) values($userID,0)";
      mysqli_query($conn, $query);
    // The account has been created
    header("Location:CustomerDashboard.php");
    }
  }
  mysqli_close($conn);
}




function login($email,$password){
  // Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
  // Redirect the user to the home page
  header('Location: CustomerDashboard.php');
}

$conn = new mysqli("localhost", "root", "", "Project" );
$email= mysqli_real_escape_string($conn, $email);
$password= mysqli_real_escape_string($conn, $password);

// Check if the form has been submitted
if (isset($_POST['email']) && isset($_POST['password'])) {
  // Get the email and password from the form
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Check if the email and password are correct
  $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
  $result = mysqli_query($conn, $sql);

  // If the email and password are correct, log the user in
  if (mysqli_num_rows($result) == 1) {
    // Get the user's id from the database
    $row = mysqli_fetch_assoc($result);
    $username = $row['Firstname']." ".$row['lastName'];

    // Create a session for the user
    session_start();
    $_SESSION['user_id'] = $row["userID"];
    $_SESSION['username'] = $username;
    
    // Redirect the user to the home page
    header('Location: CustomerDashboard.php');
  } else {
    // The email and password are incorrect
    echo "<div class='col-12 error centerText'>The email and password are incorrect.</div>";  
  }
  mysqli_close($conn);
}

}

}





include "fpdf.php";
class Admin extends Users{
function generateReport(){
$conn=new mysqli("localhost","root","","project");
$date=date("d-m-y");

$fpdf=new FPDF();
    $fpdf->AddPage();
    $fpdf->SetTextColor(158,60,61);
    $fpdf->SetFont("Arial","B",20);
    $fpdf->Cell(180,10,"Statistical report for Donedeal",0,0,'C');    
    $fpdf->SetTextColor(0,0,0);
    $fpdf->Ln(10);
    $fpdf->SetFont("Arial","",14);
    $fpdf->Cell(180,10,"Date : ".$date,0,0,'R');
    $fpdf->Ln(15);

//Get user account creation dates
$userQuery="select dateCreated as date, count(*) as usersCreated from users group by dateCreated";
$userResult=mysqli_query($conn, $userQuery);

//Get total number of users at the moment
$totalUsersQuery="select count(*) as totalUser from users";
$TotalUsers=mysqli_query($conn, $totalUsersQuery);
$totalUserCount=$TotalUsers->fetch_assoc();

if($userResult->num_rows>0){
// print count of users in the pdf for every date
 $fpdf->SetFont("Arial","B",16);
    $fpdf->Cell(190,10,"New Users",0,0,'C');
    $fpdf->Ln(10);
 $fpdf->SetFont("Arial","",14);
 $fpdf->Cell(95,10,"Date",1,);
 $fpdf->Cell(95,10,"New Users",1);
 $fpdf->Ln(10);
 while($row=$userResult->fetch_assoc()){
  $fpdf->Cell(95,10,$row["date"],1,);
  $fpdf->Cell(95,10,$row["usersCreated"],1,);

    $fpdf->Ln(10);
 }}

 $fpdf->SetFont("Arial","B",12);
 $fpdf->Cell(32,10,"Total Number of users :".$totalUserCount["totalUser"]);// print total user count
 $fpdf->Ln(15);

//Get advertisement creation dates
$advertQuery="select dateCreated as date, count(*) as advertsCreated from advertisement group by dateCreated";
$advertResult=mysqli_query($conn, $advertQuery);

//Get total number of adverts at the moment
$totalAdvertsQuery="select count(*) as totalAdverts from advertisement";
$totalAdverts=mysqli_query($conn, $totalAdvertsQuery);
$totalAdvertCount=$totalAdverts->fetch_assoc();

$fpdf->SetFont("Arial","B",16);
$fpdf->Cell(190,10,"New Adverts",0,0,'C');
$fpdf->Ln(10);

//print count of new advert details on every date
if($advertResult->num_rows>0){

  $fpdf->SetFont("Arial","",14);
  $fpdf->Cell(95,10,"Date",1,);
  $fpdf->Cell(95,10,"Products Advertised",1);
  $fpdf->Ln(10);
  while($row=$advertResult->fetch_assoc()){
    $fpdf->Cell(95,10,$row["date"],1,);
    $fpdf->Cell(95,10,$row["advertsCreated"],1,);
     $fpdf->Ln(10);
  }
}
$fpdf->SetFont("Arial","B",12);
// print total number adverts in the existing database
$fpdf->Cell(32,10,"Total Number of adverts :".$totalAdvertCount["totalAdverts"]);
$fpdf->Ln(15);

//Get quotation creation dates
$quotationQuery="select dateCreated as date, count(*) as quotationsCreated from quotation group by dateCreated";
$quotationResult=mysqli_query($conn, $quotationQuery);

//Get total number of quotations at the moment
$totalQuotationsQuery="select count(*) as totalQuotationCount from quotation";
$totalQuotations=mysqli_query($conn, $totalQuotationsQuery);
$totalQuotationCount=$totalQuotations->fetch_assoc();
$fpdf->SetFont("Arial","B",16);
$fpdf->Cell(190,10,"New quotations",0,0,'C');
$fpdf->Ln(10);

if($quotationResult->num_rows>0){
  //total number of quotations on each date
  $fpdf->SetFont("Arial","",14);
  $fpdf->Cell(95,10,"Date",1);
  $fpdf->Cell(95,10,"Quotations Generated",1);
  $fpdf->Ln(10);
  while($row=$quotationResult->fetch_assoc()){
    $fpdf->Cell(95,10,$row["date"],1);
    $fpdf->Cell(95,10,$row["quotationsCreated"],1);
     $fpdf->Ln(10);
  }}
  $fpdf->SetFont("Arial","B",12);
  // total number of quotations in database
  $fpdf->Cell(32,10,"Total Number of Quotations :".$totalQuotationCount["totalQuotationCount"]);
  $fpdf->Ln(15);

  //payment revenue
  $fpdf->SetFont("Arial","B",16);
  $fpdf->Cell(190,10,"Profits Made",0,0,'C');// total number of payments in database
  $fpdf->Ln(10);  
  $query="select count(*) as pay from payment";
  $query=mysqli_query($conn,$query);
  $row=$query->fetch_assoc();
  $fpdf->SetFont("Arial","B",12);
  $fpdf->Cell(100,10,"Total Amount revceived through payments",1,1);
  $fpdf->SetFont("Arial","",12);
  $fpdf->Cell(100,10,intval($row["pay"])*5000,1);// total payments recieved
  $fpdf->Ln(15);

  // bar chart for category of products
  $query = "SELECT category,COUNT(*) AS category_count
  FROM advertisement
  GROUP BY category";
$ans=mysqli_query($conn,$query);
$data=array();
while($result=$ans->fetch_assoc()){
$data[]=$result;
}
$fpdf->AddPage();
$fpdf->SetFont("Arial","B",16);
$fpdf->Cell(190,10,"Category Sales Chart",0,0,"C");
$fpdf->Ln(10);
$fpdf->SetFont("Arial","",12);
  $fpdf->Cell(190,10,"Chart showing number of items being sold for each category",0,0,"C");
  $fpdf->Ln(10);
$chartX=20;
$chartY=20;
$chartWidth=150;
$chartHeight=100;
$chartTopPadding=10;
$chartLeftPadding=20;
$chartBottomPadding=20;
$chartRightPadding=5;
$chartBoxX=$chartX+$chartLeftPadding;
$chartBoxY=$chartY+$chartTopPadding;
$chartBoxWidth=$chartWidth-$chartLeftPadding-$chartRightPadding;
$chartBoxHeight=$chartHeight-$chartBottomPadding-$chartTopPadding;
$barWidth=20;
$dataMax=0;
$i=0;
if(count($data)>0){
while($i<count($data)){
  if($data[$i]['category_count']>$dataMax){
    $dataMax=$data[$i]['category_count'];
  }
  $i++;
}

$fpdf->SetFont('Arial','',9);
$fpdf->SetLineWidth(0.2);
$fpdf->Rect($chartX,$chartY,$chartWidth,$chartHeight);
$fpdf->Line($chartBoxX,$chartBoxY,$chartBoxX,($chartBoxY+$chartBoxHeight));
$fpdf->Line($chartBoxX ,$chartBoxY+$chartBoxHeight,$chartBoxX+($chartBoxWidth),($chartBoxY+$chartBoxHeight));
$yAxisUnits=$chartBoxHeight/$dataMax;
for($i=0;$i<=$dataMax;$i=$i+1){
$yAxisPos=$chartBoxY+($yAxisUnits*$i);
$fpdf->Line($chartBoxX-2,$yAxisPos,$chartBoxX,$yAxisPos);
$fpdf->SetXY($chartBoxX-$chartLeftPadding,$yAxisPos-2);
$fpdf->Cell($chartLeftPadding-4,5,$dataMax-$i,0,0,'R');
}
$fpdf->SetXY($chartBoxX,$chartBoxY+$chartBoxHeight);
$xLabelWidth=$chartBoxWidth/count($data);
$barXPos=0;
$i=0;
while($i<count($data)){  
  $fpdf->Cell($xLabelWidth,5,$data[$i]['category'],0,0,'C');
$fpdf->SetFillColor(192,192,192);
$barHeight=$yAxisUnits*$data[$i]['category_count'];
$barX=($xLabelWidth/2)+($xLabelWidth*$barXPos);
$barX=$barX-($barWidth/2);
$barX=$barX+$chartBoxX;
$barY=$chartBoxHeight-$barHeight;
$barY=$barY+$chartBoxY;
$fpdf->Rect($barX,$barY,$barWidth,$barHeight,'DF');
$barXPos++;
  $i++;
}
$fpdf->SetFont('Arial','B',12);
$fpdf->SetXY($chartX,$chartY);
$fpdf->Cell(100,10,"Category Count");
$fpdf->SetXY(($chartWidth/2)-50+$chartX,$chartY+$chartHeight-($chartBottomPadding/2));
$fpdf->Cell(100,10,"Category",0,0,'C');
}
else{
  $fpdf->SetTextColor(255, 0, 0); // Red font color
  $fpdf->Cell(190,10,"Cannot produce chart because there was no adverts found",0,0,'C');
}

//save and output report
  $fileName="Statistical Report - ".time().".pdf";// set report file name
  $filePath="C:/wamp64/www/Project/Reports/";// report file path
      $fpdf->Output('F',$filePath.$fileName);// generate and save report in path      
      $query = "INSERT INTO report (date, filename) VALUES (?, ?)";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("ss", $date, $fileName);
      $stmt->execute();      
      $stmt->close();
      $fpdf->Output();
}


}

$users=new Users();

$admin=new Admin();
if(isset($_POST['getReport'])){
$admin->generateReport();
}


?>
