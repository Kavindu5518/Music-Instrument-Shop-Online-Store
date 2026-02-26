<?php
include '../includes/db.php';
if(!isset($_SESSION['user_id'])){ die("Login required"); }

$user_id = $_SESSION['user_id'];

$orders = mysqli_query($conn,"
SELECT * FROM orders WHERE user_id=$user_id ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Account</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2 style="padding:30px">My Orders</h2>

<div class="section">
<?php while($o=mysqli_fetch_assoc($orders)){ ?>
  <div class="card">
    <h3>Order #<?php echo $o['order_id']; ?></h3>
    <p>Status: <?php echo $o['status']; ?></p>
    <p>Total: £<?php echo $o['total']; ?></p>

    <h4>Downloads</h4>

    <?php
    $items = mysqli_query($conn,"
      SELECT p.name,p.type,p.image
      FROM order_items oi
      JOIN products p ON oi.product_id=p.product_id
      WHERE oi.order_id={$o['order_id']}
    ");

    while($i=mysqli_fetch_assoc($items)){
      if($i['type']=='digital'){
        echo "<a href='../download.php?file={$i['image']}'>Download {$i['name']}</a><br>";
      }
    }
    ?>
  </div>
<?php } ?>
</div>
<a href="../invoice.php?order_id=<?php echo $o['order_id']; ?>">
  Download Invoice (PDF)
</a>

</body>
</html>
