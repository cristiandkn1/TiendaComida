<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pedido | Restaurante</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .navbar-custom {
      background-color: #f5a142;
    }
    .nav-link {
      color: white !important;
      font-weight: 500;
    }
    .nav-link:hover {
      color: #ffe7c3 !important;
    }
  </style>
</head>

<body>

  <?php include 'navbar.php'; ?>

  <div class="container mt-5">
    <h1 class="text-center">Bienvenido al panel de Menús</h1>
    <!-- Aquí continúa el contenido -->
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
