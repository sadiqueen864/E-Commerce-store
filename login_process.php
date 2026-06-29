<?php
session_start();
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // MD5 password match karne k liye
    $md5_password = md5($password);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$md5_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        session_regenerate_id();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($_SESSION['role'] == 'admin') {
            header("Location: admin_products.php");
        } else {
            header("Location: shop.php");
        }
        exit();
    } else {
        echo "<script>alert('Invalid Email or Password!'); window.location='login.html';</script>";
    }
}
?>