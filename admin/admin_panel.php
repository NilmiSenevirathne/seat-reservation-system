<?php
include '../includes/db.php';
include '../includes/auth.php';
requireAdmin();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles.css" />
</head>
<body>
<div class="container">
    <h1>Welcome to Admin Dashboard</h1>
    <nav>
        <ul>
            <li><a href="admin_add_seat.php">Add Seat</a></li>
            <li><a href="admin_reservations.php">View Reservations</a></li>
            <li><a href="admin_assign_seat.php">Assign Seats</a></li>
            <li><a href="admin_report.php">Seat Usage Reports</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
</div>
</body>
</html>
