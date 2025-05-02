<?php
// fetch_sessions_metals.php
require __DIR__ . '/../config/config.php';

$session_id = $_GET['session_id'] ?? null;

if (!$session_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Session ID is required']);
    exit;
}

$sql = "
    SELECT
        'Gold' AS metal, coalesce(sum(dc.piece_count * mc.gold_mg), 0) AS value
    FROM detected_components dc
    JOIN metal_contents mc ON dc.class_id = mc.class_id
    WHERE dc.session_id = :session_id
    UNION ALL
    SELECT
        'Silver' AS metal, coalesce(sum(dc.piece_count * mc.silver_mg), 0) AS value
    FROM detected_components dc
    JOIN metal_contents mc ON dc.class_id = mc.class_id
    WHERE dc.session_id = :session_id
    UNION ALL
    SELECT
        'Copper' AS metal, coalesce(sum(dc.piece_count * mc.copper_mg), 0) AS value
    FROM detected_components dc
    JOIN metal_contents mc ON dc.class_id = mc.class_id
    WHERE dc.session_id = :session_id
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['session_id' => $session_id]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);