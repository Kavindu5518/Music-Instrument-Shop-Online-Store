<?php
include '../includes/db.php';

$id = $_POST['id'];
$status = $_POST['status'];

mysqli_query($conn,"UPDATE orders SET status='$status' WHERE order_id=$id");
header("Location: dashboard.php");
