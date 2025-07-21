<?php 
include "includes/header.php";

$cart = $_SESSION['cart'] ?? []; 
$total = 0;
?>

<h3 class="mt-4">Your Cart</h3>

<?php if (empty($cart)): ?>
  <p class="text-muted">Cart is empty.</p>
<?php else: ?>
  <table class="table table-hover align-middle">
    <thead class="table-dark">
      <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Subtotal</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($cart as $item): 
        $sub = $item['price'] * $item['quantity']; 
        $total += $sub;
      ?>
        <tr>
          <td><?= htmlspecialchars($item['name']) ?></td>
          <td>₹<?= $item['price'] ?></td>
          <td><?= $item['quantity'] ?></td>
          <td>₹<?= $sub ?></td>
          <td>
            <!-- Delete Button as POST form -->
            <form action="remove_from_cart.php" method="POST" style="display:inline;">
              <input type="hidden" name="id" value="<?= $item['id'] ?>">
              <button type="submit" class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i> Delete
              </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <p class="fw-bold">Total: ₹<?= $total ?></p>
  <a href="clear_cart.php" class="btn btn-warning"><i class="bi bi-x-circle"></i> Clear</a>
  <a href="place_order.php" class="btn btn-success"><i class="bi bi-bag-check"></i> Checkout</a>
<?php endif; ?>

<?php include "includes/footer.php"; ?>
