<?php
class Category{
public function filterProducts($specify){
  // initiate MySQL database connection
    $conn = new mysqli("localhost", "root", "", "project" );
    // perform SQL injection safety code on entered variables
  $specify= mysqli_real_escape_string($conn, $specify);
  
      if($specify=="*"){
// if entered variable is * then select adverts belonging to all categories
        $sql = "SELECT * FROM advertisement";
      }
      else{
        // if entered variable is not * then select selected category
        $sql = "SELECT * FROM advertisement WHERE category='$specify'";
      }
      //run MySQL query
      $result = mysqli_query($conn, $sql);
     //Close MySQL connection
      mysqli_close($conn);
      // return generated results
  return $result;
  }
}
//instantiate the above class for use in other pages
$category=new Category();

?>