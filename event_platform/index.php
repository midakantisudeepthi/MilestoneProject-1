<?php
include 'db.php';
session_start();
?>
<link rel="stylesheet" href="css/style.css">

<h2>Upcoming Events</h2>

<?php
$sql = "SELECT * FROM events ORDER BY date ASC";
$result = $conn->query($sql);

if($result->num_rows > 0){
    echo "<ul>";
    while($row = $result->fetch_assoc()){
        echo "<li>";
        echo "<b>" . $row['title'] . "</b> - " . $row['date'] . " at " . $row['time'] . "<br>";
        echo "Location: " . $row['location'] . "<br>";
        echo "Tickets Sold: " . $row['tickets_sold'] . " / " . $row['total_tickets'] . "<br>";

        // Show Book link if user is logged in
        if(isset($_SESSION['user_id'])){
            echo "<a href='book_ticket.php?event_id=" . $row['event_id'] . "'>Book Tickets</a>";
        } else {
            echo "<a href='login.php'>Login to Book</a>";
        }
        echo "</li><br>";
    }
    echo "</ul>";
} else {
    echo "No events available.";
}
?>