<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../includes/db.php';
require_once '../includes/auth.php';

// Make sure only interns can access
requireIntern();

$intern_id = $_SESSION['user_id'] ?? null;

if (!$intern_id) {
    header("Location: login.php");
    exit();
}

// Handle AJAX cancellation request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_id'])) {
    header('Content-Type: application/json');

    $cancel_id = intval($_POST['cancel_id']);

    $stmt = $conn->prepare("
        UPDATE reservations 
        SET status = 'cancelled' 
        WHERE reserve_id = ? 
        AND intern_id = ? 
        AND reservation_date >= CURDATE()
    ");
    $stmt->bind_param("ii", $cancel_id, $intern_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cancellation failed or reservation cannot be cancelled']);
    }
    $stmt->close();
    $conn->close();
    exit();
}

// === Get ACTIVE (future) reservations ===
$active_sql = "
    SELECT r.*, s.seat_num, s.location 
    FROM reservations r
    JOIN seats s ON r.seat_id = s.seat_id
    WHERE r.intern_id = ?
      AND r.status = 'active'
      AND r.reservation_date >= CURDATE()
    ORDER BY r.reservation_date ASC
";

$active_stmt = $conn->prepare($active_sql);
$active_stmt->bind_param("i", $intern_id);
$active_stmt->execute();
$active_result = $active_stmt->get_result();

// === Get PAST reservations ===
$past_sql = "
    SELECT r.*, s.seat_num, s.location 
    FROM reservations r
    JOIN seats s ON r.seat_id = s.seat_id
    WHERE r.intern_id = ?
      AND (r.status != 'active' OR r.reservation_date < CURDATE())
    ORDER BY r.reservation_date DESC
";

$past_stmt = $conn->prepare($past_sql);
$past_stmt->bind_param("i", $intern_id);
$past_stmt->execute();
$past_result = $past_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>My Reservations</title>
    <link rel="stylesheet" href="../css/reserve.css" />
</head>
<body>
<div class="container">
    <?php include '../components/header.php'; ?>
    <?php include '../components/sidebar.php'; ?>

    <h1>My Reservations</h1>

    <div class="reservations-wrapper-vertical">
        <div class="reservation-section">
            <h2>Active Reservations</h2>
            <table id="active-reservations" class="reservation-table">
                <thead>
                    <tr>
                        <th>Seat Number</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($active_result->num_rows > 0): ?>
                    <?php while ($row = $active_result->fetch_assoc()): ?>
                        <tr data-reservation-id="<?= $row['reserve_id'] ?>">
                            <td><?= htmlspecialchars($row['seat_num']) ?></td>
                            <td><?= htmlspecialchars($row['location']) ?></td>
                            <td><?= htmlspecialchars($row['reservation_date']) ?></td>
                            <td class="status"><?= htmlspecialchars($row['status']) ?></td>
                            <td>
                                <a href="#" 
                                   class="cancel-btn" 
                                   data-reservation-id="<?= $row['reserve_id'] ?>"
                                >Cancel</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center;">You have no active reservations.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="reservation-section">
            <h2>Past Reservations</h2>
            <table id="past-reservations" class="reservation-table">
                <thead>
                    <tr>
                        <th>Seat Number</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($past_result->num_rows > 0): ?>
                    <?php while ($row = $past_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['seat_num']) ?></td>
                            <td><?= htmlspecialchars($row['location']) ?></td>
                            <td><?= htmlspecialchars($row['reservation_date']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td>N/A</td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center;">You have no past reservations.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="../js/reservations.js"></script>


</body>
</html>

<?php
$active_stmt->close();
$past_stmt->close();
$conn->close();
?>
