<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

include 'includes/db.php';
$products = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2f3640;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
        }

        h2 {
            margin: 0;
        }

        .logout {
            color: #f5f6fa;
            text-decoration: none;
            background: #e84118;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
        }

        .logout:hover {
            background: #c23616;
        }

        .section {
            margin-top: 30px;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        input[type="text"], input[type="number"], input[type="file"], button {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            background-color: #44bd32;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #4cd137;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #273c75;
            color: white;
        }

        tr:hover {
            background-color: #f1f2f6;
        }

        img {
            width: 70px;
            border-radius: 4px;
        }

        .delete-btn {
            color: white;
            background-color: #e84118;
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
        }

        .delete-btn:hover {
            background-color: #c23616;
        }
    </style>
</head>
<body>

    <header>
        <h2>Admin Dashboard</h2>
        <a class="logout" href="logout.php">Logout</a>
    </header>

    <div class="section">
        <h3>Add New Product</h3>
        <form action="uploads/add_product.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required />
            <input type="number" name="price" placeholder="Price" required />
            <input type="file" name="image" accept="image/*" required />
            <button type="submit" name="add">Add Product</button>
        </form>
    </div>

    <div class="section">
        <h3>Product List</h3>
        <table>
            <tr><th>ID</th><th>Name</th><th>Price</th><th>Image</th><th>Action</th></tr>
            <?php while ($row = mysqli_fetch_assoc($products)) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>₹<?= number_format($row['price']) ?></td>
                <td><img src="assets/images/<?= $row['image'] ?>" alt="product" /></td>
                <td>
                    <a class="delete-btn" href="uploads/delete_product.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
