<?php
session_start();
require_once 'conexion.php';

if (isset($_SESSION['usuario_id'])) {
    header("Location: menu.php");
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $clave = $_POST['clave'] ?? '';

    $stmt = $conn->prepare("SELECT id, clave FROM usuario WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $row = $resultado->fetch_assoc();
        if (password_verify($clave, $row['clave'])) {
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario'] = $usuario;
            header("Location: admin.php");
            exit;
        }
    }

    $error = "Usuario o contraseña incorrectos.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login | Restaurante</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      min-height: 100vh;
      background: linear-gradient(-45deg,rgb(250, 213, 26),rgb(226, 231, 179),rgb(255, 242, 121), #fff4cc);
      background-size: 400% 400%;
      animation: gradientBG 10s ease infinite;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .login-card {
      background-color:rgb(243, 227, 212); /* color piel */
      border: 4px solid #ffa14a; /* borde naranja */
      border-radius: 40px;
      padding: 40px 30px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      max-width: 420px;
      width: 100%;
      animation: fadeIn 1s ease-in;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-card img {
      width: 90px;
      margin-bottom: 20px;
      border-radius: 50%;
      border: 3px solid #ffa14a;
    }

    .form-control {
      border-radius: 10px;
      border-color: #f5b27f;
    }

    .btn-login {
      background-color: #f5a142;
      border: none;
      color: white;
      border-radius: 12px;
      transition: background-color 0.3s;
    }

    .btn-login:hover {
      background-color: #e6932a;
    }

    .alert {
      border-radius: 10px;
    }

    h3 {
      color: #c45b00;
    }
  </style>
</head>
<body>
  <div class="login-card text-center">
    <img src="img/logo.png" alt="Logo">
    <h3 class="mb-4">Menú de acceso</h3>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="mb-3 text-start">
        <label class="form-label">Usuario</label>
        <input type="text" name="usuario" class="form-control" required>
      </div>
      <div class="mb-4 text-start">
        <label class="form-label">Contraseña</label>
        <input type="password" name="clave" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-login w-100">Entrar al sistema</button>
    </form>
  </div>
</body>
</html>