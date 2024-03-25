<?php 
    if(isset($_GET["edit"])) {
        $order_id = $_GET["edit"];
        $sql_select_order = "SELECT * FROM `luxedrive_orders` WHERE order_id=$order_id;";
        $result_select_order = mysqli_query($conn,$sql_select_order);
        $row_select_order = mysqli_fetch_assoc($result_select_order);
        $user_id = $row_select_order["user_id"];
        $order_invoice = $row_select_order["order_invoice"];
        $product_id = $row_select_order["product_id"];
        $order_status = $row_select_order["order_status"];
        $order_from = $row_select_order["order_from"];
        $order_to = $row_select_order["order_to"];
        $order_duration = $row_select_order["order_duration"];
        $order_paid = $row_select_order["order_paid"];
        $order_amount = $row_select_order["order_amount"];
        $order_payment = $row_select_order["order_payment"];
        $order_address_street = $row_select_order["order_address_street"];
        $order_address_state = $row_select_order["order_address_state"];
        $order_address_city = $row_select_order["order_address_city"];

        $sql_select_users = "SELECT * FROM `luxedrive_users` WHERE user_id=$user_id";
        $result_select_users = mysqli_query($conn,$sql_select_users);
        $row_select_users = mysqli_fetch_assoc($result_select_users);
        $user_email = $row_select_users["user_email"];

        $sql_select_products = "SELECT * FROM `luxedrive_products` WHERE product_id=$product_id";
        $result_select_products = mysqli_query($conn,$sql_select_products);
        $row_select_products = mysqli_fetch_assoc($result_select_products);
        $product_name = $row_select_products["product_name"];
    }
    if(isset($_POST["update"])) {
        $new_order_paid = $_POST["order_paid"];
        $new_order_status = $_POST["order_status"];
        $new_order_payment = $_POST["order_payment"];
        $sql_update_order="UPDATE `luxedrive_orders` SET order_paid=$new_order_paid,order_status='$new_order_status',order_payment='$new_order_payment' WHERE order_id='$order_id'";
        $result_update_order = mysqli_query($conn,$sql_update_order);
        if ($result_update_order) {
            echo "<script>alert('Success: Order \"$order_invoice\" has been updated.'); window.location.href = 'orders.php?view';</script>";
        } else {
            echo "<script>alert('Error: Unable to order the user at the moment. Please try again later.');</script>";
        }
    }
?>


<form action="" method="post" enctype="multipart/form-data" class="p-4">
    <h2 class="mb-4">Order Info</h2>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="order_invoice" class="form-label">Invoice:</label>
            <input type="text" id="order_invoice" name="order_invoice" value="<?php echo $order_invoice?>" class="form-control" required disabled>
        </div>

        <div class="col-md-6">
            <label for="product_name" class="form-label">Vehical:</label>
            <input type="text" id="product_name" name="product_name" value="<?php echo $product_name?>" class="form-control" required disabled>
        </div>
    </div>

    <div class="mb-3">
        <label for="user_email" class="form-label">User:</label>
        <input type="text" id="user_email" name="user_email" value="<?php echo $user_email?>" class="form-control" required disabled>
    </div>

    <div class="row mb-3 mt-3">
        <div class="col-md-4">
            <label for="order_from" class="form-label">Pickup Date:</label>
            <input type="date" id="order_from" name="order_from" min="<?php echo $current_date;?>" value="<?php echo $order_from;?>" class="form-control" required disabled>
        </div>

        <div class="col-md-4">
            <label for="order_to" class="form-label">Return Date:</label>
            <input type="date" id="order_to" name="order_to" min="<?php echo $order_from;?>" value="<?php echo $order_to;?>" class="form-control" required disabled>
        </div>
        <div class="col-md-4">
            <label for="order_duration" class="form-label">Number of Days:</label>
            <input type="number" id="order_duration" name="order_duration" value="<?php echo $order_duration;?>" class="form-control" required disabled>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
        <label for="order_amount" class="form-label">Amount:</label>
        <input type="number" id="order_amount" name="order_amount" value="<?php echo $order_amount?>" class="form-control" required disabled>
        </div>
        <div class="col-md-6">
        <label for="order_paid" class="form-label">Paid:</label>
        <input type="number" id="order_paid" name="order_paid" value="<?php echo $order_paid?>" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
        <label for="order_status" class="form-label">Status:</label>
        <select id="order_status" name="order_status" class="form-select" required>
            <?php
                    if($order_status == 'pending') {
                        echo "<option value='pending' selected>pending</option>";
                    } else {
                        echo "<option value='pending'>pending</option>";
                    }
                    if($order_status == 'processing') {
                        echo "<option value='processing' selected>processing</option>";
                    } else {
                        echo "<option value='processing'>processing</option>";
                    }
                    if($order_status == "completed") {
                        echo "<option value='completed' selected>completed</option>";
                    } else {
                        echo "<option value='completed'>completed</option>";
                    }
                    if($order_status == "cancelled") {
                        echo "<option value='cancelled' selected>cancelled</option>";
                    } else {
                        echo "<option value='cancelled'>cancelled</option>";
                    }
            ?>
        </select>
        </div>
        <div class="col-md-6">
        <label for="order_payment" class="form-label">Payment:</label>
        <select id="order_payment" name="order_payment" class="form-select" required>
            <?php
                    if($order_payment == 'paid') {
                        echo "<option value='paid' selected>paid</option>";
                    } else {
                        echo "<option value='paid'>paid</option>";
                    }
                    if($order_payment == 'pending') {
                        echo "<option value='pending' selected>pending</option>";
                    } else {
                        echo "<option value='pending'>pending</option>";
                    }
            ?>
        </select>
        </div>
    </div>

    <div class="mb-3">
        <label for="order_address_street" class="form-label">Street Address:</label>
        <input type="text" id="order_address_street" name="order_address_street" value="<?php echo $order_address_street?>" class="form-control" required disabled>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
        <label for="order_address_state" class="form-label">State:</label>
        <input type="text" id="order_address_state" name="order_address_state" value="<?php echo $order_address_state?>" class="form-control" required disabled>
    </div>

    <div class="col-md-6">
        <label for="order_address_city" class="form-label">City:</label>
        <input type="text" id="order_address_city" name="order_address_city" value="<?php echo $order_address_city?>" class="form-control" required disabled>
    </div>
    </div>

    <div class="buttons">
    <a href="orders.php?view" class="left"><i class="fa-solid fa-arrow-left"></i> Back</a>
    <button type="submit" name="update" class="btn btn-custom">UPDATE ORDER</button>
    <a href="orders.php?delete=<?php echo $order_id?>" class="btn btn-danger">Delete Order</a>
    </div>
</form>