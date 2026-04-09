<?php
// Database credentials
$host = "localhost";   // XAMPP runs MySQL locally
$user = "root";        // Default MySQL username in XAMPP
$password = "";        // Default MySQL password in XAMPP is empty
$db = "event_ticketing"; // Your database name
$port = 3307; 
// Create connection
$conn = new mysqli($host, $user, $password, $db , $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // Uncomment to test
?>
