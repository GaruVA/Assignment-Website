<?php
    if(isset($_GET["edit"])) {
        $product_id = $_GET["edit"];
        $sql_select_product = "SELECT * FROM `luxedrive_products` WHERE product_id=$product_id;";
        $result_select_product = mysqli_query($conn,$sql_select_product);
        $row_select_product = mysqli_fetch_assoc($result_select_product);
        $product_name = $row_select_product["product_name"];
        $product_per_day = $row_select_product["product_per_day"];
        $product_excess_mileage = $row_select_product["product_excess_mileage"];
        $product_category_id = $row_select_product["category_id"];
        $product_desc = $row_select_product["product_desc"];
        $product_image = $row_select_product["product_image"];
        $product_keywords = $row_select_product["product_keywords"];
        $product_status = $row_select_product["status"];
    }
    if(isset($_POST["update"])){
        $new_product_name = $_POST["product_name"];
        $new_product_per_day = $_POST["product_per_day"];
        $new_product_excess_mileage = $_POST["product_excess_mileage"];
        $new_product_category = $_POST["product_category"];
        $new_product_desc = $_POST["product_desc"];
        $new_product_image = $_FILES["product_image"]["name"];
        $new_product_tmpimage = $_FILES["product_image"]["tmp_name"];
        $new_product_keywords = $_POST["product_keywords"];
        $new_product_status = $_POST["product_status"];

        if (!empty($new_product_image)) {
            move_uploaded_file($new_product_tmpimage, "../images/$new_product_image");
        } else {
            $new_product_image = $product_image;
        }
        $sql_update_product = "UPDATE `luxedrive_products` SET product_name='$new_product_name',product_per_day=$new_product_per_day,product_excess_mileage=$new_product_excess_mileage,category_id=$new_product_category,product_desc='$new_product_desc',product_image='$new_product_image',product_keywords='$new_product_keywords',status='$new_product_status' WHERE product_id=$product_id;";
        $result_update_product = mysqli_query($conn, $sql_update_product);
        if ($result_update_product) {
            echo "<script>alert('Success: Product \"$product_name\" has been updated.'); window.location.href = 'products.php?view';</script>";
        } else {
            echo "<script>alert('Error: Unable to update the product at the moment. Please try again later.');</script>";
        }
        }
?>
<form action="" method="post" enctype="multipart/form-data" class="p-4">
    <h2 class="mb-4">Vehicle Info</h2>
    <div class="row mb-3">
        <div class="col-md-8">
            <label for="productName" class="form-label">Vehicle Name:</label>
            <input type="text" id="productName" name="product_name" value="<?php echo $product_name;?>" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label for="category" class="form-label">Category:</label>
            <select id="category" name="product_category" class="form-select" required>
                <?php
                $sql_select_categories = "SELECT * FROM `luxedrive_categories`;";
                $result_categories = mysqli_query($conn, $sql_select_categories);
    
                if (mysqli_num_rows($result_categories) > 0) {
                    while ($category = mysqli_fetch_assoc($result_categories)) {
                        $category_id = $category['category_id'];
                        $category_name = $category['category_name'];
                        if($category_id == $product_category_id) {
                            echo "<option value=$category_id selected>$category_name</option>";
                        } else {
                            echo "<option value=$category_id>$category_name</option>";
                        }
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="product_per_day" class="form-label">Per Day(80km):</label>
            <input type="number" id="product_per_day" name="product_per_day" value="<?php echo $product_per_day;?>" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="product_excess_mileage" class="form-label">Excess Mileage:</label>
            <input type="number" id="product_excess_mileage" name="product_excess_mileage" value="<?php echo $product_excess_mileage;?>" class="form-control" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description:</label>
        <textarea id="description" name="product_desc" rows="4" class="form-control" required><?php echo $product_desc;?></textarea>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image:</label>
        <input type="file" id="image" name="product_image" class="form-control" accept="image/*">
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
        <label for="keywords" class="form-label">Keywords (comma-separated):</label>
        <input type="text" id="keywords" name="product_keywords" value="<?php echo $product_keywords;?>" class="form-control" required>
        </div>
        <div class="col-md-6">
        <label for="status" class="form-label">Status:</label>
        <select id="status" name="product_status" class="form-select" required>
            <?php
                    if($product_status == 'available') {
                        echo "<option value='available' selected>available</option>";
                    } else {
                        echo "<option value='available'>available</option>";
                    }
                    if($product_status == 'reserved') {
                        echo "<option value='reserved' selected>reserved</option>";
                    } else {
                        echo "<option value='reserved'>reserved</option>";
                    }
            ?>
        </select>
    </div>
    </div>

    <div class="buttons">
    <a href="products.php?view" class="left"><i class="fa-solid fa-arrow-left"></i> Back</a>
    <button type="submit" name="update" class="btn btn-custom">UPDATE VEHICLE</button>
    <a href="products.php?delete=<?php echo $product_id?>" class="btn btn-danger">Delete Vehicle</a>
    </div>
</form>

