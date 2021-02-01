<?php
  include_once 'header.php';
  require_once "includes/dbh.php";
  require_once "includes/dbfunction.php";
  require_once "includes/generalfunction.php";

  $sql = "SELECT * FROM orders ORDER BY orderID DESC;";
  $resultData = mysqli_query($conn, $sql);


  //no need to bind, since no parameter = no injection
  /*
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt,$sql)){
    header("location: status.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);
*/
?>

<h2>Order status</h2>

  <table class="tableFixHead">
    <tr>
      <th>Name</th>
      <th>Order Date</th>
      <th>Delivery Date</th>
    </tr>
    <?php
    //if($resultData){
    if(mysqli_num_rows($resultData) > 0){
      while($row = mysqli_fetch_assoc($resultData)){
        echo "<tr><td>$row[orderName]</td><td>". dateCheck($row['orderDate']) ."</td><td>".dateCheck($row['deliveryDate'])."</td></tr>";
       }
    }else{
      echo "No data";
    }
     ?>
  </table>

<?php
  include_once 'footer.php'
?>
