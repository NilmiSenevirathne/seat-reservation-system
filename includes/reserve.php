<?php include 'includes/db.php'; include 'includes/auth.php'; 
$intern_id = $_SESSION['user_id'];
$seat_id = $_GET['seat_id'];
$date = $_GET['date'];

$sql = "SELECT * FROM reservations WHERE intern_id=$intern_id AND reservation_date='$date' AND status='active'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  echo "You already have a reservation for this date. <a href='dashboard.php'>Back</a>";
} else {
  $sql = "INSERT INTO reservations (intern_id, seat_id, reservation_date, time_slot, status)
          VALUES ($intern_id, $seat_id, '$date', 'full-day', 'active')";
  if ($conn->query($sql)) {
    echo "Seat reserved! <a href='dashboard.php'>Back</a>";
  } else {
    echo "Error: " . $conn->error;
  }
}
?>
