<?php
class Item{
  public function generateAdvertisementID(){
    $conn = new mysqli("localhost", "root", "", "project" );
$query="select max(Advertisement_ID) as NextID from payment";// select highest ID from payment table
if($num=mysqli_query($conn, $query)){
    if($num->num_rows>0){
        $row=$num->fetch_assoc();
        $row=$row["NextID"];
    }}
    $queryAd="select max(Advertisement_ID) as NextID from advertisement";// select highest ID from advertisement table
if($numAd=mysqli_query($conn, $queryAd)){
    if($numAd->num_rows>0){
        $rowAd=$numAd->fetch_assoc();
        $rowAd=$rowAd["NextID"];
    }}
if($row>=$rowAd){
  return $row+1; // return next advertisement ID
}
elseif($row<$rowAd){
  return $rowAd+1; // return next advertisement ID
}
    return 1;// return one if no adverts are present
    mysqli_close($conn);
}


public function postAdvert($brand,$productName,$price,$description,$files,$category){
  $itm=new Item();
  if(isset($_SESSION["newAdvertID"])){
  $AdvertisementID=$_SESSION["newAdvertID"];// hold next advertisement ID
  }
  else{
    $AdvertisementID=$itm->generateAdvertisementID();// hold next advertisement ID
 
  }
  $conn = new mysqli("localhost", "root", "", "project" );


  //SQL injection
  $brand= mysqli_real_escape_string($conn, $brand);
$productName= mysqli_real_escape_string($conn, $productName);
$price= mysqli_real_escape_string($conn, $price);
$description= mysqli_real_escape_string($conn, $description);
$category= mysqli_real_escape_string($conn, $category);

$allowedExtensions=array("jpeg","jpg","png");// array holding possible extensions for uploaded files
  if(isset($files)){
    foreach($files["image"]["tmp_name"] as $key=> $value){
      $imageName=$files["image"]["name"][$key];
      $imageName_tmp=$files["image"]["tmp_name"][$key];
      
      $imagePath = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));//hold extension of uploaded file

if(in_array($imagePath,$allowedExtensions)){// check if extension of file is valid
  $imageName=str_replace(".","-",basename($imageName,$imagePath));// rename image name to not have any .
  $newImageName=$imageName.time().".".$imagePath;//

  move_uploaded_file($imageName_tmp,'advertImages/'.$newImageName);// move uploaded file to website directory
$imageInsertQuery="insert into advertImages (imageName,Advertisement_ID) values ('$newImageName','$AdvertisementID')";
mysqli_query($conn,$imageInsertQuery);
}
else{
  echo "<script>alert('Failed to upload files,Please upload IMAGES only.');</script>";
}
}
  }
    if (isset($_SESSION['user_id'])) {  
    $name=$_SESSION["user_id"];
    $date=date("d/m/y");
$date=strval($date);
          $query = "INSERT INTO Advertisement (Advertisement_ID,brand,productName,price,description,dateCreated,userID,category)
           VALUES ('$AdvertisementID','$brand','$productName','$price','$description','$date','$name','$category')";
          if(mysqli_query($conn, $query)){// insert advert
            echo "<script>alert('Advert posted successfully');</script>";            
          }}
          else{
            echo "<script>alert('Failed to post advert');</script>";
          }        
        mysqli_close($conn);
}


public function updateAdvert($brand,$name,$description,$price,$id){

    $conn = new mysqli("localhost", "root", "", "project" );

    // sql code injection for variables
    $brand= mysqli_real_escape_string($conn, $brand);
    $name= mysqli_real_escape_string($conn, $name);
    $price= mysqli_real_escape_string($conn, $price);
    $description= mysqli_real_escape_string($conn, $description);
    $id= mysqli_real_escape_string($conn, $id);
    

    $query="update advertisement set brand='$brand',productName='$name',description='$description',
    price='$price' where Advertisement_ID='$id'";
        if(mysqli_query($conn, $query)){
        
          echo "<script>alert('Advert updated successfully');</script>";
header("Location:CustomerDashboard.php");
        }
        else{

          echo "<script>alert('Failed to update advert');</script>";
        }
      
      mysqli_close($conn);

}
public function deleteAdvert($advertisementId){

  $conn = new mysqli("localhost", "root", "", "project" );
  $advertisementId= mysqli_real_escape_string($conn, $advertisementId);
// delete advert accoridng to advertisement ID
    $query="delete from advertcomments where Advertisement_ID='$advertisementId'";
      if(mysqli_query($conn, $query)){
        $query="select * from advertimages where Advertisement_ID='$advertisementId'";
if($result=mysqli_query($conn, $query)){
  if ($result->num_rows > 0) {
    //output data of each row   
    while($row = $result->fetch_assoc()) {
unlink("advertImages/".$row["imageName"]);
      }
    }    
      $query="delete from advertimages where Advertisement_ID='$advertisementId'";
  if($result=mysqli_query($conn, $query)){ 
    
      $query = "DELETE from ADVERTISEMENT where Advertisement_ID='$advertisementId'"; 
    if($result=mysqli_query($conn, $query)){ 
    echo "<script>alert('Delete advert successful');</script>"; 
    }      
    else{
      
    echo "<script>alert('Failed to delete advert');</script>"; 
    }    
      }
  }     
    mysqli_close($conn);
}
}

public function loadItems($specify,$searchItem){
  $conn = new mysqli("localhost", "root", "", "project" );
  $specify= mysqli_real_escape_string($conn, $specify);
  $searchItem= mysqli_real_escape_string($conn, $searchItem);
  


if($searchItem=="user"){
    $sql = "SELECT * FROM advertisement WHERE userID='$specify'";
}
elseif($searchItem=="date"){
  $sql = "SELECT * FROM advertisement WHERE dateCreated='$specify'";
}
else{
  $sql = "SELECT * FROM advertisement WHERE Advertisement_ID='$specify'";
}

  
  $result = mysqli_query($conn, $sql);
 
  mysqli_close($conn);
return $result;

}


function loadImages($id){
  $conn = new mysqli("localhost", "root", "", "project" );
  $id= mysqli_real_escape_string($conn, $id);
  
  $query="select * from advertImages where Advertisement_ID='$id'";
 $result= mysqli_query($conn,$query);
 return $result;
 }



function searchItem($word){
  $conn = new mysqli("localhost", "root", "", "project" );
  $searchResult=array();
  $query="select * from advertisement where brand like '%".$word."%' ";
 $result= mysqli_query($conn,$query);
$searchResult[]=$result;
 
$query="select * from advertisement where productName like '%".$word."%' ";
$result= mysqli_query($conn,$query);
$searchResult[]=$result;
$query="select * from advertisement where description like '%".$word."%' ";
$result= mysqli_query($conn,$query);
$searchResult[]=$result;
  return $searchResult;
}
 
}
  $item=new Item();

if(isset($_POST["userid"])){
  $item->updateAdvert($_POST["brand"],$_POST["name"],$_POST["description"],$_POST["price"], $_POST["userid"]);
}

?>