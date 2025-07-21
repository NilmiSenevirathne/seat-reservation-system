<?php
session_start();
include '../includes/db.php'; // Make sure this path is correct

// Default name
$user_name = 'Guest';

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
  $stmt = $conn->prepare("SELECT name FROM users WHERE user_id = ?");
  $stmt->bind_param("i", $_SESSION['user_id']);
  $stmt->execute();
  $stmt->bind_result($name);
  if ($stmt->fetch()) {
    $user_name = $name;
  }
  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Panel</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <!-- CSS -->
  <link rel="stylesheet" href="../css/header.css">
</head>
<body>

<header class="topbar">
  <div class="logo">
    <h1>SeatReserve</h1>
  </div>

  <div class="search-bar">
    <input type="text" placeholder="Search..." />
    <i class="fas fa-search"></i>
  </div>

  <div class="user-info">
    <span><?= htmlspecialchars($user_name) ?></span>
  </div>
</header>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-bar input');
    const searchIcon = document.querySelector('.search-bar i');

    searchIcon.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') performSearch();
    });

    function performSearch() {
      const query = searchInput.value.trim();
      if (query !== '') {
        console.log('Searching for:', query);
        // window.location.href = 'search.php?q=' + encodeURIComponent(query);
      }
    }
  });
</script>

</body>
</html>
