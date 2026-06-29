<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { die("Unauthorized"); }

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id='$id'";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Agar nayi image upload ki jaye
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $unique_image_name = time() . "_" . $image_name;
        move_uploaded_file($image_tmp, "uploads/" . $unique_image_name);
        
        $sql_update = "UPDATE products SET title='$title', description='$description', price='$price', stock='$stock', image='$unique_image_name' WHERE id='$id'";
    } else {
        // Agar image change nahi karni
        $sql_update = "UPDATE products SET title='$title', description='$description', price='$price', stock='$stock' WHERE id='$id'";
    }

    if ($conn->query($sql_update) === TRUE) {
        header("Location: admin_products.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; padding: 40px; display: flex; justify-content: center; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); width: 400px; }
        .form-group { margin-bottom: 15px; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; box-sizing: border-box; }
        .btn { background: #4f46e5; color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 600; cursor: pointer; width: 100%; }
    </style>
</head>
<body>
    <div class="card">
        <h3>Edit Product Details</h3>
        <form action="edit_product.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <div class="form-group"><input type="text" name="title" value="<?php echo $product['title']; ?>" required></div>
            <div class="form-group"><textarea name="description" rows="3" required><?php echo $product['description']; ?></textarea></div>
            <div class="form-group"><input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required></div>
            <div class="form-group"><input type="number" name="stock" value="<?php echo $product['stock']; ?>" required></div>
            <div class="form-group">
                <label style="font-size: 12px; color:#64748b;">Current Image:</label><br>
                <img src="uploads/<?php echo $product['image']; ?>" width="60" style="border-radius:6px; margin: 5px 0;"><br>
                <input type="file" name="image">
            </div>
            <button type="submit" class="btn">Update Product</button>
        </form>
    </div>
</body>
</html>