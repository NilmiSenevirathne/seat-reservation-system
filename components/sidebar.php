<?php
$role = $_SESSION['role'] ?? 'guest';

$sidebars = [
    'admin' => [
        ["href" => "../components/dashboard.php", "icon" => "fas fa-home", "text" => "Dashboard"],
        ["href" => "../admin/admin_manage_seat.php", "icon" => "fas fa-users-cog", "text" => "Manage Seats"],
        ["href" => "../admin/admin_reserve.php", "icon" => "fas fa-calendar-check", "text" => "Reservations"],
        ["href" => "reports.php", "icon" => "fas fa-chart-line", "text" => "Reports"],
        ["href" => "logout.php", "icon" => "fas fa-sign-out-alt", "text" => "Logout"],  
    ],
    'intern' => [
        ["href" => "dashboard.php", "icon" => "fas fa-home", "text" => "Dashboard"],
        ["href" => "manage_tools.php", "icon" => "fas fa-tools", "text" => "Manage Tools"],
        ["href" => "logout.php", "icon" => "fas fa-sign-out-alt", "text" => "Logout"],
    ]
];

$links = $sidebars[$role] ?? [];
?>

<!-- Toggle Button (Mobile Only) -->
<button class="sidebar-toggle" id="sidebarToggle">
  <i class="fas fa-bars"></i>
</button>

<!-- Sidebar Navigation -->
<nav class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <h3>Seat Seservation System</h3>
  </div>
  <ul class="sidebar-menu">
    <?php foreach ($links as $link): ?>
      <li class="menu-item">
        <a href="<?= htmlspecialchars($link['href']) ?>" class="menu-link">
          <i class="<?= htmlspecialchars($link['icon']) ?> menu-icon"></i>
          <span class="menu-text"><?= htmlspecialchars($link['text']) ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>

<link rel="stylesheet" href="../css/sidebar.css">
<script src="../js/sidebar.js"></script>