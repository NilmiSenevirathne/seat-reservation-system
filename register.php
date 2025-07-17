<?php include 'includes/db.php'; include 'includes/header.php'; ?>
<h2>Register</h2>
<form method="POST" class="w-50">
  <div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <button type="submit" name="register" class="btn btn-primary">Register</button>
</form>

<?php
if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'intern')";
  if ($conn->query($sql)) {
    echo "<div class='alert alert-success mt-3'>Successfully Registered! <a href='login.php'>Login</a></div>";
  } else {
    echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
  }
}
include 'includes/footer.php';
?>
