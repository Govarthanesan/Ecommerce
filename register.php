<?php include "includes/header.php"; include "includes/db.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  try {
  $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
  $stmt->execute([$name, $email, $password]);

  // ✅ Instead of logging them in, redirect to login page
  header("Location: login.php?registered=1");
  exit;
} catch (PDOException $e) {
  $error = "Registration failed: " . $e->getMessage();
}
}
?>

<style>
  body {
    background: linear-gradient(to right, #a8dadc, #f1faee);
  }

  .register-container {
    max-width: 400px;
    margin: 60px auto;
    background: white;
    padding: 30px 40px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  }

  .register-container h2 {
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

  .login-link {
    text-align: center;
    margin-top: 15px;
    font-size: 0.95rem;
  }
</style>

<div class="register-container">
  <h2>Register</h2>
  <form method="POST">
    <div class="mb-3">
      <input type="text" name="name" class="form-control" placeholder="Full Name" required>
    </div>
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>
    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <button type="submit" class="btn btn-green w-100">Register</button>
  </form>
  <div class="login-link">
    Already have an account? <a href="login.php">Login</a>
  </div>
</div>

<?php include "includes/footer.php"; ?>
