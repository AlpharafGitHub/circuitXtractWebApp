<?php
// Dashboard/analytics.php
require __DIR__ . '/../config.php';
if (!isset($_COOKIE['user'])) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Analytics | CircuitXtract</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
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
    select, table { width:100%; margin-top:10px; }
    select { padding:8px; border-radius:5px; border:none; background:#2C2C2E; color:#fff; }
    table{border-collapse:collapse;}
    th,td{padding:8px;border-bottom:1px solid #444;text-align:left;}
    th{background:#222;color:#fff;}
  </style>
</head>
<body>
  <div class="container">
    <nav class="sidebar">
      <ul>
        <li><a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
        <li><a href="analytics.php" class="active"><i class="fas fa-chart-pie"></i><span>Analytics</span></a></li>
        <li><a href="settings.php"><i class="fas fa-cog"></i><span>Settings</span></a></li>
        <li><a href="help.php"><i class="fas fa-question-circle"></i><span>Help</span></a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
      </ul>
    </nav>
    <div class="main">
      <div class="header"><h1>Analytics</h1></div>
      <div class="grid">

        <!-- Facility selector -->
        <div class="section">
          <h2>Select Facility</h2>
          <select id="facilitySelect">
            <option value="" disabled selected>-- choose facility --</option>
          </select>
        </div>

        <!-- Sessions table -->
        <div class="section">
          <h2>Sessions for <span id="facilityName">—</span></h2>
          <table id="sessionsTable">
            <thead>
              <tr><th>Session ID</th><th>Date</th><th>Total mg</th><th>₱ Value</th></tr>
            </thead>
            <tbody>
              <tr><td colspan="4">Please select a facility above</td></tr>
            </tbody>
          </table>
        </div>

        <!-- Pie chart -->
        <div class="section">
          <h2>Metal Breakdown</h2>
          <select id="sessionSelect" disabled>
            <option value="" disabled selected>-- select session --</option>
          </select>
          <canvas id="metalPie" style="margin-top:20px;"></canvas>
        </div>

      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
  $(function(){
    let pieChart = null;

    // 1) Load facilities
    $.getJSON('fetch_users.php', users => {
      users.forEach(u => {
        $('#facilitySelect').append(
          `<option value="${u.id}">${u.name}</option>`
        );
      });
    });

    // 2) When facility changes
    $('#facilitySelect').on('change', function(){
      const uid = this.value;
      const fname = $("#facilitySelect option:selected").text();
      $('#facilityName').text(fname);
      $('#sessionSelect').prop('disabled', true)
                         .html('<option value="" disabled selected>-- loading sessions --</option>');
      // Fetch sessions
      $.getJSON('fetch_user_sessions.php',{ user_id: uid }, sessions => {
        let rows = '', opts = '<option value="" disabled selected>-- select session --</option>';
        sessions.forEach(s=>{
          rows += `<tr>
            <td>${s.session_id}</td>
            <td>${s.session_date}</td>
            <td>${parseFloat(s.total_mg).toFixed(2)}</td>
            <td>₱${parseFloat(s.total_price).toFixed(2)}</td>
          </tr>`;
          opts  += `<option value="${s.session_id}">${s.session_date}</option>`;
        });
        if(!sessions.length){
          rows = '<tr><td colspan="4">No sessions found</td></tr>';
          opts  = '<option value="" disabled selected>-- no sessions --</option>';
        }
        $('#sessionsTable tbody').html(rows);
        $('#sessionSelect').html(opts).prop('disabled', !sessions.length);
        // destroy old chart
        if(pieChart) pieChart.destroy();
      });
    });

    // 3) When session changes → draw pie
    $('#sessionSelect').on('change', function(){
      const sid = this.value;
      if(!sid) return;
      $.getJSON('fetch_session_metals.php',{ session_id: sid }, metals => {
        const labels = metals.map(m => m.metal);
        const data   = metals.map(m => parseFloat(m.value));
        if(pieChart) pieChart.destroy();
        pieChart = new Chart($('#metalPie')[0].getContext('2d'), {
          type: 'pie',
          data: {
            labels,
            datasets: [{ data, backgroundColor: [
              '#f1c40f','#bdc3c7','#3498db','#e74c3c','#2ecc71','#9b59b6'
            ] }]
          },
          options: {
            plugins: { legend: { position: 'right', labels:{color:'#fff'} } }
          }
        });
      });
    });
  });
  </script>
</body>
</html>
