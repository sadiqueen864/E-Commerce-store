<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚡ NovaMarket | Premium Store</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; margin: 0; padding: 0; transition: background 0.3s; display: flex; flex-direction: column; min-height: 100vh; }
        .content-wrapper { flex: 1; }
        
        /* Navbar Style */
        .navbar { display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px 5%; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 100; transition: background 0.3s; }
        
        /* Editable Logo */
        .logo-area { display: flex; align-items: center; gap: 5px; }
        .navbar h1 { margin: 0; color: #4f46e5; font-size: 24px; font-weight: 800; padding: 2px 5px; border-radius: 4px; transition: 0.2s; }
        .navbar h1[contenteditable="true"]:hover { background: #f1f5f9; outline: 1px dashed #4f46e5; cursor: pointer; }
        .navbar h1[contenteditable="true"]:focus { background: white; outline: 2px solid #4f46e5; }
        
        .nav-links { display: flex; align-items: center; gap: 20px; }
        .nav-links a { text-decoration: none; color: #475569; font-weight: 600; font-size: 15px; transition: 0.2s; }
        .nav-links a:hover { color: #4f46e5; }
        
        /* Toolkit Customizer Panel */
        .customizer { display: flex; align-items: center; gap: 10px; background: #f1f5f9; padding: 5px 12px; border-radius: 20px; border: 1px solid #e2e8f0; font-size: 13px; font-weight: 600; color: #475569; }
        .customizer label { display: flex; align-items: center; gap: 4px; cursor: pointer; }
        .customizer input[type="color"] { border: none; width: 22px; height: 22px; border-radius: 50%; cursor: pointer; padding: 0; background: none; }
        
        .cart-badge { background: #4f46e5; color: white; padding: 8px 16px; border-radius: 20px; font-weight: 600; text-decoration: none; font-size: 14px; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2); }
        .admin-tag { background: #ef4444; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; margin-left: 5px; }
        
        .info-container { max-width: 800px; margin: 50px auto; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; }
        .info-container h2 { color: #0f172a; margin-top: 0; font-size: 28px; font-weight: 800; }
        .info-container p { color: #475569; line-height: 1.7; font-size: 16px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #475569; font-weight: 600; }
        .form-group input, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; }
        .btn-submit { background: #4f46e5; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 16px; }
    </style>
</head>
<body>

<div class="navbar" id="mainNavbar">
    <div class="logo-area" title="Double click to change website name!">
        <h1 id="siteLogo" contenteditable="true" onblur="saveLogoName()">⚡ NovaMarket</h1>
    </div>
    
    <div class="nav-links">
        <div class="customizer">
            🎨 Customize:
            <label>BG <input type="color" id="bgColorPicker" oninput="changeBgColor(this.value)"></label>
            <label>Nav <input type="color" id="navColorPicker" oninput="changeNavColor(this.value)"></label>
            <label>Foot <input type="color" id="footColorPicker" oninput="changeFootColor(this.value)"></label>
        </div>

        <a href="shop.php">Store</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact</a>

        <?php if(isset($_SESSION['username'])): ?>
            <span style="color:#475569; font-weight:600;">Hi, <?php echo $_SESSION['username']; ?> 
                <?php if($_SESSION['role'] == 'admin'): ?>
                    <span class="admin-tag">Admin</span>
                <?php endif; ?>
            </span>
            <?php if($_SESSION['role'] == 'admin'): ?>
                <a href="admin_products.php" style="color:#ef4444; font-weight:700;">⚙️ Settings</a>
            <?php endif; ?>
            <a href="logout.php" style="color:#64748b;">Logout</a>
        <?php else: ?>
            <a href="login.html">Login</a>
            <a href="register.html">Sign Up</a>
        <?php endif; ?>

        <a href="view_cart.php" class="cart-badge">🛒 Cart (<?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>)</a>
    </div>
</div>

<div class="content-wrapper">