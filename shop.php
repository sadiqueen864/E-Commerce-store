<?php include('header.php'); ?>

<style>
    .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
    .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; }
    .card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; text-align: center; display: flex; flex-direction: column; justify-content: space-between; transition: 0.3s; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
    .card img { width: 100%; height: 220px; object-fit: cover; border-radius: 12px; }
    .card h3 { margin: 15px 0 8px 0; color: #1e293b; font-size: 19px; font-weight: 700; }
    .card p { margin: 0 0 15px 0; color: #64748b; font-size: 14px; height: 40px; overflow: hidden; line-height: 1.5; }
    .price { font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 15px; }
    .btn { background: #0f172a; color: white; border: none; width: 100%; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s; font-size: 15px; }
    .btn:hover { background: #4f46e5; }
</style>

<div class="container">
    <div class="grid">
        <?php
        $sql = "SELECT * FROM products WHERE stock > 0 ORDER BY id DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($product = $result->fetch_assoc()) {
                echo "<div class='card'>
                        <div>
                            <img src='uploads/".$product['image']."'>
                            <h3>".$product['title']."</h3>
                            <p>".$product['description']."</p>
                        </div>
                        <div>
                            <div class='price'>$".$product['price']."</div>
                            <form action='add_to_cart.php' method='POST'>
                                <input type='hidden' name='product_id' value='".$product['id']."'>
                                <button type='submit' class='btn'>Add to Cart</button>
                            </form>
                        </div>
                      </div>";
            }
        } else { echo "<p style='grid-column:1/-1; text-align:center; color:#64748b; font-size:16px; margin-top:50px;'>No items found in stock. Login as admin to upload products!</p>"; }
        ?>
    </div>
</div>

<?php include('footer.php'); ?>