<?php
require __DIR__.'/../config.php';
$sid = (int)($_GET['session_id']??0);
$stmt = $pdo->prepare("
  SELECT metal, ROUND(weight_mg * price_php_per_mg, 2) AS value
  FROM metal_contents mc
  JOIN metal_price_history mph
    ON mc.metal = mph.metal
   AND mph.date = (
     SELECT session_date FROM detection_sessions WHERE id = ?
   )
  WHERE mc.session_id = ?
");
$stmt->execute([$sid,$sid]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
