<?php
session_start();
include 'includes/db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']);

    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #dcdde1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            width: 350px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2f3640;
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .login-box button {
            width: 100%;
            background-color: #44bd32;
            border: none;
            padding: 10px;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .login-box button:hover {
            background-color: #4cd137;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }

    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" name="login">Login</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
