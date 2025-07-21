<?php
// dashboard.php
session_start();
$_SESSION['user_name'] = $_SESSION['user_name'] ?? 'Ama Senevirathne';
$_SESSION['role'] = $_SESSION['role'] ?? 'admin';  // For demo purpose
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Panel</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Your CSS -->
  <link rel="stylesheet" href="../css/style.css">

</head>
<body>

  <!-- Include Sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- Header -->
  <header class="topbar">
    

    <div class="search-bar">
      <input type="text" placeholder="Search..." />
      <i class="fas fa-search"></i>
    </div>

    <div class="user-info">
      <!-- <img src="images/default-user.png" alt="User Pic" class="profile-pic" /> -->
      <span><?= htmlspecialchars($_SESSION['user_name']) ?></span>
    </div>
  </header>

  <!-- Main Content -->
  <main class="main-content" id="content">
    <h2>DASHBOARD</h2>

    <!-- Stats Cards -->
    <div class="stats-cards">
      <div class="card traffic">
        <h5>TOTAL Reservations</h5>
        <h3>350,897</h3>
        <p class="percent green">3.48% <span>Since last month</span></p>
      </div>
      <div class="card traffic-small">
        <h5>TOTAL TRAFFIC</h5>
        <h3>2,356</h3>
        <p class="percent green">12.18% <span>Since last month</span></p>
      </div>
      <div class="card sales">
        <h5>SALES</h5>
        <h3>924</h3>
        <p class="percent red">5.72% <span>Since last month</span></p>
      </div>
      <div class="card performance">
        <h5>PERFORMANCE</h5>
        <h3>49.65%</h3>
        <p class="percent green">54.8% <span>Since last month</span></p>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-container">

      <div class="chart-card large-chart">
        <div class="chart-header">
          <span class="overview">OVERVIEW</span>
          <h4>Sales value</h4>
          <div class="btn-group">
            <button class="btn active">Month</button>
            <button class="btn">Week</button>
          </div>
        </div>
        <canvas id="lineChart"></canvas>
      </div>

      <div class="chart-card small-chart">
        <div class="chart-header">
          <span class="overview">PERFORMANCE</span>
          <h4>Total orders</h4>
        </div>
        <canvas id="barChart"></canvas>
      </div>

    </div>
  </main>

<script>
  // Line chart
  const ctxLine = document.getElementById('lineChart').getContext('2d');
  const lineChart = new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Sales value',
        data: [0, 20, 10, 30, 15, 40, 20, 60],
        borderColor: 'rgba(102, 115, 255, 1)',
        backgroundColor: 'rgba(102, 115, 255, 0.1)',
        fill: true,
        tension: 0.4,
        borderWidth: 3,
        pointRadius: 0
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true }
      },
      plugins: { legend: { display: false } }
    }
  });

  // Bar chart
  const ctxBar = document.getElementById('barChart').getContext('2d');
  const barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Total Orders',
        data: [25, 20, 30, 22, 17, 29],
        backgroundColor: 'rgba(255, 99, 71, 0.8)',
        borderRadius: 5,
        barPercentage: 0.5
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true, ticks: { stepSize: 10 } }
      },
      plugins: { legend: { display: false } }
    }
  });
</script>

</body>
</html>