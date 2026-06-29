<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("<h2 style='color:red; text-align:center; font-family:sans-serif; margin-top:50px;'>Access Denied! Admins Only.</h2>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; margin: 0; padding: 30px; color: #1e293b; }
        .nav { display: flex; justify-content: space-between; align-items: center; background: #0f172a; padding: 15px 30px; color: white; border-radius: 8px; margin-bottom: 30px; }
        .nav a { color: #94a3b8; text-decoration: none; font-weight: 600; margin-left: 15px; }
        .nav a:hover { color: white; }
        .container { display: flex; gap: 30px; }
        .form-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); width: 35%; height: fit-content; }
        .form-card h3 { margin-top: 0; color: #0f172a; }
        .form-group { margin-bottom: 15px; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; box-sizing: border-box; }
        .btn { background: #4f46e5; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; width: 100%; }
        .btn:hover { background: #4338ca; }
        .table-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); width: 65%; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background: #f1f5f9; color: #475569; }
        .prod-img { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; }
        .btn-edit { color: #4f46e5; text-decoration: none; font-weight: 600; margin-right: 10px; }
        .btn-delete { color: #ef4444; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

<div class="nav">
    <h2>Admin Product Panel</h2>
    <div>
        <span>Logged in as: <b>Admin</b></span>
        <a href="shop.php">View Store</a>
        <a href="logout.php" style="color:#ef4444;">Logout</a>
    </div>
</div>

<div class="container">
    <div class="form-card">
        <h3>Add New Product</h3>
        <form action="add_product_process.php" method="POST" enctype="multipart/form-data">
            <div class="form-group"><input type="text" name="title" placeholder="Product Title" required></div>
            <div class="form-group"><textarea name="description" placeholder="Description" rows="3" required></textarea></div>
            <div class="form-group"><input type="number" step="0.01" name="price" placeholder="Price ($)" required></div>
            <div class="form-group"><input type="number" name="stock" placeholder="Stock Qty" required></div>
            <div class="form-group"><label style="font-size:13px; color:#64748b;">Product Image</label><input type="file" name="image" required></div>
            <button type="submit" class="btn">Upload Product</button>
        </form>
    </div>

    <div class="table-card">
        <h3>Inventory Stock</h3>
        <table>
            <tr><th>Image</th><th>Title</th><th>Price</th><th>Stock</th><th>Actions</th></tr>
            <?php
            $sql = "SELECT * FROM products ORDER BY id DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td><img src='uploads/".$row['image']."' class='prod-img'></td>
                            <td><b>".$row['title']."</b></td>
                            <td style='color:#10b981; font-weight:600;'>$".$row['price']."</td>
                            <td>".$row['stock']." units</td>
                            <td>
                                <a href='edit_product.php?id=".$row['id']."' class='btn-edit'>Edit</a>
                                <a href='delete_product.php?id=".$row['id']."' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a>
                            </td>
                          </tr>";
                }
            } else { echo "<tr><td colspan='5'>No inventory found.</td></tr>"; }
            ?>
        </table>
    </div>
</div>

</body>
</html>