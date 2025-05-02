<?php
// fetch_user_contributions.php
require __DIR__ . '/../config/config.php';

$sql = "
    SELECT
        tsd.facility_name AS facility,
        coalesce(sum(dc.piece_count * (mc.gold_price + mc.silver_price + mc.copper_price)), 0) AS total_value
    FROM detected_components dc
    JOIN metal_contents mc ON dc.class_id = mc.class_id
    JOIN tsd_facilities tsd ON dc.facility_id = tsd.facility_id
    GROUP BY tsd.facility_name
    ORDER BY total_value DESC
    LIMIT 10
";

$data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);