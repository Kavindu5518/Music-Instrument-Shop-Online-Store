<?php include 'db.php'; ?>
<nav>
  <h2>🎵 Melody Masters</h2>

  <?php
  $cats = mysqli_query($conn,"SELECT * FROM categories");
  while($c = mysqli_fetch_assoc($cats)){
    echo "<a href='shop.php?category_id={$c['category_id']}'>{$c['name']}</a>";
  }
  ?>

  <a href="cart.php">🛒 Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>

  <?php if(isset($_SESSION['user_id'])): ?>
    <a href="logout.php">Logout</a>
  <?php else: ?>
    <a href="login.php">Login</a>
  <?php endif; ?>
</nav>
