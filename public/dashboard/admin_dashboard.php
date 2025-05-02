<?php
// admin_dashboard.php
require __DIR__ . '/../../config/config.php';

// Check if the user is logged in
if (!isset($_COOKIE['user'])) {
    header('Location: /login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Admin Dashboard | CircuitXtract</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="/assets/css/styles.css"/>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:Arial,sans-serif; }
    body,html{height:100%; background:#1C1C1E; color:#fff;}
    .container{display:flex; height:100vh;}
    /* Sidebar */
    .sidebar {
      width: 240px;
      background: #1f2937;
      display: flex;
      flex-direction: column;
      padding-top: 20px;
    }
    .sidebar ul { list-style: none; padding: 0; margin: 0; }
    .sidebar li { margin: 8px 0; }
    .sidebar a {
      display: flex;
      align-items: center;
      padding: 12px 20px;
      color: #cbd5e1;
      text-decoration: none;
      border-radius: 0 8px 8px 0;
      transition: background 0.3s, color 0.3s;
    }
    .sidebar a:hover,
    .sidebar a.active {
      background: #2563eb;
      color: #fff;
    }
    .sidebar a i {
      margin-right: 12px;
      font-size: 1.2rem;
    }
    /* Main */
    .main{flex:1; padding:20px; overflow:auto;}
    .header{margin-bottom:20px;}
    .header h1{font-size:1.8rem;}
    .grid{display:grid; grid-template-columns:1fr 1fr; grid-auto-rows:minmax(200px,auto); gap:20px;}
    .card, .section{background:rgba(255,255,255,0.1); border-radius:8px; padding:20px;}
    canvas{width:100% !important; height:200px !important;}
  </style>
</head>
<body>
  <div class="container">
    <nav class="sidebar">
      <ul>
        <li><a href="/CircuitXtract/public/dashboard/admin_dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
        <li><a href="/CircuitXtract/public/dashboard/analytics.php"><i class="fas fa-chart-pie"></i><span>Analytics</span></a></li>
        <li><a href="/CircuitXtract/public/dashboard/settings.php"><i class="fas fa-cog"></i><span>Settings</span></a></li>
        <li><a href="/CircuitXtract/public/dashboard/help.php"><i class="fas fa-question-circle"></i><span>Help</span></a></li>
        <li><a href="/CircuitXtract/public/dashboard/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
      </ul>
    </nav>
    <div class="main">
      <div class="header">
        <h1>Admin Dashboard</h1>
      </div>
      <div class="grid">
        <!-- 1) Power BI Dashboard -->
        <div class="section" id="powerbi-dashboard">
          <h2>Power BI Dashboard</h2>
          <iframe 
            src="https://app.powerbi.com/view?r=YOUR_EMBED_URL" 
            width="100%" 
            height="500px" 
            frameborder="0" 
            allowFullScreen="true">
          </iframe>
        </div>

        <!-- 2) Metal Content -->
        <div class="section">
          <h2>Overall Metal Content Accumulation</h2>
          <canvas id="metal-chart"></canvas>
        </div>

        <!-- 3) Price Accumulation -->
        <div class="section">
          <h2>Overall Estimated Price Accumulation</h2>
          <canvas id="price-chart"></canvas>
        </div>

        <!-- 4) User Contributions -->
        <div class="section">
          <h2>Most Users Contribution based on Price</h2>
          <canvas id="users-chart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery + Chart.js -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    $(function(){
      // 1) OVERVIEW
      $.getJSON('/app/Controllers/fetch_overview.php', data => {
        $('#total-sessions').text(data.total_sessions);
        $('#total-pieces').text(data.total_pieces);
        $('#total-mg').text(data.total_mg);
        $('#total-value').text('₱' + data.total_value);
      });

      // 2) METAL CONTENT (mg per metal)
      $.getJSON('/app/Controllers/fetch_metal_content.php', res => {
        new Chart($('#metal-chart')[0].getContext('2d'), {
          type: 'bar',
          data: {
            labels: res.metals,
            datasets: [{
              label: 'Total mg',
              data: res.mg,
              backgroundColor: ['#f1c40f','#bdc3c7','#3498db']
            }]
          },
          options:{scales:{y:{beginAtZero:true}}}
        });
      });

      // 3) PRICE ACCUMULATION (₱ per metal)
      $.getJSON('/app/Controllers/fetch_price_accumulation.php', res => {
        new Chart($('#price-chart')[0].getContext('2d'), {
          type: 'bar',
          data: {
            labels: res.metals,
            datasets: [{
              label: '₱ Total',
              data: res.prices,
              backgroundColor: ['#e74c3c','#2ecc71','#e67e22']
            }]
          },
          options:{scales:{y:{beginAtZero:true}}}
        });
      });

      // 4) USER CONTRIBUTIONS
      $.getJSON('/app/Controllers/fetch_user_contributions.php', items => {
        const labs = items.map(i=>i.facility);
        const vals = items.map(i=>i.total_value);
        new Chart($('#users-chart')[0].getContext('2d'), {
          type: 'bar',
          data: {
            labels: labs,
            datasets: [{
              label: '₱ Contribution',
              data: vals,
              backgroundColor: '#9b59b6'
            }]
          },
          options:{scales:{y:{beginAtZero:true}}}
        });
      });
    });
  </script>
</body>
</html>