<?php
require __DIR__.'/../config.php';
$uid = (int)($_GET['user_id']??0);
$stmt = $pdo->prepare("
  SELECT id AS session_id, session_date,
         ROUND(total_metals, 2) AS total_metals,
         ROUND(total_price, 2)  AS total_price
  FROM detection_sessions
  WHERE user_id = ?
  ORDER BY session_date DESC
");
$stmt->execute([$uid]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
