<?php
include('header.php');

// Agar cart khali ho to wapis bhej do
if (empty($_SESSION['cart'])) {
    header("Location: shop.php");
    exit();
}

$total_bill = 0;

// Agar address form submit ho jaye
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    
    // Session mien data save karna taakay success page par dikha sakein
    $_SESSION['order_details'] = [
        'name' => $full_name,
        'phone' => $phone,
        'address' => $address . ", " . $city,
        'items' => []
    ];

    // Stock update karna database mien
    foreach ($_SESSION['cart'] as $p_id => $quantity) {
        $sql = "SELECT * FROM products WHERE id = '$p_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $subtotal = $product['price'] * $quantity;
            $total_bill += $subtotal;
            
            // Item details receipt k liye save karna
            $_SESSION['order_details']['items'][] = [
                'title' => $product['title'],
                'qty' => $quantity,
                'subtotal' => $subtotal
            ];

            // Naya stock calculate kar k update karna
            $new_stock = $product['stock'] - $quantity;
            $conn->query("UPDATE products SET stock = '$new_stock' WHERE id = '$p_id'");
        }
    }
    
    $_SESSION['order_details']['total'] = $total_bill;

    // Cart khali karna order k baad
    unset($_SESSION['cart']);

    // Success page par bhej dena
    echo "<script>window.location='order_success.php';</script>";
    exit();
}
?>

<style>
    .checkout-container { max-width: 600px; margin: 40px auto; background: white; padding: 35px; border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; }
    .checkout-container h2 { color: #0f172a; margin-top: 0; font-size: 24px; font-weight: 800; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; }
    .summary-box { background: #f8fafc; padding: 15px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #e2e8f0; }
    .summary-item { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; color: #475569; }
</style>

<div class="checkout-container">
    <h2>🚚 Delivery & Shipping Details</h2>
    
    <div class="summary-box">
        <h4>Order Summary:</h4>
        <?php
        foreach ($_SESSION['cart'] as $p_id => $quantity) {
            $sql = "SELECT title, price FROM products WHERE id = '$p_id'";
            $res = $conn->query($sql);
            if($res->num_rows > 0) {
                $p = $res->fetch_assoc();
                $sub = $p['price'] * $quantity;
                $total_bill += $sub;
                echo "<div class='summary-item'><span>".$p['title']." (x".$quantity.")</span> <b>$".number_format($sub, 2)."</b></div>";
            }
        }
        ?>
        <div class="summary-item" style="border-top: 1px solid #cbd5e1; padding-top: 8px; margin-top: 8px; font-size: 16px; font-weight: 700; color: #0f172a;">
            <span>Total Bill:</span> <span>$<?php echo number_format($total_bill, 2); ?></span>
        </div>
    </div>

    <form action="checkout.php" method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" placeholder="e.g. Sadia Khan" required>
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" placeholder="e.g. 03001234567" required>
        </div>
        <div class="form-group">
            <label>Shipping Address</label>
            <input type="text" name="address" placeholder="House No, Street No, Area..." required>
        </div>
        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" placeholder="e.g. Lahore" required>
        </div>
        <div class="form-group">
            <label>Payment Method</label>
            <input type="text" value="Cash on Delivery (COD)" disabled style="background: #e2e8f0; font-weight: 600; color: #475569;">
        </div>
        
        <button type="submit" name="place_order" class="btn-submit" style="width: 100%; margin-top: 10px;">Confirm & Place Order</button>
    </form>
</div>

<?php include('footer.php'); ?>