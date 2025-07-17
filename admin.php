<?php include 'includes/db.php'; include 'includes/auth.php'; include 'includes/header.php';
if ($_SESSION['role'] !== 'admin') { header("Location: dashboard.php"); exit; }
?>

<h2>Admin Panel</h2>
<a href="add_seat.php" class="btn btn-primary mb-3">Add New Seat</a>
<h4>All Seats</h4>
<?php
$result = $conn->query("SELECT * FROM seats");
if ($result->num_rows > 0) {
  echo "<table class='table'><tr><th>Seat</th><th>Location</th><th>Status</th></tr>";
  while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['seat_number']}</td><td>{$row['location']}</td><td>{$row['status']}</td></tr>";
  }
  echo "</table>";
}
include 'includes/footer.php';
?>
