<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    die("Please <a href='login.php'>login</a> first to book tickets.");
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $event_id = $_POST['event_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    // Check available tickets
    $sql = "SELECT total_tickets, tickets_sold FROM events WHERE event_id='$event_id'";
    $res = $conn->query($sql)->fetch_assoc();

    if($res['tickets_sold'] + $quantity <= $res['total_tickets']){
        $conn->query("INSERT INTO tickets(user_id,event_id,quantity) VALUES($user_id,$event_id,$quantity)");
        $conn->query("UPDATE events SET tickets_sold = tickets_sold + $quantity WHERE event_id=$event_id");
        echo "Tickets booked successfully! <a href='index.php'>Back to Events</a>";
    } else {
        echo "Not enough tickets available!";
    }
}

// Get event info for display
$event_id = $_GET['event_id'];
$event = $conn->query("SELECT * FROM events WHERE event_id='$event_id'")->fetch_assoc();
?>
<link rel="stylesheet" href="css/style.css">
<h2>Book Tickets for <?php echo $event['title']; ?></h2>
<p>Date: <?php echo $event['date']; ?> at <?php echo $event['time']; ?></p>
<p>Location: <?php echo $event['location']; ?></p>

<form method="POST">
    <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
    Quantity: <input type="number" name="quantity" min="1" max="<?php echo $event['total_tickets'] - $event['tickets_sold']; ?>" required><br><br>
    <button type="submit">Book Tickets</button>
</form>