<?php
include '../includes/db.php';
include '../includes/auth.php';
requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/admin_panel.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div class="logo">
    <h2 class="logo-title">Seat Reservation System</h2>
  </div>
  <ul class="menu">
    <li><a href="#"><i class="fas fa-home"></i> Dashboard</a></li>
    <li><a href="admin_add_seat.php"><i class="fas fa-chair"></i> Add Seat</a></li>
    <li><a href="admin_reservations.php"><i class="fas fa-calendar-alt"></i> Reservations</a></li>
    <li><a href="admin_assign_seat.php"><i class="fas fa-user-check"></i> Assign Seats</a></li>
    <li><a href="admin_report.php"><i class="fas fa-chart-line"></i> Reports</a></li>
    <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Sign Out</a></li>
  </ul>
</div>

<!-- Main Content -->
<div class="main-content">
  <header>
    <h1>Dashboard</h1>
    <input type="text" placeholder="Search..." />
    <div class="profile">
      <i class="fas fa-bell"></i>
      <img src="https://i.pravatar.cc/40" alt="Admin" />
    </div>
  </header>

  <section class="widgets">
    <div class="widget">
      <h3>Bookings</h3>
      <div class="chart-placeholder">[Graph]</div>
    </div>
    <div class="widget">
      <h3>Cancellation</h3>
      <div class="chart-placeholder">[Graph]</div>
    </div>
    <div class="widget">
      <h3>Daily Booking Summary</h3>
      <ul>
        <li>Bookings: 194</li>
        <li>Website Visits: 75,521</li>
        <li>Revenue: $34,245</li>
        <li>Followers: 245+</li>
      </ul>
    </div>
    <div class="widget">
      <h3>Active Bookings</h3>
      <div class="active-bookings-placeholder">[Cards]</div>
    </div>
  </section>

  

</div>

</body>
</html>
