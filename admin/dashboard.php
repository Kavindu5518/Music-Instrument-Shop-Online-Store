<?php
include '../includes/db.php';
if($_SESSION['role'] !== 'admin'){ die("Access denied"); }

$totalOrders = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT COUNT(*) total FROM orders")
)['total'];

$totalRevenue = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT SUM(total) rev FROM orders")
)['rev'];

$lowStock = mysqli_query($conn,"SELECT name,stock FROM products WHERE stock < 5");

$monthly = mysqli_query($conn,"
  SELECT MONTH(created_at) m, SUM(total) r 
  FROM orders 
  GROUP BY MONTH(created_at)
");

$months = [];
$revenues = [];

while($row = mysqli_fetch_assoc($monthly)){
  $months[] = date("F", mktime(0,0,0,$row['m'],1));
  $revenues[] = $row['r'];
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2 style="padding:30px">Admin Dashboard</h2>

<div class="section grid">
  <div class="card">
    <h3>Total Orders</h3>
    <h1><?php echo $totalOrders; ?></h1>
  </div>

  <div class="card">
    <h3>Total Revenue</h3>
    <h1>£<?php echo number_format($totalRevenue,2); ?></h1>
  </div>
</div>

<div class="section">
  <h3>Low Stock Alerts</h3>
  <?php while($p=mysqli_fetch_assoc($lowStock)){ ?>
    <p><?php echo $p['name']; ?> (<?php echo $p['stock']; ?> left)</p>
  <?php } ?>
</div>

<div class="section">
  <canvas id="orderChart"></canvas>
</div>

<script>
new Chart(document.getElementById('orderChart'), {
  type: 'bar',
  data: {
    labels: ['Orders'],
    datasets: [{
      label: 'Total Orders',
      data: [<?php echo $totalOrders; ?>],
      backgroundColor: '#facc15'
    }]
  }
});
</script>

<div class="section">
  <h3>Monthly Revenue</h3>
  <canvas id="revenueChart"></canvas>
</div>

<script>
new Chart(document.getElementById('revenueChart'), {
  type: 'line',
  data: {
    labels: <?php echo json_encode($months); ?>,
    datasets: [{
      label: 'Revenue (£)',
      data: <?php echo json_encode($revenues); ?>,
      borderWidth: 3,
      fill: false
    }]
  }
});
</script>


</body>
</html>
