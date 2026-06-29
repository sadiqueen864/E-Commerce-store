<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check_email);

    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
    if ($result->num_rows > 0) {
        echo "<h3 style='color: red;'>Error: This email is already registered!</h3><a href='register.html'>Try Again</a>";
    } else {
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', 'user')";
        if ($conn->query($sql) === TRUE) {
            echo "<h3 style='color: green;'>Registration successful!</h3><p>Redirecting to login...</p>";
            header("refresh:2;url=login.html");
        } else {
            echo "<h3 style='color: red;'>Error: " . $conn->error . "</h3>";
        }
    }
    echo "</div>";
}
?>