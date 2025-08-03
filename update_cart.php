<?php
session_start();

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['id']) || !isset($input['action'])) {
  echo json_encode(['success' => false, 'message' => 'Invalid input']);
  exit;
}

$id = $input['id'];
$action = $input['action'];
$removed = false;

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

foreach ($_SESSION['cart'] as $i => &$item) {
  if ($item['id'] == $id) {
    if ($action === 'increase') {
      $item['quantity']++;
    } elseif ($action === 'decrease') {
      $item['quantity']--;
      if ($item['quantity'] <= 0) {
        array_splice($_SESSION['cart'], $i, 1);
        $removed = true;
      }
    }
    break;
  }
}

// Recalculate total and subtotal
$total = 0;
foreach ($_SESSION['cart'] as $item) {
  $total += $item['price'] * $item['quantity'];
}

// Prepare updated response
$response = ['success' => true, 'removed' => $removed, 'total' => $total];

if (!$removed) {
  foreach ($_SESSION['cart'] as $item) {
    if ($item['id'] == $id) {
      $response['quantity'] = $item['quantity'];
      $response['subtotal'] = $item['price'] * $item['quantity'];
    }
  }
}

echo json_encode($response);
