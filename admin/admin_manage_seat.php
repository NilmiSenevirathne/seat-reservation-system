<?php
include '../includes/db.php';
include '../includes/auth.php';
requireAdmin();

// Add Seat
if (isset($_POST['add_seat'])) {
    $seat_num = trim($_POST['seat_num']);
    $location = trim($_POST['location']);

    if (!empty($seat_num) && !empty($location)) {
        $stmt = $conn->prepare("INSERT INTO seats (seat_num, location) VALUES (?, ?)");
        $stmt->bind_param("ss", $seat_num, $location);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: admin_manage_seats.php");
    exit;
}

// Update Seat
if (isset($_POST['update_seat'])) {
    $seat_id = $_POST['seat_id'];
    $seat_num = trim($_POST['seat_num']);
    $location = trim($_POST['location']);

    if (!empty($seat_num) && !empty($location)) {
        $stmt = $conn->prepare("UPDATE seats SET seat_num=?, location=? WHERE seat_id=?");
        $stmt->bind_param("ssi", $seat_num, $location, $seat_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: admin_manage_seats.php");
    exit;
}

// Delete Seat
if (isset($_GET['delete'])) {
    $seat_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM seats WHERE seat_id=?");
    $stmt->bind_param("i", $seat_id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_manage_seats.php");
    exit;
}

// Get seats
$result = $conn->query("SELECT * FROM seats ORDER BY seat_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Seats</title>
  <link rel="stylesheet" href="../css/admin_panel.css" />
  <link rel="stylesheet" href="../css/admin_manage_seat.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  
</head>
<body>
<div class="sidebar">
  <div class="logo">
    <h2 class="logo-title">Seat Reservation System</h2>
  </div>
  <ul class="menu">
    <li><a href="admin_panel.php"><i class="fas fa-home"></i> Dashboard</a></li>
    <li><a href="admin_manage_seats.php" class="active"><i class="fas fa-chair"></i> Manage Seats</a></li>
    <li><a href="admin_reservations.php"><i class="fas fa-calendar-alt"></i> Reservations</a></li>
    <li><a href="admin_assign_seat.php"><i class="fas fa-user-check"></i> Assign Seats</a></li>
    <li><a href="admin_report.php"><i class="fas fa-chart-line"></i> Reports</a></li>
    <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Sign Out</a></li>
  </ul>
</div>

<div class="main-content">
  <h1>Manage Seats</h1>
  <button id="openAddModal" class="btn-primary">Add New Seat</button>

  <!-- Seat table -->
  <h3>All Seats</h3>
  <table class="table-container">
    <tr>
      <th>ID</th>
      <th>Seat Number</th>
      <th>Location</th>
      <th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['seat_id']; ?></td>
      <td><?= htmlspecialchars($row['seat_num']); ?></td>
      <td><?= htmlspecialchars($row['location']); ?></td>
      <td>
        <button class="btn-primary" onclick="openUpdateModal(<?= $row['seat_id']; ?>, '<?= htmlspecialchars($row['seat_num']); ?>', '<?= htmlspecialchars($row['location']); ?>')">Update</button>
        <a href="?delete=<?= $row['seat_id']; ?>" class="btn" onclick="return confirm('Are you sure?')">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeAddModal()">&times;</span>
    <h3>Add New Seat</h3>
    <form method="POST">
      <input type="text" name="seat_num" placeholder="Seat Number" required><br><br>
      <input type="text" name="location" placeholder="Location" required><br><br>
      <button type="submit" name="add_seat" class="btn-primary">Add</button>
    </form>
  </div>
</div>

<!-- Update Modal -->
<div id="updateModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeUpdateModal()">&times;</span>
    <h3>Update Seat</h3>
    <form method="POST">
      <input type="hidden" name="seat_id" id="update_seat_id">
      <input type="text" name="seat_num" id="update_seat_num" required><br><br>
      <input type="text" name="location" id="update_location" required><br><br>
      <button type="submit" name="update_seat" class="btn-primary">Update</button>
    </form>
  </div>
</div>

<script>
  // Add modal
  const addModal = document.getElementById('addModal');
  document.getElementById('openAddModal').onclick = () => addModal.style.display = 'block';
  function closeAddModal() { addModal.style.display = 'none'; }

  // Update modal
  const updateModal = document.getElementById('updateModal');
  function openUpdateModal(id, seatNum, location) {
    document.getElementById('update_seat_id').value = id;
    document.getElementById('update_seat_num').value = seatNum;
    document.getElementById('update_location').value = location;
    updateModal.style.display = 'block';
  }
  function closeUpdateModal() { updateModal.style.display = 'none'; }

  // Close when clicking outside
  window.onclick = function(e) {
    if (e.target == addModal) closeAddModal();
    if (e.target == updateModal) closeUpdateModal();
  };
</script>
</body>
</html>
