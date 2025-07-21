<?php
// sidebar.php
$role = $_SESSION['role'] ?? 'guest';

$sidebars = [
    'admin' => [
        ["href" => "dashboard.php", "icon" => "fas fa-home", "text" => "Dashboard"],
        ["href" => "admin/admin_manage_seat.php", "icon" => "fas fa-users-cog", "text" => "Manage Seats"],

        ["href" => "reports.php", "icon" => "fas fa-chart-line", "text" => "Reports"],
    ],
    'intern' => [
        ["href" => "dashboard.php", "icon" => "fas fa-home", "text" => "Dashboard"],
        ["href" => "manage_tools.php", "icon" => "fas fa-tools", "text" => "Manage Tools"],
    ]
];

$links = $sidebars[$role] ?? [];
?>

<nav class="sidebar" id="sidebar">
  <ul>
    <?php foreach ($links as $link): ?>
      <li>
        <a href="<?= htmlspecialchars($link['href']) ?>">
          <i class="<?= htmlspecialchars($link['icon']) ?>"></i>
          <?= htmlspecialchars($link['text']) ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>