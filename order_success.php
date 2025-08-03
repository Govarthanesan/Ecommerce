<?php
include "includes/header.php";

$order_id = $_GET['id'] ?? 0;
?>

<div class="container mt-5 text-center">
  <h2 class="text-success">🎉 Order Placed Successfully!</h2>
  <p>Your order ID is <strong>#<?= $order_id ?></strong></p>
  <a href="home.php" class="btn btn-primary mt-3">Continue Shopping</a>
</div>

<?php include "includes/footer.php"; ?>
