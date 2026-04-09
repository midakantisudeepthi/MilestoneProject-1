<?php
session_start();
include 'db.php'; // Make sure db.php exists and has correct DB credentials

// Set maximum tickets per registration
$max_per_user = 5;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt password
    $event_id = $_POST['event_id'];
    $quantity = (int)$_POST['quantity'];

    // Server-side ticket limit check
    if($quantity < 1 || $quantity > $max_per_user){
        die("You can book between 1 and $max_per_user tickets per registration!");
    }

    // Check if enough tickets are available
    $event_result = $conn->query("SELECT total_tickets, tickets_sold, title FROM events WHERE event_id='$event_id'");
    if($event_result->num_rows == 0){
        die("Selected event not found!");
    }
    $event = $event_result->fetch_assoc();


    // Insert user into users table
    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username','$email','$password','user')";
    if($conn->query($sql) === TRUE){
        $user_id = $conn->insert_id;

        // Add tickets for this user
        $conn->query("INSERT INTO tickets(user_id,event_id,quantity) VALUES($user_id,$event_id,$quantity)");

        // Update tickets sold in events table
        $conn->query("UPDATE events SET tickets_sold = tickets_sold + $quantity WHERE event_id=$event_id");

        echo "<h3>Registration successful!</h3>";
        echo "You have booked $quantity ticket(s) for event: <b>{$event['title']}</b>.<br>";
        echo "<a href='login.php'>Click here to login</a>";
        exit;
    } else {
        die("Error registering user: " . $conn->error);
    }
}

// Fetch all events for dropdown
$events = $conn->query("SELECT * FROM events ORDER BY date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Registration</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        input, select, button { padding: 8px; margin: 5px 0; width: 300px; }
        button { cursor: pointer; background-color: #007BFF; color: white; border: none; }
        button:hover { background-color: #0056b3; }
        /* Container styling to center the form */
body {
    font-family: 'Segoe UI', Roboto, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

form {
    background: rgba(255, 255, 255, 0.95);
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
}

form h2 {
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

/* Label & Input styling */
label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #555;
    font-size: 14px;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="number"],
select {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-sizing: border-box; /* Ensures padding doesn't affect width */
    font-size: 16px;
    transition: border-color 0.3s ease;
}

input:focus, select:focus {
    outline: none;
    border-color: #764ba2;
    box-shadow: 0 0 5px rgba(118, 75, 162, 0.2);
}

/* Button styling */
button[type="submit"] {
    width: 100%;
    background: #764ba2;
    color: white;
    padding: 14px;
    border: none;
    border-radius: 8px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease;
}

button[type="submit"]:hover {
    background: #5a397a;
    transform: translateY(-1px);
}

button[type="submit"]:active {
    transform: translateY(1px);
}

/* Responsive tweak */
@media (max-width: 480px) {
    form {
        padding: 20px;
        margin: 20px;
    }
}
    </style>
</head>
<body>
    
    <form method="POST">
        <h2>User Registration & Event Booking</h2>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>

        <label>Select Event:</label><br>
        <select name="event_id" required>
            <option value="">--Select Event--</option>
            <?php while($row = $events->fetch_assoc()) { ?>
                <option value="<?php echo $row['event_id']; ?>">
                    <?php echo $row['title'] . " (" . $row['date'] . ")"; ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Number of Tickets (max <?php echo $max_per_user; ?>):</label><br>
        <input type="number" name="quantity" min="1" max="<?php echo $max_per_user; ?>" value="1" required><br>

        <button type="submit">Register & Book Tickets</button>
         <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>

   
</body>
</html>