<?php
// fetch_overview.php
require __DIR__ . '/../config/config.php';

$sql = "
    SELECT
        coalesce(count(*), 0) AS total_sessions,
        coalesce(sum(piece_count), 0) AS total_pieces,
        coalesce(sum(piece_count * (gold_mg + silver_mg + copper_mg)), 0) AS total_mg,
        coalesce(sum(piece_count * (gold_price + silver_price + copper_price)), 0) AS total_value
    FROM detected_components dc
    JOIN metal_contents mc ON dc.class_id = mc.class_id
";
$data = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);