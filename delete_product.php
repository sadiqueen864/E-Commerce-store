<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { die("Unauthorized"); }

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Pehle product ki image ka naam nikalna taakay folder se bhi delete ho jaye
    $img_sql = "SELECT image FROM products WHERE id='$id'";
    $img_res = $conn->query($img_sql);
    if($img_res->num_rows > 0) {
        $prod = $img_res->fetch_assoc();
        @unlink("uploads/" . $prod['image']); // Folder se image delete karna
    }

    // Database se record delete karna
    $sql = "DELETE FROM products WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_products.php");
    } else {
        echo "Error deleting product: " . $conn->error;
    }
}
?>