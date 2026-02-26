<?php include 'includes/db.php';

if($_SERVER['REQUEST_METHOD']=="POST"){
  $id = $_POST['product_id'];
  $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
}

if(isset($_SESSION['cart'])){
  foreach($_SESSION['cart'] as $id => $qty){
    $p = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM products WHERE product_id=$id"));
    echo "{$p['name']} x $qty - £".$p['price']*$qty."<br>";
  }
}
?>

<a href="checkout.php">Checkout</a>
