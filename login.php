<?php 
include 'includes/db.php'; 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login - SLT</title>
  <link rel="stylesheet" href="css/register.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>

<div class="container">

  <div class="login-left">
    <h2>Sign In</h2>

    <form method="POST">
      <input type="email" name="email" placeholder="Email" required />
      <div class="password-wrapper">
        <input type="password" id="login_password" name="password" placeholder="Enter your password" required>
        <span class="toggle-password"><i class="fa fa-eye"></i></span>
      </div>
      <button type="submit" name="login">Sign In</button>
    </form>

    <p>Don't have an account? <a href="register.php">Sign Up</a></p>
  </div>

</div>

<?php
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = $conn->query($sql);
  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['role'] = $row['role'];
      echo "<script>alert('Login Successful!'); window.location.href = 'dashboard.php';</script>";
    } else {
      echo "<script>alert('Invalid password.');</script>";
    }
  } else {
    echo "<script>alert('User not found.');</script>";
  }
}
?>
<script src="js/validation.js"></script>

</body>
</html>
