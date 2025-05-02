<?php
// fetch_users_tsd.php
require __DIR__ . '/../config/config.php';

$sql = "
    SELECT
        facility_id AS id,
        facility_name AS name
    FROM tsd_facilities
    ORDER BY facility_name
";

$data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);