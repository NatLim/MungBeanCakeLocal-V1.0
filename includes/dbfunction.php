<?php
//product ID

date_default_timezone_set("America/Vancouver");

//return orderID
function addOrder($conn,$name,$deliv_date){
  //convert date into SQL format
  $delivDateConv = date("Y-m-d", strtotime($deliv_date));

  $sql = "INSERT INTO orders (orderName, orderDate, deliveryDate) VALUES (?, NOW() ,?);";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt,$sql)){
    header("location: order.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ss", $name , $delivDateConv);
  mysqli_stmt_execute($stmt);

  $order_id = mysqli_insert_id($conn);

  // INSERT OUTPUT doesn't works, so the query doesn't return anythin from database
  //$resultData = mysqli_stmt_get_result($stmt);

/*
  if ($row = mysqli_fetch_assoc($resultData)){
    //return TRUE if there is data, or if the request match database I THINK (look more into this)
    return $row;
  }else {
    $result = false;
    return $result;
  }
*/
  mysqli_stmt_close($stmt);
  return $order_id;
}

function addOrderDetails($conn,$orderID,$product,$quantity){
  $sql = "INSERT INTO orderdetails (orderID, productName, orderQuantity) VALUES (?, ? ,?);";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt,$sql)){
    header("location: order.php?error=stmtfailed2");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "sss", $orderID , $product, $quantity);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

function getPrice($conn,$orderID){
  //get total price of an orderID
  $sql = "SELECT orderQuantity,productPrice from orderdetails left join products on orderdetails.productName=products.productName where orderID=?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt,$sql)){
    header("location: order.php?error=stmtfailed2");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $orderID);
  mysqli_stmt_execute($stmt);
  
  $resultData = mysqli_stmt_get_result($stmt);

  if(mysqli_num_rows($resultData) > 0){
    $result = 0;
    while($row = mysqli_fetch_assoc($resultData)){
      $result += $row['orderQuantity'] * $row['productPrice'];
     }
  }else{
    $result = NULL;
  }

  mysqli_stmt_close($stmt);
  return $result;
}

function getPriceProductName ($conn,$productName){
  //get price of individual product
  $sql = "select productPrice from products where productName=?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt,$sql)){
    header("location: order.php?error=stmtfailed2");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $productName);
  mysqli_stmt_execute($stmt);
  
  $resultData = mysqli_stmt_get_result($stmt);

  if(mysqli_num_rows($resultData) > 0){
    $row = mysqli_fetch_assoc($resultData);
    $result = $row['productPrice'];
   }

  mysqli_stmt_close($stmt);
  return $result;
}

function getPriceTemp($conn,$productName,$productQuantity){
  $price = getPriceProductName($conn,$productName);
  $result = $price * $productQuantity;
  return $result;
}

//echo function
function getOrderDetails($conn,$orderID){
  $details = "";
  $sql = "SELECT productName, orderQuantity FROM orderdetails WHERE orderID = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt,$sql)){
    header("location: order.php?error=stmtfailed2");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $orderID);
  mysqli_stmt_execute($stmt);
  
  $resultData = mysqli_stmt_get_result($stmt);
  
  if(mysqli_num_rows($resultData) > 0){
     while($row = mysqli_fetch_assoc($resultData)){
       $details .= strtolower(substr($row['productName'],4)) . " : " . $row['orderQuantity'] . "  ";
    }
  }
  mysqli_stmt_close($stmt);
  return $details;
}