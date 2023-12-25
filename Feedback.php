
<?php
 
class Feedback{
function addReview($userName,$review){  
    if (isset($_SESSION['username'])) {  
    $conn = new mysqli("localhost", "root", "", "project" );
$userName= mysqli_real_escape_string($conn, $userName);
$review=mysqli_real_escape_string($conn, $review);
      $query = "INSERT INTO reviews (userID,userName,review) VALUES (".$_SESSION["user_id"].",'$userName','$review')";
      if(mysqli_query($conn, $query)){  
      echo "<script>alert('Review inserted succesfully')</script>";      
      header('Location:reviews.php');
      }
    else{      
      echo "<script>alert('Failed to insert Review')</script>";      
      header('Location:contact.php');
    }
    }
      else{
        header('Location:loginInterface.php');
      }    
    mysqli_close($conn);
}


function insertAdvertComment($comment,$advertID,$userName){  
  if (isset($_SESSION['username'])) {  
  $conn = new mysqli("localhost", "root", "", "project" );
  $date=date("d-m-y");
$comment=mysqli_real_escape_string($conn, $comment);
$advertID=mysqli_real_escape_string($conn, $advertID);
$userName= mysqli_real_escape_string($conn, $userName);
    $query = "INSERT INTO advertcomments (date,comment,advertisement_ID,userName,userID)
     VALUES ('$date','$comment',$advertID,'$userName',".$_SESSION["user_id"].")";
    if(mysqli_query($conn, $query)){
header("Location:advertDetails.php");
    }
  }  
  mysqli_close($conn);
}


public function loadReviews($specify){
 
  $conn = new mysqli("localhost", "root", "", "project" );
 $specify= mysqli_real_escape_string($conn, $specify);
    if($specify=="*"){
      $sql = "SELECT * FROM reviews";
    }
    else{
      $sql = "SELECT * FROM reviews WHERE userName='$specify'";
    }
    
    $result = mysqli_query($conn, $sql);
    $answers=$result;
    mysqli_close($conn);
return $answers;
}

public function loadAdvertComments($advertID){
 
  $conn = new mysqli("localhost", "root", "", "project" );
 
      $sql = "SELECT * FROM advertComments WHERE Advertisement_ID='$advertID'";
    
    
    $result = mysqli_query($conn, $sql);
    $answers=$result;
    mysqli_close($conn);
return $answers;
}

public function deleteReview($reviewId){
  $conn = new mysqli("localhost", "root", "", "project" );
  $reviewId= mysqli_real_escape_string($conn, $reviewId);
      $query = "DELETE from reviews where reviewID='$reviewId'";// delete advert accoridng to advertisement ID 
      if(mysqli_query($conn, $query)){      
  echo "<script>alert('Review deleted');</script>";
      }
      else{        
        echo "<script>alert('Failed to delete review');</script>";
            }
    mysqli_close($conn);
}

public function deleteAdvertComment($commentId){
  $conn = new mysqli("localhost", "root", "", "project" );
  $commentId= mysqli_real_escape_string($conn, $commentId);
      $query = "DELETE from advertcomments where ID='$commentId'";// delete advert accoridng to advertisement ID 
      if(mysqli_query($conn, $query)){      
  echo "<script>alert('Comment deleted');</script>";
      }else{        
  echo "<script>alert('Failed to delete comment');</script>";
      }    
    mysqli_close($conn);
}

}
$feedback= new Feedback();


?>