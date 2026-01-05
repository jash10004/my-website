<?php 
require('dbcon.php');
session_start();

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    if ($con->query($sql) === TRUE) {
        echo "Registration successful";
    } else {
        echo "Error: " . $con->error;
    }
}

// User login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo "Login successful";
        } else {
            echo "Invalid credentials";
        }
    } else {
        echo "No user found";
    }
}

// Password reset (send reset link)
if (isset($_POST['forgot'])) {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50));
    $sql = "UPDATE users SET reset_token='$token' WHERE email='$email'";
    if ($conn->query($sql) === TRUE) {
        $resetLink = "http://yourdomain.com/reset.php?token=$token";
        mail($email, "Password Reset", "Click here to reset your password: $resetLink");
        echo "Reset link sent";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Reset password
if (isset($_POST['reset_password'])) {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password='$newPassword' WHERE reset_token='$token'";
    if ($conn->query($sql) === TRUE) {
        echo "Password reset successful";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit" name="login">Login</button>
    </form>

    <h2>Forgot Password?</h2>
    <form method="POST" action="">
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <button type="submit" name="forgot">Send Reset Link</button>
    </form>
</body>
</html>
