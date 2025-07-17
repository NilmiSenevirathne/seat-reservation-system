<?php include 'includes/db.php'; include 'includes/auth.php'; include 'includes/header.php'; ?>
<h2>Intern Dashboard</h2>
<form method="GET" class="w-50 mb-3">
  <label>Select Date</label>
  <input type="date" name="date" class="form-control" required>
  <button type="submit" class="btn btn-primary mt-2">Check Seats</button>
</form>

<?php
if (isset($_GET['date'])) {
  $date = $_GET['date'];
  $sql = "SELECT * FROM seats WHERE status='available' AND id NOT IN (
    SELECT seat_id FROM reservations WHERE reservation_date='$date' AND status='active')";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo "<table class='table'><tr><th>Seat</th><th>Location</th><th>Action</th></tr>";
    while ($row = $result->fetch_assoc()) {
      echo "<tr><td>{$row['seat_number']}</td><td>{$row['location']}</td>
      <td><a class='btn btn-success' href='reserve.php?seat_id={$row['id']}&date=$date'>Reserve</a></td></tr>";
    }
    echo "</table>";
  } else {
    echo "<div class='alert alert-warning'>No seats available for this date.</div>";
  }
}
?>

<h3>My Reservations</h3>
<?php
$intern_id = $_SESSION['user_id'];
$sql = "SELECT reservations.*, seats.seat_number FROM reservations 
JOIN seats ON reservations.seat_id = seats.id 
WHERE intern_id=$intern_id AND status='active'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  echo "<table class='table'><tr><th>Seat</th><th>Date</th><th>Action</th></tr>";
  while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['seat_number']}</td><td>{$row['reservation_date']}</td>
    <td><a class='btn btn-danger' href='cancel.php?id={$row['id']}'>Cancel</a></td></tr>";
  }
  echo "</table>";
} else {
  echo "<div class='alert alert-info'>No active reservations.</div>";
}
include 'includes/footer.php';
?>
