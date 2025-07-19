<?php
include 'includes/db.php';
include 'includes/auth.php';

// Block non-admins
requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register New Admin</title>
  <link rel="stylesheet" href="css/register.css" />
</head>
<body>
  <div class="container">
    <h2>Register New Admin</h2>

    <form method="POST">
      <input type="email" name="email" placeholder="Admin Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <input type="password" name="confirm_password" placeholder="Confirm Password" required />
      <button type="submit" name="register_admin">Register Admin</button>
    </form>
    <a href="admin_panel.php">⬅ Back to Admin Panel</a>
  </div>

<?php
if (isset($_POST['register_admin'])) {
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if ($password !== $confirm_password) {
    echo "<script>alert('Passwords do not match!');</script>";
    exit;
  }

  // Check if user already exists
  $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    echo "<script>alert('User with this email already exists!');</script>";
  } else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, 'admin')");
    $stmt->bind_param("ss", $email, $hashed_password);
    if ($stmt->execute()) {
      echo "<script>alert('New admin registered successfully!'); window.location.href = 'admin_panel.php';</script>";
    } else {
      echo "<script>alert('Error adding admin!');</script>";
    }
  }
  $stmt->close();
}
?>

</body>
</html>
