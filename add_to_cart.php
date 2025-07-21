<?php
session_start();
include "includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $product_id = $_POST['id'];

  // Fetch product info from DB
  $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute([$product_id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($product) {
    // Initialize cart if not already
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }

    $found = false;

    // Check if item already in cart
    foreach ($_SESSION['cart'] as &$item) {
      if ($item['id'] == $product_id) {
        $item['quantity']++;
        $found = true;
        break;
      }
    }

    if (!$found) {
      $_SESSION['cart'][] = [
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => 1
      ];
    }

    // Redirect back to home or with a success message
    header("Location: home.php");
    exit;
  } else {
    echo "Product not found.";
  }
} else {
  echo "Invalid request method.";
}
