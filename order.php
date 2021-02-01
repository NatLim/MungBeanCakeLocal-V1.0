<?php
  include_once 'header.php';
  require_once "includes/orderfunction.php";
  
  $incoming_order = array();  //could initialize array with 0 value and determined key to eliminate $name and $deliv_date
  $name = "";
  $deliv_date = "";

  if(isset($_POST['submit1'])){
    $incoming_order = $_POST;
    $name = $_POST["TXT_NAME"];
    $deliv_date = $_POST["DAT_DELIV"];
?>

  <section class="order-form-confirm">
  <h2>Order Confirmation</h2>
    <form action="confirm.php" method="post">
      <?php quantityConfirm($incoming_order); ?>
      <button type="submit" name="submit2">confirm</button> <p>
    </form>
    <br><small>*Make change below if needed</small>
  </section>
  <?php
    }
   ?>

  <section class="order-form">
    <?php if(isset($_POST['submit1'])){ ?>
    <h2>Modify Order</h2>
  <?php }else{ ?>
    <h2>New Order</h2> <?php } ?>
    <form method="post">
      Name: <input type="text" name="TXT_NAME" value="<?= $name ?>"><p>
      Delivery date: <input type="date" name="DAT_DELIV" value="<?= $deliv_date ?>"><p>
    <h4>Mungbean Cake: </h4>
    <?php quantitySelect($conn,"MBC"); ?>
    <h4>Specialities: </h4>
    <?php quantitySelect($conn,"SPC"); ?>

<!---
        Original: <select name="original">
          <?php for ($i = 0; $i <= 10; $i++) : ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
          <?php endfor; ?>
        </select> <p>
--->
      <button type="submit" name="submit1">submit</button> <p>
      <button type="submit" name="reset">reset</button>
    </form>
  </section>


<?php
  include_once 'footer.php'
?>
