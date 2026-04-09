<?php
session_start(); // Start a session to keep user logged in
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            header("Location: dashboard.php"); // Redirect to dashboard
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User not found!";
    }
}
?>
<link rel="stylesheet" href="css/style.css">

<style>
    /* Styling for the Login Container */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); /* Slightly deeper blue for security/trust */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* The Login Card */
form {
    background: #ffffff;
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    width: 100%;
    max-width: 350px;
    text-align: center;
}

h2 {
    color: #333;
    margin-bottom: 25px;
    font-weight: 700;
    letter-spacing: -0.5px;
}

/* Input Field Styling */
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 14px;
    margin-bottom: 10px;
    border: 2px solid #edf2f7;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 15px;
    transition: all 0.3s ease;
    background-color: #f8fafc;
}

input:focus {
    outline: none;
    border-color: #2a5298;
    background-color: #fff;
    box-shadow: 0 0 0 4px rgba(42, 82, 152, 0.1);
}

/* Login Button */
button[type="submit"] {
    width: 100%;
    background: #2a5298;
    color: white;
    padding: 14px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 15px;
    transition: background 0.3s transform 0.2s;
}

button[type="submit"]:hover {
    background: #1e3c72;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

button[type="submit"]:active {
    transform: translateY(0);
}

/* Optional: Link styling for "Forgot Password" or "Register" */
.form-footer {
    margin-top: 20px;
    font-size: 13px;
    color: #718096;
}

.form-footer a {
    color: #2a5298;
    text-decoration: none;
    font-weight: 600;
}
</style>

<form method="POST">
    <h2>Login to Your Account</h2>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</form>