<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
header("Location: shop.php"); // Professional standard mien user ko direct shop par bheja jata hai
exit();
?>