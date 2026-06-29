<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { die("Unauthorized"); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $unique_image_name = time() . "_" . $image_name;
    $target_folder = "uploads/" . $unique_image_name;

    if (move_uploaded_file($image_tmp, $target_folder)) {
        $sql = "INSERT INTO products (title, description, price, image, stock) VALUES ('$title', '$description', '$price', '$unique_image_name', '$stock')";
        if ($conn->query($sql) === TRUE) {
            // header("Location: admin_products.php");
        } else { echo "Error: " . $conn->error; }
    } else { echo "Image upload failed."; }
}
?>