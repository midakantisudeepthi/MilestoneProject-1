<?php
session_start();
include 'db.php';

// Only organizer can access
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'organizer'){
    die("Access denied. You must be an organizer to create events.");
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $total_tickets = $_POST['total_tickets'];
    $organizer_id = $_SESSION['user_id'];

    $sql = "INSERT INTO events(title,description,location,date,time,total_tickets,organizer_id)
            VALUES('$title','$description','$location','$date','$time','$total_tickets','$organizer_id')";

    if($conn->query($sql)){
        echo "Event created successfully! <a href='index.php'>View Events</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<link rel="stylesheet" href="css/style.css">

<h2>Create Event</h2>
<form method="POST">
    <input type="text" name="title" placeholder="Event Title" required><br><br>
    <textarea name="description" placeholder="Event Description"></textarea><br><br>
    <input type="text" name="location" placeholder="Location"><br><br>
    <input type="date" name="date" required><br><br>
    <input type="time" name="time" required><br><br>
    <input type="number" name="total_tickets" placeholder="Total Tickets" required><br><br>
    <button type="submit">Create Event</button>
</form>