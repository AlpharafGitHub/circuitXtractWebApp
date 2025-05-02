<?php
// fetch_price_accumulation.php
require __DIR__ . '/../config.php';

$metals = ['gold','silver','copper'];
$out = ['metals'=>[], 'prices'=>[]];

foreach($metals as $m){
  // latest price
  $price = $pdo
    ->query("SELECT price_php_per_mg FROM metal_price_history WHERE metal='$m' ORDER BY price_date DESC LIMIT 1")
    ->fetchColumn();

  // total value for that metal
  $stmt = $pdo->prepare("
    SELECT coalesce(sum(dc.piece_count * mc.{$m}_mg * :price),0)
      FROM detected_components dc
      JOIN metal_contents mc ON dc.class_id=mc.class_id
  ");
  $stmt->execute(['price'=>$price]);
  $total = $stmt->fetchColumn();

  $out['metals'][]  = ucfirst($m);
  $out['prices'][]  = round((float)$total,2);
}

header('Content-Type: application/json');
echo json_encode($out);
