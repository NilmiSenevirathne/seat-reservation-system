<?php
session_start();

// Dummy session for demo
$_SESSION['name'] = $_SESSION['name'] ?? 'Ama Senevirathne';
$_SESSION['role'] = $_SESSION['role'] ?? 'admin'; // or 'intern'

$userName = $_SESSION['name'];
$userRole = $_SESSION['role'];
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

<?php include 'sidebar.php'; ?>
<?php include 'header.php'; ?>


<main class="main-content" id="content">

  <?php if ($userRole === 'admin'): ?>
    <!-- ADMIN DASHBOARD -->
    <div class="stats-cards">
      <div class="card traffic">
        <h5>TOTAL Reservations</h5>
        <h3>350</h3>
        <p class="percent green">+3.48% <span>Since last month</span></p>
      </div>
      <div class="card traffic-small">
        <h5>TOTAL USERS</h5>
        <h3>120</h3>
        <p class="percent green">+5% <span>Since last month</span></p>
      </div>
      <div class="card sales">
        <h5>SEATS</h5>
        <h3>50</h3>
        <p class="percent red">0% <span>Since last month</span></p>
      </div>
      <div class="card performance">
        <h5>PERFORMANCE</h5>
        <h3>89%</h3>
        <p class="percent green">+8% <span>Since last month</span></p>
      </div>
    </div>

    <div class="charts-container">
      <div class="chart-card large-chart">
        <div class="chart-header">
          <span class="overview">OVERVIEW</span>
          <h4>Sales value</h4>
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

  <?php elseif ($userRole === 'intern'): ?>
    <!-- INTERN DASHBOARD -->
    <div class="stats-cards">
      <div class="card traffic">
        <h5>My Reservations</h5>
        <h3>5</h3>
        <p class="percent green">+1 <span>Upcoming</span></p>
      </div>
      <div class="card traffic-small">
        <h5>Upcoming Reservation</h5>
        <h3>2</h3>
        <p class="percent green">+1 <span>This week</span></p>
      </div>
      <div class="card sales">
        <h5>Seats Available</h5>
        <h3>10</h3>
        <p class="percent green">Check availability</p>
      </div>
      <div class="card performance">
        <h5>Profile Status</h5>
        <h3>Active</h3>
      </div>
    </div>

    <!-- Optional: Intern-specific charts -->
    <div class="charts-container">
      <div class="chart-card small-chart">
        <div class="chart-header">
          <span class="overview">My Reservations</span>
          <h4>Last 6 Months</h4>
        </div>
        <canvas id="lineChart"></canvas>
      </div>
    </div>

  <?php else: ?>
    <!-- GUEST DASHBOARD -->
    <p>Unauthorized. Please login.</p>
  <?php endif; ?>
</main>

<script>
<?php if ($userRole === 'admin'): ?>
  // Admin charts
  const ctxLine = document.getElementById('lineChart').getContext('2d');
  const lineChart = new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
      datasets: [{
        label: 'Sales',
        data: [20, 40, 30, 50, 40, 60],
        borderColor: 'rgba(102, 115, 255, 1)',
        backgroundColor: 'rgba(102, 115, 255, 0.1)',
        fill: true,
        tension: 0.4
      }]
    }
  });

  const ctxBar = document.getElementById('barChart').getContext('2d');
  const barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
      datasets: [{
        label: 'Orders',
        data: [20, 30, 25, 35, 40],
        backgroundColor: 'rgba(255, 99, 71, 0.8)',
        borderRadius: 5
      }]
    }
  });
<?php elseif ($userRole === 'intern'): ?>
  // Intern chart
  const ctxLine = document.getElementById('lineChart').getContext('2d');
  const lineChart = new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
      datasets: [{
        label: 'My Reservations',
        data: [1, 2, 2, 3, 5, 4],
        borderColor: 'rgba(54, 162, 235, 1)',
        backgroundColor: 'rgba(54, 162, 235, 0.1)',
        fill: true,
        tension: 0.4
      }]
    }
  });
<?php endif; ?>
</script>

</body>
</html>
