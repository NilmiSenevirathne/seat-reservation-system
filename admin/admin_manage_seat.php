<?php
include '../includes/db.php';
include '../includes/auth.php';
requireAdmin();

// Function to get next seat number based on location
function getNextSeatNumber($conn, $location) {
    $prefixes = [
        'Window Side' => 'W',
        'Middle' => 'M',
        'Front' => 'F',
        'Back' => 'B'
    ];
    
    $prefix = $prefixes[$location] ?? '';
    
    // Get the highest existing number for this location
    $query = "SELECT MAX(CAST(SUBSTRING(seat_num, 2) AS UNSIGNED)) as max_num 
              FROM seats 
              WHERE seat_num LIKE '$prefix%'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    
    $nextNum = ($row['max_num'] ?? 0) + 1;
    
    return $prefix . $nextNum;
}

// Handle seat operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_seat'])) {
        $seat_num = trim($_POST['seat_num']);
        $location = trim($_POST['location']);
        
        if (!empty($seat_num) && !empty($location)) {
            $stmt = $conn->prepare("INSERT INTO seats (seat_num, location) VALUES (?, ?)");
            $stmt->bind_param("ss", $seat_num, $location);
            $stmt->execute();
            $stmt->close();
            $_SESSION['success_message'] = "Seat added successfully!";
        }
        header("Location: admin_manage_seats.php");
        exit;
    }

    if (isset($_POST['update_seat'])) {
        $seat_id = $_POST['seat_id'];
        $seat_num = trim($_POST['seat_num']);
        $location = trim($_POST['location']);
        
        if (!empty($seat_num) && !empty($location)) {
            $stmt = $conn->prepare("UPDATE seats SET seat_num=?, location=? WHERE seat_id=?");
            $stmt->bind_param("ssi", $seat_num, $location, $seat_id);
            $stmt->execute();
            $stmt->close();
            $_SESSION['success_message'] = "Seat updated successfully!";
        }
        header("Location: admin_manage_seats.php");
        exit;
    }
}

// Delete Seat
if (isset($_GET['delete'])) {
    $seat_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM seats WHERE seat_id=?");
    $stmt->bind_param("i", $seat_id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['success_message'] = "Seat deleted successfully!";
    header("Location: admin_manage_seats.php");
    exit;
}

// AJAX endpoint for getting next seat number
if (isset($_GET['get_next_seat']) && isset($_GET['location'])) {
    echo json_encode(['seat_num' => getNextSeatNumber($conn, $_GET['location'])]);
    exit;
}

// Get all seats
$result = $conn->query("SELECT * FROM seats ORDER BY seat_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Seats | Seat Reservation System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../css/admin_panel.css">
  <link rel="stylesheet" href="../css/admin_manage_seat.css">
  <style>
    .fa-spinner {
      margin-left: 5px;
    }
  </style>
</head>
<body>

<?php include '../components/header.php'; ?>
<?php include '../components/sidebar.php'; ?>

<div class="admin-container">
  <!-- Main Content Area -->
  <div class="main-wrapper">
    <!-- Header -->
    <main class="main-content">
      <header class="main-header">
        <h1>Seat Management</h1>
        <div class="header-actions">
          <button id="openAddModal" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Seat
          </button>
        </div>
      </header>

      <!-- Notification Alert -->
      <?php if (isset($_SESSION['success_message'])): ?>
      <div class="alert alert-success">
        <?= $_SESSION['success_message']; ?>
        <?php unset($_SESSION['success_message']); ?>
      </div>
      <?php endif; ?>

      <!-- Search and Filter Section -->
      <section class="search-filter">
        <div class="search-box">
          <i class="fas fa-search"></i>
          <input type="text" id="searchInput" placeholder="Search seats...">
        </div>
        <div class="filter-options">
          <select id="locationFilter">
            <option value="">All Locations</option>
            <option value="Window Side">Window Side</option>
            <option value="Middle">Middle</option>
            <option value="Front">Front</option>
            <option value="Back">Back</option>
          </select>
        </div>
      </section>

      <!-- Seats Table -->
      <section class="content-card">
        <div class="card-header">
          <h2><i class="fas fa-list"></i> All Seats</h2>
          <div class="card-actions">
            <span class="total-seats">
              <i class="fas fa-chair"></i> Total: <?= $result->num_rows; ?> seats
            </span>
          </div>
        </div>
        <div class="table-responsive">
          <table id="seatsTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Seat Number</th>
                <th>Location</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row['seat_id']; ?></td>
                <td><span class="seat-badge"><?= htmlspecialchars($row['seat_num']); ?></span></td>
                <td><?= htmlspecialchars($row['location']); ?></td>
                <td><span class="status-badge available">Available</span></td>
                <td class="action-buttons">
                  <button class="btn btn-sm btn-edit" onclick="openUpdateModal(
                    <?= $row['seat_id']; ?>, 
                    '<?= htmlspecialchars($row['seat_num']); ?>', 
                    '<?= htmlspecialchars($row['location']); ?>'
                  )">
                    <i class="fas fa-edit"></i> Edit
                  </button>
                  <a href="?delete=<?= $row['seat_id']; ?>" class="btn btn-sm btn-danger" 
                     onclick="return confirm('Are you sure you want to delete this seat?')">
                    <i class="fas fa-trash"></i> Delete
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

<!-- Add Seat Modal -->
<div id="addModal" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3><i class="fas fa-plus-circle"></i> Add New Seat</h3>
        <button class="close" onclick="closeAddModal()">&times;</button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <div class="form-group">
            <label for="location"><i class="fas fa-map-marker-alt"></i> Location</label>
            <select id="location" name="location" required>
              <option value="">Select Location</option>
              <option value="Window Side">Window Side</option>
              <option value="Middle">Middle</option>
              <option value="Front">Front</option>
              <option value="Back">Back</option>
            </select>
          </div>
          <div class="form-group">
            <label for="seat_num"><i class="fas fa-hashtag"></i> Seat Number</label>
            <input type="text" id="seat_num" name="seat_num" placeholder="e.g., A1, B2, etc." required>
            <span id="seat_num_loading" style="display:none;"><i class="fas fa-spinner fa-spin"></i></span>
          </div>
          
          <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Cancel</button>
            <button type="submit" name="add_seat" class="btn btn-primary">
              <i class="fas fa-save"></i> Save Seat
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Update Seat Modal -->
<div id="updateModal" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3><i class="fas fa-edit"></i> Update Seat</h3>
        <button class="close" onclick="closeUpdateModal()">&times;</button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <input type="hidden" name="seat_id" id="update_seat_id">
          <div class="form-group">
            <label for="update_seat_num"><i class="fas fa-hashtag"></i> Seat Number</label>
            <input type="text" id="update_seat_num" name="seat_num" required>
          </div>
          <div class="form-group">
            <label for="update_location"><i class="fas fa-map-marker-alt"></i> Location</label>
            <select id="update_location" name="location" required>
              <option value="Window Side">Window Side</option>
              <option value="Middle">Middle</option>
              <option value="Front">Front</option>
              <option value="Back">Back</option>
            </select>
          </div>
          <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="closeUpdateModal()">Cancel</button>
            <button type="submit" name="update_seat" class="btn btn-primary">
              <i class="fas fa-save"></i> Update Seat
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="../js/manage_seat.js"></script>
</body>
</html>