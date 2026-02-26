<?php
include '../includes/db.php';

$id = $_POST['id'];
$stock = $_POST['stock'];

mysqli_query($conn,"UPDATE products SET stock=$stock WHERE product_id=$id");
header("Location: dashboard.php");
