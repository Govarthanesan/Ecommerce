<?php
include "includes/header.php";
include "includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    header("Location: home.php");
    exit;
  } else {
    $error = "Invalid email or password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #a8dadc, #f1faee);
    }

    .login-container {
      max-width: 400px;
      margin: 60px auto;
      background: white;
      padding: 30px 40px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .login-container h2 {
      font-weight: 700;
      margin-bottom: 25px;
      text-align: center;
    }

    .form-control {
      border-radius: 10px;
    }

    .btn-green {
      background-color: #5cb85c;
      border: none;
      color: white;
      font-weight: bold;
      border-radius: 8px;
    }

    .btn-green:hover {
      background-color: #4cae4c;
    }

    .register-link {
      text-align: center;
      margin-top: 15px;
      font-size: 0.95rem;
    }
  </style>
</head>
<body>

<!-- ✅ Registration success toast -->
<?php if (isset($_GET['registered'])): ?>
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
    <div id="toastRegistered" class="toast align-items-center text-white bg-success border-0 show" role="alert">
      <div class="d-flex">
        <div class="toast-body">
          ✅ Registered successfully! Please log in.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>
<?php endif; ?>

<div class="login-container">
  <h2>Login</h2>
  <form method="POST">
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>

    <!-- Show login error if exists -->
    <?php if (isset($error)): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <button type="submit" class="btn btn-green w-100">Login</button>
  </form>
  <div class="register-link">
    Don't have an account? <a href="register.php">Register</a>
  </div>
</div>

<!-- Bootstrap Bundle with Toasts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Auto-dismiss toast after 3 seconds -->
<script>
  setTimeout(() => {
    const toast = document.getElementById('toastRegistered');
    if (toast) {
      new bootstrap.Toast(toast).hide();
    }
  }, 3000);
</script>

</body>
</html>
