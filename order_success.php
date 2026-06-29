<?php
include('header.php');

// Agar direct koi is page par aaye bina order kiye to shop par bhej do
if (!isset($_SESSION['order_details'])) {
    header("Location: shop.php");
    exit();
}

$order = $_SESSION['order_details'];
?>

<style>
    .success-container { max-width: 600px; margin: 50px auto; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); text-align: center; border: 1px solid #f1f5f9; }
    .success-icon { font-size: 60px; color: #10b981; margin-bottom: 15px; }
    .receipt { text-align: left; background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px dashed #cbd5e1; margin: 25px 0; }
    .receipt h4 { margin-top: 0; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; }
    .receipt p { font-size: 14px; margin: 6px 0; color: #475569; }
</style>

<div class="success-container">
    <div class="success-icon">🎉</div>
    <h2>Order Placed Successfully!</h2>
    <p style="color:#64748b;">Thank you for shopping with NovaMarket. Your order is on its way.</p>
    
    <div class="receipt">
        <h4>📦 Shipping & Billing Receipt:</h4>
        <p><b>Customer Name:</b> <?php echo $order['name']; ?></p>
        <p><b>Phone Number:</b> <?php echo $order['phone']; ?></p>
        <p><b>Delivery Address:</b> <?php echo $order['address']; ?></p>
        
        <h4 style="margin-top: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">🛒 Items Ordered:</h4>
        <?php foreach ($order['items'] as $item): ?>
            <p style="display:flex; justify-content:space-between;">
                <span><?php echo $item['title']; ?> <b>(x<?php echo $item['qty']; ?>)</b></span>
                <span>$<?php echo number_format($item['subtotal'], 2); ?></span>
            </p>
        <?php endforeach; ?>
        
        <div style="display:flex; justify-content:space-between; font-weight:700; font-size:16px; color:#0f172a; border-top:2px solid #e2e8f0; padding-top:10px; margin-top:10px;">
            <span>Total Paid (COD):</span>
            <span>$<?php echo number_format($order['total'], 2); ?></span>
        </div>
    </div>

    <a href="shop.php" class="btn-submit" style="text-decoration:none; display:inline-block;">Continue Shopping</a>
</div>

<?php 
// Receipt dekhane k baad session data clear karna taakay naya order lag sakay
unset($_SESSION['order_details']);
include('footer.php'); 
?>