<?php
// fetch_users_tsd_sessions.php
require __DIR__ . '/../config/config.php';

$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    http_response_code(400);
    echo json_encode(['error' => 'User ID is required']);
    exit;
}

$sql = "
    SELECT
        session_id,
        session_date,
        coalesce(sum(dc.piece_count * (mc.gold_mg + mc.silver_mg + mc.copper_mg)), 0) AS total_mg,
        coalesce(sum(dc.piece_count * (mc.gold_price + mc.silver_price + mc.copper_price)), 0) AS total_price
    FROM detected_components dc
    JOIN metal_contents mc ON dc.class_id = mc.class_id
    WHERE dc.user_id = :user_id
    GROUP BY session_id, session_date
    ORDER BY session_date DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);