<?php
// Dashboard/help.php
require __DIR__ . '/../../config/config.php';

// Check if the user is logged in
if (!isset($_COOKIE['user'])) {
    header('Location: /CircuitXtract/public/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Help | CircuitXtract</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="/CircuitXtract/public/assets/css/styles.css"/>
  <style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif;}
    body,html{height:100%;background:#1C1C1E;color:#fff;}
    .container{display:flex;height:100vh;}
    .sidebar{width:240px;background:#1f2937;display:flex;flex-direction:column;padding-top:20px;}
    .sidebar ul{list-style:none;padding:0;margin:0;}
    .sidebar li{margin:8px 0;}
    .sidebar a{display:flex;align-items:center;padding:12px 20px;color:#cbd5e1;text-decoration:none;border-radius:0 8px 8px 0;transition:background .3s,color .3s;}
    .sidebar a:hover,.sidebar a.active{background:#2563eb;color:#fff;}
    .sidebar a i{margin-right:12px;font-size:1.2rem;}
    .main{flex:1;padding:20px;overflow:auto;}
    .header{margin-bottom:20px;}
    .header h1{font-size:1.8rem;}
    .grid{display:grid;grid-template-columns:1fr;gap:20px;}
    .section{background:rgba(255,255,255,0.1);border-radius:8px;padding:20px;}
    a { color:#4EC5F1; text-decoration:none; }
    a:hover { text-decoration:underline; }
  </style>
</head>
<body>
  <div class="container">
    <nav class="sidebar">
      <ul>
        <li><a href="/CircuitXtract/public/dashboard/admin_dashboard.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
        <li><a href="/CircuitXtract/public/dashboard/analytics.php"><i class="fas fa-chart-pie"></i><span>Analytics</span></a></li>
        <li><a href="/CircuitXtract/public/dashboard/settings.php"><i class="fas fa-cog"></i><span>Settings</span></a></li>
        <li><a href="/CircuitXtract/public/dashboard/help.php" class="active"><i class="fas fa-question-circle"></i><span>Help</span></a></li>
        <li><a href="/CircuitXtract/public/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
      </ul>
    </nav>
    <div class="main">
      <div class="header"><h1>Help &amp; FAQ</h1></div>
      <div class="grid">
        <div class="section">
          <h2>Viewing Analytics</h2>
          <p>Go to “Analytics” & choose a facility. Select a session to view detailed metal breakdown.</p>
          <h2>Account Support</h2>
          <p>Email <a href="mailto:support@circuitxtract.ph">support@circuitxtract.ph</a> or call +63-917-123-4567.</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>