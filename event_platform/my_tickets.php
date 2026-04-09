<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    die("Please <a href='login.php'>login</a> to see your tickets.");
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("
    SELECT t.ticket_id, t.quantity, e.title, e.date, e.time, e.location
    FROM tickets t
    JOIN events e ON t.event_id = e.event_id
    WHERE t.user_id = $user_id
");

echo "<h2>My Tickets</h2>";
if($result->num_rows == 0){
    echo "No tickets booked yet.";
} else {
    while($row = $result->fetch_assoc()){
        echo "Ticket ID: {$row['ticket_id']} | Event: {$row['title']} | Quantity: {$row['quantity']} | Date: {$row['date']} | Time: {$row['time']} | Location: {$row['location']}<br>";
    }
}
?>