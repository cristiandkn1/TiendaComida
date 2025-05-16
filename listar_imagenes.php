<?php
$imagenes = [];
$dir = 'img/platos/';
foreach (scandir($dir) as $archivo) {
  if (in_array(strtolower(pathinfo($archivo, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
    $imagenes[] = $archivo;
  }
}
header('Content-Type: application/json');
echo json_encode($imagenes);
