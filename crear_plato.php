<?php
require_once 'conexion.php'; // asegúrate de tener este archivo con tu conexión a la BD

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir y sanitizar los datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $imagen = trim($_POST['imagen'] ?? '');

    // Validar campos obligatorios
    if ($nombre === '' || $descripcion === '' || $precio <= 0 || $imagen === '') {
        die('❌ Faltan datos obligatorios o el precio no es válido.');
    }

    // Insertar en la tabla `menu`
    $stmt = $conn->prepare("INSERT INTO menu (nombre, descripcion, precio, imagen) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $nombre, $descripcion, $precio, $imagen);

    if ($stmt->execute()) {
        // ✅ Inserción exitosa
        echo '✅ Menú agregado correctamente.';
        // Puedes redirigir si lo usas fuera de un modal:
        // header("Location: menu.php"); exit;
    } else {
        // ❌ Error
        echo '❌ Error al agregar el menú: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo '⚠️ Acceso no permitido.';
}
