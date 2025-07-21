<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../includes/db.php';
require_once '../includes/auth.php';

// Check if user is logged in as intern
requireIntern();

$intern_id = $_SESSION['user_id'];
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$selected_location = isset($_GET['location']) ? $_GET['location'] : '';

// Get available seats
$sql = "SELECT s.* FROM seats s 
        WHERE s.seat_id NOT IN (
            SELECT r.seat_id FROM reservations r 
            WHERE r.reservation_date = ? AND r.status = 'active'
        )";

if (!empty($selected_location)) {
    $sql .= " AND s.location = ?";
}

$stmt = $conn->prepare($sql);

if (!empty($selected_location)) {
    $stmt->bind_param("ss", $selected_date, $selected_location);
} else {
    $stmt->bind_param("s", $selected_date);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Seat</title>
    <link rel="stylesheet" href="../css/intern_book_seats.css">
</head>
<body>
    <div class="container">
        <?php include '../components/header.php'; ?>
        <?php include '../components/sidebar.php'; ?>
        <h1>Book Your Seat</h1>
        
        <div class="filter-box">
            <form class="filter-form" method="get" action="intern_book_seats.php">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" 
                           value="<?php echo htmlspecialchars($selected_date); ?>" 
                           min="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="location">Location</label>
                    <select id="location" name="location">
                        <option value="">All Locations</option>
                        <option value="Window Side" <?php echo $selected_location == 'Window Side' ? 'selected' : ''; ?>>Window Side</option>
                        <option value="Middle" <?php echo $selected_location == 'Middle' ? 'selected' : ''; ?>>Middle</option>
                        <option value="Front" <?php echo $selected_location == 'Front' ? 'selected' : ''; ?>>Front</option>
                        <option value="Back" <?php echo $selected_location == 'Back' ? 'selected' : ''; ?>>Back</option>
                    </select>
                </div>
                
                <button type="submit">Filter Seats</button>
            </form>
        </div>
        
        <div class="seats-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($seat = $result->fetch_assoc()): ?>
                    <div class="seat-card">
                        <div class="seat-number">Seat <?php echo htmlspecialchars($seat['seat_num']); ?></div>
                        <div class="seat-location"><?php echo htmlspecialchars($seat['location']); ?></div>
                        <div class="seat-date"><?php echo htmlspecialchars($selected_date); ?></div>
                        <a href="reserve_seat.php?seat_id=<?php echo $seat['seat_id']; ?>&date=<?php echo urlencode($selected_date); ?>" 
                           class="book-btn">
                            Book This Seat
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-seats">
                    <h3>No available seats found</h3>
                    <p>Please try a different date or location</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php
// $stmt->close();
$conn->close();
?>