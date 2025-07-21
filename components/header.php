<?php
// header.php

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
  <link rel="stylesheet" href="../css/header.css">
</head>
<body>

<header class="topbar">
  <div class="logo">
    <h1>SeatReserve</h1> <!-- Changed to a more relevant app name -->
  </div>
  
  <div class="search-bar">
    <input type="text" placeholder="Search..." />
    <i class="fas fa-search"></i>
  </div>

  <div class="user-info">
    <img src="../images/default-user.png" alt="Profile Picture" class="profile-pic">
    <span><?= htmlspecialchars($user_name) ?></span>
  </div>
</header>


<script>
  // Search functionality
  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-bar input');
    const searchIcon = document.querySelector('.search-bar i');
    
    // Search on icon click
    searchIcon.addEventListener('click', function() {
      performSearch();
    });
    
    // Search on Enter key
    searchInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        performSearch();
      }
    });
    
    function performSearch() {
      const query = searchInput.value.trim();
      if (query !== '') {
        // Implement your search functionality
        console.log('Searching for:', query);
        // window.location.href = 'search.php?q=' + encodeURIComponent(query);
      }
    }
  });
</script>