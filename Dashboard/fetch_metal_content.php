<?php
// fetch_metal_content.php
require __DIR__ . '/../config.php';

$metals = ['gold','silver','copper'];
$out = ['metals'=>[], 'mg'=>[]];

foreach($metals as $m){
  $col = $m . '_mg';
  $sql = "
    SELECT coalesce(sum(dc.piece_count * mc.{$col}),0)
      FROM detected_components dc
      JOIN metal_contents mc ON dc.class_id=mc.class_id
  ";
  $total = $pdo->query($sql)->fetchColumn();
  $out['metals'][] = ucfirst($m);
  $out['mg'][]     = (float)$total;
}

header('Content-Type: application/json');
echo json_encode($out);
