<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: login.php");
  exit;
}
require_once 'conexion.php';

$menus = $conn->query("SELECT * FROM menu ORDER BY creado_en DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Menú | Restaurante</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

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

<div class="d-flex justify-content-center my-4">
  <button class="d-flex align-items-center gap-2 px-4 py-2 shadow-sm text-white" 
          style="border-radius: 8px; background-color: #f5a142; border: none;"
          data-bs-toggle="modal" data-bs-target="#modalCrearMenu">
    <i class="fas fa-plus"></i>
    <span style="font-weight: 500;">Añadir menú</span>
  </button>
</div>







<div class="container mt-4">
  <h2 class="mb-4">Listado de Menús</h2>

<table id="tablaMenus" class="table table-striped table-bordered">
    <thead class="table-warning">
      <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Imagen</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($menu = $menus->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($menu['nombre']) ?></td>
          <td><?= htmlspecialchars($menu['descripcion']) ?></td>
          <td>$<?= number_format($menu['precio'], 0, ',', '.') ?></td>
          <td>
            <button class="btn btn-sm btn-outline-primary" onclick="verImagen('img/platos/<?= $menu['imagen'] ?>')">
              <i class="fas fa-eye"></i> Ver imagen
            </button>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>



<!-- Modal para ver imagen -->
<div class="modal fade" id="modalVerImagen" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">Imagen del Menú</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="imagenModal" src="" class="img-fluid rounded" style="max-height: 500px;">
      </div>
    </div>
  </div>
</div>
























<!-- Modal Crear Menú -->
<div class="modal fade" id="modalCrearMenu" tabindex="-1" aria-labelledby="modalCrearMenuLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4">
      <div class="modal-header" style="background-color: #f5a142;">
        <h5 class="modal-title text-white" id="modalCrearMenuLabel">
          <i class="fas fa-plus me-2"></i>Nuevo Menú
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="crear_plato.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nombre del menú</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" name="precio" class="form-control" required>
          </div>
          <div class="mb-3">
  <label class="form-label">Imagen del menú</label><br>
  <button type="button" class="btn btn-outline-primary" id="btnAbrirGaleria">
  <i class="fas fa-image me-1"></i> Seleccionar imagen
</button>

  <input type="hidden" name="imagen" id="imagenSeleccionada">
  <div id="previewImagen" class="mt-3"></div>
</div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Galería de Imágenes -->
<div class="modal fade" id="modalGaleria" tabindex="-1" aria-labelledby="modalGaleriaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="modalGaleriaLabel"><i class="fas fa-images me-2"></i>Galería de Imágenes</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <!-- 🟩 Formulario para subir una nueva imagen -->
        <form id="formSubirImagen" class="mb-3 d-flex align-items-center gap-3" enctype="multipart/form-data">
          <input type="file" name="nueva_imagen" accept="image/*" class="form-control" required>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-upload me-1"></i> Subir imagen
          </button>
        </form>

        <!-- 🟨 Campo de búsqueda para filtrar imágenes -->
        <div class="mb-3">
          <input type="text" id="buscadorImagen" class="form-control" placeholder="🔍 Buscar imagen...">
        </div>

        <!-- 🟦 Contenedor dinámico de imágenes -->
        <div class="row g-3" id="contenedorImagenes">
          <!-- JS cargará las miniaturas aquí -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- jQuery (requerido por DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>




<script>
$(document).ready(function () {
  console.log("Inicializando DataTable...");
  $('#tablaMenus').DataTable({
    pageLength: 100,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    }
  });
});

</script>

<script>
// ✅ Subida de imagen con notificación SweetAlert
document.getElementById('formSubirImagen').addEventListener('submit', async function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  const res = await fetch('subir_imagen.php', {
    method: 'POST',
    body: formData
  });

  const data = await res.json();
  if (data.success) {
    Swal.fire('✅ Imagen subida', 'Tu imagen fue guardada exitosamente.', 'success');
    this.reset();
    cargarImagenes(); // recargar miniaturas
  } else {
    Swal.fire('❌ Error', 'No se pudo subir la imagen.', 'error');
  }
});

// ✅ Función que carga las imágenes en miniatura y les asigna eventos
function cargarImagenes() {
  const contenedor = document.getElementById('contenedorImagenes');
  contenedor.innerHTML = ''; // limpiar contenido anterior

  fetch('listar_imagenes.php')
    .then(res => res.json())
    .then(imagenes => {
      // limpiar evento previo de búsqueda para evitar duplicados
      const buscador = document.getElementById('buscadorImagen');
      const nuevoBuscador = buscador.cloneNode(true);
      buscador.parentNode.replaceChild(nuevoBuscador, buscador);

      // crear miniaturas
      imagenes.forEach(nombre => {
        const div = document.createElement('div');
        div.className = 'col-md-3 img-box';
        div.setAttribute('data-nombre', nombre.toLowerCase()); // para filtro

        div.innerHTML = `
          <div class="position-relative border rounded p-2 text-center">
            <!-- Miniatura clickeable -->
            <img src="img/platos/${nombre}" class="img-thumbnail mb-2 img-selectable" style="cursor:pointer; max-height: 160px;" data-nombre="${nombre}">
            <!-- Botón de eliminar -->
            <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 btnEliminar" data-nombre="${nombre}" title="Eliminar">
              <i class="fas fa-trash-alt"></i>
            </button>
            <!-- Título de la imagen -->
            <div class="small text-muted mt-1 text-truncate" title="${nombre}">${nombre}</div>
          </div>
        `;
        contenedor.appendChild(div);
      });

      // ✅ Selección de imagen
      document.querySelectorAll('.img-selectable').forEach(img => {
        img.addEventListener('click', () => {
          const nombre = img.dataset.nombre;
          document.getElementById('imagenSeleccionada').value = nombre;
          document.getElementById('previewImagen').innerHTML = `
            <img src="img/platos/${nombre}" class="img-fluid rounded mt-2" style="max-height: 200px;">
          `;
          const modal = bootstrap.Modal.getInstance(document.getElementById('modalGaleria'));
          modal.hide(); // cerrar galería al seleccionar
        });
      });

      // ✅ Eliminación con confirmación SweetAlert
      document.querySelectorAll('.btnEliminar').forEach(btn => {
        btn.addEventListener('click', async (e) => {
          e.stopPropagation();
          const nombre = btn.dataset.nombre;

          const confirmacion = await Swal.fire({
            title: '¿Eliminar imagen?',
            text: nombre,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
          });

          if (confirmacion.isConfirmed) {
            const res = await fetch('eliminar_imagen.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ nombre })
            });

            const data = await res.json();
            if (data.success) {
              Swal.fire('✅ Imagen eliminada', '', 'success');
              cargarImagenes(); // recargar galería
            } else {
              Swal.fire('❌ Error', 'No se pudo eliminar la imagen.', 'error');
            }
          }
        });
      });

      // ✅ Filtro en tiempo real (evitar duplicar listeners)
      document.getElementById('buscadorImagen').addEventListener('input', function () {
        const filtro = this.value.toLowerCase();
        document.querySelectorAll('#contenedorImagenes .img-box').forEach(box => {
          box.style.display = box.getAttribute('data-nombre').includes(filtro) ? 'block' : 'none';
        });
      });
    });
}

// ✅ Mostrar galería y cargar imágenes cuando se abre
document.getElementById('btnAbrirGaleria').addEventListener('click', () => {
  const modalGaleria = new bootstrap.Modal(document.getElementById('modalGaleria'), {
    backdrop: 'static',
    focus: true
  });
  modalGaleria.show();
  cargarImagenes(); // 👈 cargar miniaturas al abrir el modal
});

</script>
<script>
function verImagen(ruta) {
  document.getElementById('imagenModal').src = ruta;
  const modal = new bootstrap.Modal(document.getElementById('modalVerImagen'));
  modal.show();
}
</script>

</body>
</html>