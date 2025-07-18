<?php 
include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>SLT Sign Up</title>
  <link rel="stylesheet" href="css/register.css">
</head>
<body>

<div class="container">
  <!-- Left side: Form -->
  <div class="signup-left">
    <h2>Get Started Now</h2>

    <form method="POST">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your name" required>
      </div>

      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>

      <div class="form-group">
        <label for="repeat_password">Confirm Password</label>
        <input type="password" id="repeat_password" name="repeat_password" placeholder="Repeat your password" required>
      </div>

      <div class="form-group checkbox">
        <input type="checkbox" id="terms" required>
        <label for="terms">I agree to the Terms & Policy</label>
      </div>

      <button type="submit" name="register" class="btn">Register</button>

      <div class="separator"><span>or</span></div>

      <div class="social-login">
        <a href="google_login.php" class="social-btn google">Sign up with Google</a>
        <a href="facebook_login.php" class="social-btn facebook">Sign up with Facebook</a>
      </div>

      <p class="login-link">Already have an account? <a href="login.php">Sign In</a></p>
    </form>

    <?php
    if (isset($_POST['register'])) {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $repeat_password = $_POST['repeat_password'];

      if ($password !== $repeat_password) {
        echo "<div class='alert error'>Passwords do not match!</div>";
      } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', 'intern')";
        if ($conn->query($sql)) {
          echo "<div class='alert success'>Successfully Registered! <a href='login.php'>Login</a></div>";
        } else {
          echo "<div class='alert error'>Error: " . $conn->error . "</div>";
        }
      }
    }
    ?>
  </div>

  <!-- Right side: Image -->
  <div class="signup-right"></div>
</div>

</body>
</html>

<?php include 'includes/footer.php'; ?>
