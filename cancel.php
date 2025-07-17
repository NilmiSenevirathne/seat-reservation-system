<?php include 'includes/db.php'; include 'includes/auth.php'; 
$id = $_GET['id'];
$sql = "UPDATE reservations SET status='cancelled' WHERE id=$id";
if ($conn->query($sql)) {
  echo "Reservation cancelled! <a href='dashboard.php'>Back</a>";
} else {
  echo "Error: " . $conn->error;
}
?>
