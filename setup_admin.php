<?php
include 'includes/db.php';

// Check if any admin already exists
$result = $conn->query("SELECT user_id FROM users WHERE role = 'admin' LIMIT 1");
if ($result->num_rows > 0) {
  // Admin already exists, redirect to login
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Setup Initial Admin</title>
  <link rel="stylesheet" href="css/register.css" />
</head>
<body>
  <div class="container">
    <h2>Setup Initial Admin</h2>
    <form method="POST">
      <input type="text" name="name" placeholder="Admin Name" required>
      <input type="email" name="email" placeholder="Admin Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      <button type="submit" name="setup_admin">Create Admin</button>
    </form>
  </div>

<?php
if (isset($_POST['setup_admin'])) {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirm = $_POST['confirm_password'];

  if ($password !== $confirm) {
    echo "<script>alert('Passwords do not match!');</script>";
    exit;
  }

  $hashed = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'admin')");
  $stmt->bind_param("sss", $name, $email, $hashed);

  if ($stmt->execute()) {
    echo "<script>alert('Initial Admin Created! Redirecting to login.'); window.location.href = 'login.php';</script>";
  } else {
    echo "<script>alert('Error creating admin.');</script>";
  }
  $stmt->close();
}
?>

</body>
</html>
