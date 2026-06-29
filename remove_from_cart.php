<?php
session_start();

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // Agar cart mein yeh product mojud hai toh usay session se hata do
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Wapis cart waale page par bhej do
header("Location: view_cart.php");
exit();
?>