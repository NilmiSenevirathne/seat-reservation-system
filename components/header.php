<?php
$user_name = $_SESSION['user_name'] ?? 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Panel</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <!-- CSS -->
  <link rel="stylesheet" href="../css/style.css">
<header class="topbar">
  <div class="logo">
    <h1>YourApp</h1>
  </div>
  <div class="user-info">
    <span><?= htmlspecialchars($user_name) ?></span>
    <img src="../images/default-user.png" alt="Profile Pic" class="profile-pic">
  </div>
</header>

