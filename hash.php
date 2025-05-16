<?php
require_once 'conexion.php';

// ID del usuario que quieres actualizar
$id_usuario = 1;
$nueva_clave = '1234';

// Hashear la contraseña
$clave_hash = password_hash($nueva_clave, PASSWORD_DEFAULT);

// Actualizar en la base de datos
$stmt = $conn->prepare("UPDATE usuario SET clave = ? WHERE id = ?");
$stmt->bind_param("si", $clave_hash, $id_usuario);

if ($stmt->execute()) {
    echo "✅ Contraseña hasheada y actualizada correctamente.";
} else {
    echo "❌ Error al actualizar la contraseña: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
