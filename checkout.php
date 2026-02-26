<?php include 'includes/db.php';

$total = 0;
foreach($_SESSION['cart'] as $id=>$qty){
  $p = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM products WHERE product_id=$id"));
  $total += $p['price']*$qty;
}

$shipping = $total > 100 ? 0 : 10;

mysqli_query($conn,"INSERT INTO orders(user_id,total,shipping,status)
VALUES({$_SESSION['user_id']},$total,$shipping,'Confirmed')");

$order_id = mysqli_insert_id($conn);

foreach($_SESSION['cart'] as $id=>$qty){
  mysqli_query($conn,"INSERT INTO order_items(order_id,product_id,quantity,price)
  VALUES($order_id,$id,$qty,(SELECT price FROM products WHERE product_id=$id))");
}

unset($_SESSION['cart']);
echo "Order Successful!";
?>
