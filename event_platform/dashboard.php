<?php
session_start();
if(!isset($_SESSION['user_id'])){
    die("Access denied. Please <a href='login.php'>login</a> first.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | EventPlatform</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="dashboard-container">
    <aside class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-ticket-tone"></i> <span>EventPro</span>
        </div>
        <nav>
            <ul>
                <li class="active"><a href="#"><i class="fa-solid fa-house"></i> Overview</a></li>
                <li><a href="#"><i class="fa-solid fa-calendar-days"></i> My Events</a></li>
                <li><a href="#"><i class="fa-solid fa-receipt"></i> Tickets</a></li>
                <li><a href="#"><i class="fa-solid fa-user-gear"></i> Settings</a></li>
                <li class="logout-link"><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <header class="top-bar">
            <h2>Welcome back, <?php echo $_SESSION['username']; ?>!</h2>
            <div class="user-badge">
                <span class="role-tag"><?php echo strtoupper($_SESSION['role']); ?></span>
            </div>
        </header>

        <section class="stats-grid">
            <div class="stat-card">
                <i class="fa-solid fa-calendar-check"></i>
                <div>
                    <h3>4</h3>
                    <p>Upcoming Events</p>
                </div>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-ticket"></i>
                <div>
                    <h3>12</h3>
                    <p>Tickets Purchased</p>
                </div>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-bell"></i>
                <div>
                    <h3>2</h3>
                    <p>Notifications</p>
                </div>
            </div>
        </section>

        <div class="content-card">
            <h3>Recent Activity</h3>
            <p>You are currently logged in as a <strong><?php echo $_SESSION['role']; ?></strong>. Use the sidebar to manage your event lifecycle.</p>
        </div>
    </main>
</div>

</body>
</html>