<?php
require_once "includes/dbh.php";

function quantityConfirm($incoming_order){
    //array sorting (might not be needed if do if/else at echo instead)
    $txt = array();
    $date = array();
    $mbc = array();
    $spc = array();
    foreach($incoming_order as $key => $value){
      if(substr_compare(substr($key,0,3) ,"TXT", 0) === 0){
        $txt[$key] = $value;
      }else if(substr_compare(substr($key,0,3) ,"DAT", 0) === 0){
        $date[$key] = $value;
      }else if(substr_compare(substr($key,0,3) ,"MBC", 0) === 0){
        $mbc[$key] = $value;
      }else if(substr_compare(substr($key,0,3) ,"SPC", 0) === 0){
        $spc[$key] = $value;
      }
    }

  //TXT array
  foreach($txt as $key => $value){
    echo substr($key,4) . ': <input type="text" name="'.$key.'" value="'.$value.'" readonly><p>';
  }
  //DAT array (probably don't need an array for this, only delivery date is in there right now)
    echo 'Delivery date: <input type="date" name="DAT_DELIV" value="'.$incoming_order['DAT_DELIV'].'" readonly><p>';
  //MBC array
  echo '<h4>Mungbean Cake: </h4>';
  foreach($mbc as $key => $value){
    echo '# of ' . strtolower(substr($key,4)) . ': <input type="number" name="'.$key.'" value="'.$value.'" readonly><p>';
  }
  echo '<h4>Specialities: </h4>';
  foreach($spc as $key => $value){
    echo '# of ' . strtolower(substr($key,4)) . ': <input type="number" name="'.$key.'" value="'.$value.'" readonly><p>';
  }
}

function quantitySelect($conn,$producttype){
    $sql = "SELECT productName FROM products WHERE productName LIKE CONCAT(?,'%');";
    $stmt = mysqli_stmt_init($conn);
  
    if (!mysqli_stmt_prepare($stmt,$sql)){
      header("location: order.php?error=stmtfailed");
      exit();
    }
  
    mysqli_stmt_bind_param($stmt, "s", $producttype);
    mysqli_stmt_execute($stmt);
  
    $resultData = mysqli_stmt_get_result($stmt);
  
    if(mysqli_num_rows($resultData) > 0){
      while($row = mysqli_fetch_assoc($resultData)){
        echo strtolower(substr($row['productName'],4)).': <select name="'.$row['productName'].'">:';
        for ($i = 0; $i <= 10; $i++) : 
          echo '<option value="'. $i.'">'. $i.'</option>';
        endfor;
      echo'</select> <p>';
       }
    }else{
      echo "No data";
    }
    mysqli_stmt_close($stmt);
  }
  
//for references
// function quantitySelect($flavour){
//   echo $flavour.': <select name="'.$flavour.'">:';
//     for ($i = 0; $i <= 10; $i++) :
//       echo '<option value="'. $i.'">'. $i.'</option>';
//     endfor;
//   echo'</select> <p>';
// }