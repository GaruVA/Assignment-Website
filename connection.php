<?php 
    $servername = "localhost";
    $username = "id21691052_luxedrive";
    $password = "#Js03011995";
    $db = "id21691052_luxedrive";

    $conn = mysqli_connect($servername, $username, $password);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (!mysqli_select_db($conn, $db)) {
        die("Database does not exist: " . mysqli_error($conn));
    }
?>
