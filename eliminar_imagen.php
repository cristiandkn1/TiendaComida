<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$nombre = $data['nombre'] ?? '';

$ruta = 'img/platos/' . basename($nombre);

if (file_exists($ruta)) {
    if (unlink($ruta)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se pudo eliminar.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Archivo no encontrado.']);
}
