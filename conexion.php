<?php
// Datos de conexión
$host = "localhost";
$usuario = "root";       // Cambia si usas otro usuario
$clave = "";             // Cambia si tu usuario tiene contraseña
$base_de_datos = "TiendaComida";

// Crear conexión
$conn = new mysqli($host, $usuario, $clave, $base_de_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Error al conectar con la base de datos: " . $conn->connect_error);
}

// Opcional: establecer charset
$conn->set_charset("utf8");
?>
