<?php
    if(isset($_POST["submit"])){
        $product_name = $_POST["product_name"];
        $product_per_day = $_POST["product_per_day"];
        $product_excess_mileage = $_POST["product_excess_mileage"];
        $product_category = $_POST["product_category"];
        $product_desc = $_POST["product_desc"];
        $product_image = $_FILES["product_image"]["name"];
        $product_tmpimage = $_FILES["product_image"]["tmp_name"];
        $product_keywords = $_POST["product_keywords"];

        if($product_name == "" or $product_per_day == "" or $product_excess_mileage == "" or $product_category == "" or $product_desc == "" or $product_image == "" or $product_keywords == ""){
            echo "<script>alert('Error: Please fill all the avaiable fields.')</script>";
        } else {
            $sql_check_duplicate = "SELECT * FROM `luxedrive_products` WHERE product_name='$product_name';";
            $result_duplicate_check = mysqli_query($conn, $sql_check_duplicate);
            $row_count = mysqli_num_rows($result_duplicate_check);

            if ($row_count != 0) {
                echo "<script>alert('Error: This product already exists. Please choose a different product.')</script>";
            } else {
                move_uploaded_file($product_tmpimage, "../images/$product_image");
                $sql_insert_category = "INSERT INTO `luxedrive_products` (product_name,product_per_day,product_excess_mileage,category_id,product_desc,product_image,product_keywords,date,status) VALUES ('$product_name','$product_per_day','$product_excess_mileage','$product_category','$product_desc','$product_image','$product_keywords',NOW(),'available');";
                $result_insert = mysqli_query($conn, $sql_insert_category);

                if ($result_insert) {
                    echo "<script>alert('Success: Product \"$product_name\" has been added.'); window.location.href = 'products.php?view';</script>";
                } else {
                    echo "<script>alert('Error: Unable to add the product at the moment. Please try again later.')</script>";
                }
            }
        }
    }
?>
<form action="#" method="post" enctype="multipart/form-data" class="p-4">
    <h2 class="mb-4">Create New Vehicle</h2>
    <div class="row mb-3">
        <div class="col-md-8">
            <label for="productName" class="form-label">Vehicle Name:</label>
            <input type="text" id="productName" name="product_name" class="form-control" required>
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
    
                        echo "<option value=$category_id>$category_name</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="product_per_day" class="form-label">Per Day(80km):</label>
            <input type="number" id="product_per_day" name="product_per_day" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="product_excess_mileage" class="form-label">Excess Mileage:</label>
            <input type="number" id="product_excess_mileage" name="product_excess_mileage" class="form-control" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description:</label>
        <textarea id="description" name="product_desc" rows="4" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image:</label>
        <input type="file" id="image" name="product_image" class="form-control" accept="image/*" required>
    </div>

    <div class="mb-3">
        <label for="keywords" class="form-label">Keywords (comma-separated):</label>
        <input type="text" id="keywords" name="product_keywords" class="form-control" required>
    </div>

    <div class="buttons">
    <a href="products.php?view" class="left"><i class="fa-solid fa-arrow-left"></i> Back</a>
    <button type="submit" name="submit" class="btn btn-custom">CREATE VEHICLE</button>
    </div>
</form>

