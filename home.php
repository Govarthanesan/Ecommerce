<?php include "includes/header.php"; include "includes/db.php";
if (!isLoggedIn()) header("Location: login.php");
$products = $conn->query("SELECT * FROM products")->fetchAll();
?>
<div class="row">
<?php foreach($products as $p): ?>
  <div class="col-md-3 mb-4">
    <div class="card shadow-sm h-100">
      <img src="assets/images/<?= $p['image'] ?>" class="card-img-top" style="height:200px; object-fit:cover;">
      <div class="card-body text-center">
        <h5><?= $p['name'] ?></h5>
        <p class="text-success fw-bold">₹<?= $p['price'] ?></p>
        <form action="add_to_cart.php" method="POST">
          <input type="hidden" name="id" value="<?= $p['id'] ?>">
          <button class="btn btn-outline-primary w-100"><i class="bi bi-cart-plus"></i> Add to Cart</button>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php include "includes/footer.php"; ?>
