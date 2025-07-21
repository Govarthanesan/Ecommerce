<?php include "includes/db.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['user_id'])||empty($_SESSION['cart'])) header("Location: cart.php");
$cart = $_SESSION['cart'];
$total = array_sum(array_map(fn($i)=>$i['price']*$i['quantity'],$cart));
$stmt = $conn->prepare("INSERT INTO orders(user_id,total_amount) VALUES(?,?)");
$stmt->execute([$_SESSION['user_id'], $total]);
$order_id = $conn->lastInsertId();
$stmt = $conn->prepare("INSERT INTO order_items(order_id,product_id,quantity,price) VALUES(?,?,?,?)");
foreach($cart as $i){
  $stmt->execute([$order_id,$i['id'],$i['quantity'],$i['price']]);
}
unset($_SESSION['cart']);
?>
<?php include "includes/header.php"; ?>
<h2>Order Placed!</h2>
<p>Your order #<?= $order_id ?> has been successfully placed. Total: ₹<?= number_format($total,2) ?></p>
<a href="home.php" class="btn btn-primary">Continue Shopping</a>
<?php include "includes/footer.php"; ?>
