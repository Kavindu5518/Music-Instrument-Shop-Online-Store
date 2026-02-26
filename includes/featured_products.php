<?php
$result = mysqli_query($conn,"SELECT * FROM products LIMIT 3");
while($p = mysqli_fetch_assoc($result)){
?>
<div class="card">
  <img src="assets/images/<?php echo $p['image']; ?>">
  <h3><?php echo $p['name']; ?></h3>
  <p>£<?php echo $p['price']; ?></p>

  <form method="post" action="cart.php">
    <input type="hidden" name="product_id" value="<?php echo $p['product_id']; ?>">
    <button type="submit">Add to Cart</button>
  </form>
</div>
<?php } ?>
