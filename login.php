<?php include 'includes/db.php'; include 'includes/header.php'; ?>
<h2>Login</h2>
<form method="POST" class="w-50">
  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <button type="submit" name="login" class="btn btn-primary">Login</button>
</form>

<?php
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = $conn->query($sql);
  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      session_start();
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['role'] = $row['role'];
      header("Location: dashboard.php");
    } else {
      echo "<div class='alert alert-danger mt-3'>Invalid password.</div>";
    }
  } else {
    echo "<div class='alert alert-danger mt-3'>User not found.</div>";
  }
}
include 'includes/footer.php';
?>
