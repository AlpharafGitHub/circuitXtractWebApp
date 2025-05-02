<?php
// fetch_overview.php
require __DIR__ . '/../config.php';

$sql = "
SELECT
  (SELECT count(*)             FROM detection_sessions)                   AS total_sessions,
  (SELECT coalesce(sum(piece_count),0) FROM detected_components)        AS total_pieces,
  round(coalesce((
    SELECT sum(dc.piece_count*(mc.gold_mg+mc.silver_mg+mc.copper_mg))
      FROM detected_components dc
      JOIN metal_contents mc ON dc.class_id=mc.class_id
  ),0)::numeric,2)                                                        AS total_mg,
  round(coalesce((
    SELECT sum(
      dc.piece_count
      *(
        mc.gold_mg   * (SELECT price_php_per_mg FROM metal_price_history WHERE metal='gold'   ORDER BY price_date DESC LIMIT 1)
       +mc.silver_mg * (SELECT price_php_per_mg FROM metal_price_history WHERE metal='silver' ORDER BY price_date DESC LIMIT 1)
       +mc.copper_mg * (SELECT price_php_per_mg FROM metal_price_history WHERE metal='copper' ORDER BY price_date DESC LIMIT 1)
      )
    )
    FROM detected_components dc
    JOIN metal_contents mc ON dc.class_id=mc.class_id
  ),0)::numeric,2)                                                        AS total_value
";
$data = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);
