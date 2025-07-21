<?php


session_start();
include '../includes/db.php';
include '../includes/auth.php';

// Check if admin
requireLogin();
if (!isAdmin()) {
  die("Unauthorized access.");
}

// Fetch all reservations (example query)
$query = "
  SELECT 
    r.reserve_id,
    r.intern_id,
    r.seat_id,
    r.reservation_date,
    r.time_slot,
    r.status,
    s.seat_num,
    s.location,
    u.name AS intern_name
  FROM reservations r
  JOIN seats s ON r.seat_id = s.seat_id
  JOIN users u ON r.intern_id = u.user_id
  ORDER BY r.reservation_date DESC
";
$result = $conn->query($query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Reservations | Seat Reservation System</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/admin_panel.css">
  <link rel="stylesheet" href="../css/admin_reserve.css">
</head>
<body>

<?php include '../components/header.php'; ?>
<?php include '../components/sidebar.php'; ?>

<div class="admin-container">
  <div class="main-wrapper">
    <main class="main-content">
      <header class="main-header">
        <h1>Manage Reservations</h1>
      </header>

      <!-- Success / Alerts -->
      <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
          <?= $_SESSION['success_message']; ?>
          <?php unset($_SESSION['success_message']); ?>
        </div>
      <?php endif; ?>

      <!-- Reservation Table -->
      <section class="content-card">
        <div class="card-header">
          <h2><i class="fas fa-calendar-check"></i> All Reservations</h2>
          <div class="card-actions">
            <span class="total-reservations">
              <i class="fas fa-chair"></i> Total: <?= $result->num_rows; ?> reservations
            </span>
          </div>
        </div>
        <div class="table-responsive">
          <table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Intern</th>
      <th>Seat</th>
      <th>Location</th>
      <th>Date</th>
      <th>Time Slot</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['reserve_id']); ?></td>
      <td><?= htmlspecialchars($row['intern_name']); ?></td>
      <td><?= htmlspecialchars($row['seat_num']); ?></td>
      <td><?= htmlspecialchars($row['location']); ?></td>
      <td><?= htmlspecialchars($row['reservation_date']); ?></td>
      <td><?= htmlspecialchars($row['time_slot']); ?></td>
      <td><?= htmlspecialchars($row['status']); ?></td>
      <td>
        <a href="?delete=<?= $row['reserve_id']; ?>" 
           onclick="return confirm('Cancel this reservation?');">
          Cancel
        </a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

        </div>
      </section>
    </main>
  </div>
</div>

<?php

//Handle delete
if (isset($_GET['delete'])) {
  $reservation_id = intval($_GET['delete']);
  $stmt = $conn->prepare("DELETE FROM reservations WHERE reservation_id = ?");
  $stmt->bind_param("i", $reservation_id);
  $stmt->execute();
  $stmt->close();
  $_SESSION['success_message'] = "Reservation cancelled successfully!";
  header("Location: admin_reserve.php");
  exit;
}
?>

</body>
</html>
