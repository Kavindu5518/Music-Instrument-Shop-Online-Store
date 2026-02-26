<?php
include '../includes/db.php';
if($_SESSION['role'] !== 'staff') die("Access denied");

$products = mysqli_query($conn,"SELECT * FROM products");
$orders = mysqli_query($conn,"SELECT * FROM orders ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Staff Dashboard</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2 style="padding:30px">Staff Dashboard</h2>

<div class="section">
<h3>Manage Inventory</h3>

<?php while($p=mysqli_fetch_assoc($products)){ ?>
<div class="card">
  <h4><?php echo $p['name']; ?></h4>
  <p>Stock: <?php echo $p['stock']; ?></p>

  <form method="post" action="update_stock.php">
    <input type="hidden" name="id" value="<?php echo $p['product_id']; ?>">
    <input type="number" name="stock" required>
    <button>Update Stock</button>
  </form>
</div>
<?php } ?>
</div>

<div class="section">
<h3>Process Orders</h3>

<?php while($o=mysqli_fetch_assoc($orders)){ ?>
  <div class="card">
    Order #<?php echo $o['order_id']; ?> |
    Status: <?php echo $o['status']; ?>

    <form method="post" action="update_order.php">
      <input type="hidden" name="id" value="<?php echo $o['order_id']; ?>">
      <select name="status">
        <option>Pending</option>
        <option>Shipped</option>
        <option>Completed</option>
      </select>
      <button>Update</button>
    </form>
  </div>
<?php } ?>
</div>

</body>
</html>
