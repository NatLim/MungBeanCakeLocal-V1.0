<?php
include_once 'header.php';
require_once "includes/dbh.php";
require_once "includes/dbfunction.php";

if (isset($_POST["submit2"])){
  $incoming_order = array();
  $incoming_order = $_POST;
  $name = $_POST["TXT_NAME"];
  $deliv_date = $_POST["DAT_DELIV"];

  //FUTURE: add some sort of input validation (empty input) later
/*
  if (emptyInputForm($name) !== false) {
    header("location: order.php?error=emptyinput");
    exit();
*/

  //filtering $incoming_order FUTURE: optimize addingorderdetails so this is not needed
  $product_order = array();
  foreach($incoming_order as $key => $value){
    if(substr_compare(substr($key,0,3) ,"MBC", 0) === 0){
      $product_order[$key] = $value;
    }else if(substr_compare(substr($key,0,3) ,"SPC", 0) === 0){
      $product_order[$key] = $value;
    }
  }

  $orderID = addOrder($conn,$name,$deliv_date);

  foreach($product_order as $product => $quantity){
    if($quantity > 0){
      addOrderDetails($conn,$orderID,$product,$quantity);
    }
  }
?>

  <div class="confirm-complete">
    <h2> Order submitted </h2>
    <h4> Order total: $<?= getPrice($conn,$orderID); ?></h4><br>
    <a href="index.php"><button type="button">Return Home</button></a><br>
    <a href="order.php"><button type="button">Order Again</button></a>
  </div>
<?php
  }
  else{
  header("location: order.php");
  exit();
}

include_once 'footer.php';
 ?>
