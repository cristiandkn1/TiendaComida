<?php
require_once 'conexion.php';
$categorias = $conn->query("SELECT id, nombre FROM categoria ORDER BY nombre ASC");
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menús | Restaurante Delicioso</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fff8f0;
    }
    .hero {
      background: url('img/portada-menu.jpg') center/cover no-repeat;
      height: 80vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-shadow: 2px 2px 5px #000;
    }
    .menu-card {
      transition: transform 0.3s;
    }
    .menu-card:hover {
      transform: scale(1.03);
    }
    footer {
      background-color: #2f2f2f;
      color: #fff;
      padding: 20px 0;
    }
  </style>
</head>
<body>

  <!-- Encabezado principal -->
  <header class="hero text-center">
    <div>
      <h1 class="display-4 fw-bold">Restaurante Delicioso</h1>
      <p class="lead">Descubre nuestros menús caseros y sabrosos</p>
      <a href="#menu" class="btn btn-warning mt-3">Ver Menús</a>
    </div>
  </header>


<section class="container my-5">
  <div class="bg-white border rounded-4 shadow-sm p-4">
    <h2 class="mb-3 text-center text-primary-emphasis">Filtrar por Categoría</h2>
    <form method="GET" class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <select name="categoria" class="form-select form-select-lg border-primary-subtle" onchange="this.form.submit()">
          <option value="">🍽️ Ver todos los menús</option>
          <?php while ($cat = $categorias->fetch_assoc()): ?>
            <option value="<?= $cat['id'] ?>" <?= isset($_GET['categoria']) && $_GET['categoria'] == $cat['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['nombre']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
    </form>
  </div>
</section>












  <!-- Contacto y ubicación -->
  <section class="container py-5 text-center">
    <h3 class="mb-3">Haz tu pedido o visítanos</h3>
    <p><i class="fas fa-map-marker-alt me-2"></i>Av. Siempre Viva 123, Santiago</p>
    <p><i class="fas fa-phone me-2"></i>+56 9 1234 5678</p>
    <a href="https://wa.me/56912345678" class="btn btn-success mt-2"><i class="fab fa-whatsapp me-2"></i>Pedir por WhatsApp</a>
  </section>

  <!-- Footer -->
  <footer class="text-center">
    <div>© 2025 Restaurante Delicioso | Todos los derechos reservados</div>
  </footer>

</body>
</html>
