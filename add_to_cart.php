<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = array(); }
    if (isset($_SESSION['cart'][$product_id])) { $_SESSION['cart'][$product_id]++; } 
    else { $_SESSION['cart'][$product_id] = 1; }
    header("Location: shop.php");
    exit();
}
?>