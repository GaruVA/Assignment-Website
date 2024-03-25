<?php
    session_start();
    if(!isset($_SESSION['user_email'])) {
      header("Location: login.php");
      exit();
    }
    /*
    session_unset();
    session_destroy();
    */

    include("connection.php");

    $user_email = $_SESSION['user_email'];
    $sql_select_user = "SELECT * FROM `luxedrive_users` WHERE user_email='$user_email';";
    $result_select_user = mysqli_query($conn,$sql_select_user);
    $row_select_user = mysqli_fetch_assoc($result_select_user);
    $user_id = $row_select_user['user_id'];

    

    if(isset($_POST['submit'])){
      $order_address_street= $_POST['order_address_street'];
      $order_address_city= $_POST['order_address_city'];
      $order_address_state= $_POST['order_address_state'];
      $sql_insert_delivery = "UPDATE `luxedrive_orders` SET order_address_street='$order_address_street',order_address_city='$order_address_city',order_address_state='$order_address_state',order_confirm='confirmed'  WHERE user_id=$user_id && order_confirm='pending';";
      $result_update = mysqli_query($conn, $sql_insert_delivery);
    }

    echo "<script>alert('Order is submited Successfully')</script>";
    echo "<script>window.location.href = 'user_area/orders.php'</script>";
?>
