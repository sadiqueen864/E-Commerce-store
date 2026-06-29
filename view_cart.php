<?php
session_start();
include('db_connect.php');
$total_bill = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; margin: 0; padding: 40px; color: #1e293b; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        h2 { margin-top: 0; color: #0f172a; }
        table { width: 100%; border-collapse: collapse; margin: 25px 0; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #f1f5f9; }
        th { background: #f8fafc; color: #64748b; font-weight: 600; }
        .total { text-align: right; font-size: 22px; font-weight: 700; margin-bottom: 25px; }
        .flex-btns { display: flex; justify-content: space-between; align-items: center; }
        .btn-back { color: #64748b; text-decoration: none; font-weight: 500; }
        .btn-checkout { background: #4f46e5; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: 0.2s; }
        .btn-checkout:hover { background: #4338ca; }
        .btn-remove { color: #ef4444; text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.2s; }
        .btn-remove:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <h2>🛒 Your Cart Details</h2>
    <?php if (!empty($_SESSION['cart'])): ?>
        <table>
            <tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>Action</th></tr>
            <?php
            foreach ($_SESSION['cart'] as $p_id => $quantity) {
                $sql = "SELECT * FROM products WHERE id = '$p_id'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $product = $result->fetch_assoc();
                    $subtotal = $product['price'] * $quantity;
                    $total_bill += $subtotal;
                    echo "<tr>
                            <td><b>".$product['title']."</b></td>
                            <td>$".$product['price']."</td>
                            <td>".$quantity."</td>
                            <td style='font-weight:600;'>$".number_format($subtotal, 2)."</td>
                            <td><a href='remove_from_cart.php?id=".$p_id."' class='btn-remove'>❌ Remove</a></td>
                          </tr>";
                }
            }
            ?>
        </table>
        <div class="total">Total: $<?php echo number_format($total_bill, 2); ?></div>
        <div class="flex-btns">
            <a href="shop.php" class="btn-back">← Keep Shopping</a>
            <a href="checkout.php" class="btn-checkout">Order Now</a>
        </div>
    <?php else: ?>
        <p style="text-align:center; color:#64748b; margin: 40px 0;">Your cart is completely empty!</p>
        <a href="shop.php" class="btn-checkout" style="display:block; text-align:center; max-width:200px; margin:0 auto;">Browse Products</a>
    <?php endif; ?>
</div>

</body>
</html>