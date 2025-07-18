<?php 
include 'includes/db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register - SLT</title>
  <link rel="stylesheet" href="css/register.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>

<div class="container">

  <div class="signup-left">
    <h2>Create Account</h2>

    <form method="POST">
      <input type="text" name="name" placeholder="Name" required />
      <input type="email" name="email" placeholder="Email" required />
      <div class="password-wrapper">
         <input type="password" id="password" name="password" placeholder="Enter your password" required>
         <span class="toggle-password"><i class="fa fa-eye"></i></span>
      </div>

      <div class="password-wrapper">
        <input type="password" id="repeat_password" name="repeat_password" placeholder="Repeat your password" required>
        <span class="toggle-password"><i class="fa fa-eye"></i></span>
      </div>
      <button type="submit" name="register">Sign Up</button>
    </form>

    <p>Already have an account? <a href="login.php">Sign In</a></p>
  </div>

</div>

<?php
if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $repeat_password = $_POST['repeat_password'];

  if ($password !== $repeat_password) {
    echo "<script>alert('Passwords do not match!');</script>";
  } else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', 'intern')";
    if ($conn->query($sql)) {
      echo "<script>alert('Successfully Registered!'); window.location.href = 'login.php';</script>";
    } else {
      echo "<script>alert('Error: " . addslashes($conn->error) . "');</script>";
    }
  }
}
?>
<script src="js/validation.js"></script>

</body>
</html>
