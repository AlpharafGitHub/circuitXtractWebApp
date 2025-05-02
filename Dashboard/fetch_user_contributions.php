<?php
// fetch_user_contributions.php
require __DIR__ . '/../config.php';

$sql = "
SELECT
  u.facility_name AS facility,
  round(
    sum(
      dc.piece_count
      *(
        mc.gold_mg   * (SELECT price_php_per_mg FROM metal_price_history WHERE metal='gold'   ORDER BY price_date DESC LIMIT 1)
       +mc.silver_mg * (SELECT price_php_per_mg FROM metal_price_history WHERE metal='silver' ORDER BY price_date DESC LIMIT 1)
       +mc.copper_mg * (SELECT price_php_per_mg FROM metal_price_history WHERE metal='copper' ORDER BY price_date DESC LIMIT 1)
      )
    )::numeric,2
  ) AS total_value
FROM users u
JOIN detection_sessions s    ON s.user_id   = u.id
JOIN detected_components dc  ON dc.session_id= s.session_id
JOIN metal_contents mc       ON mc.class_id  = dc.class_id
GROUP BY u.facility_name
ORDER BY total_value DESC
";
$data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);
