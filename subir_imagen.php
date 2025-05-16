<?php
$response = ['success' => false];

if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] === UPLOAD_ERR_OK) {
    $directorio = 'img/platos/';
    $nombreOriginal = pathinfo($_FILES['nueva_imagen']['name'], PATHINFO_FILENAME);
    $ext = strtolower(pathinfo($_FILES['nueva_imagen']['name'], PATHINFO_EXTENSION));
    $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($ext, $extensiones_permitidas)) {
        // Renombrar para evitar conflictos
        $nombreFinal = 'plato_' . date('Ymd_His') . '_' . rand(100, 999) . '.' . $ext;
        $rutaDestino = $directorio . $nombreFinal;

        // Crear imagen desde archivo temporal
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $src = imagecreatefromjpeg($_FILES['nueva_imagen']['tmp_name']);
                break;
            case 'png':
                $src = imagecreatefrompng($_FILES['nueva_imagen']['tmp_name']);
                break;
            case 'webp':
                $src = imagecreatefromwebp($_FILES['nueva_imagen']['tmp_name']);
                break;
            default:
                $src = null;
        }

        if ($src) {
            $anchoOriginal = imagesx($src);
            $altoOriginal = imagesy($src);

            // Redimensionar a máximo 300x300 manteniendo proporción
            $maxLado = 300;
            $escala = min($maxLado / $anchoOriginal, $maxLado / $altoOriginal, 1);
            $nuevoAncho = intval($anchoOriginal * $escala);
            $nuevoAlto = intval($altoOriginal * $escala);

            $dest = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

            // Manejar transparencia para PNG
            if ($ext === 'png') {
                imagealphablending($dest, false);
                imagesavealpha($dest, true);
            }

            imagecopyresampled($dest, $src, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $anchoOriginal, $altoOriginal);

            // Guardar según tipo
            switch ($ext) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($dest, $rutaDestino, 80); // Calidad 80
                    break;
                case 'png':
                    imagepng($dest, $rutaDestino, 6); // Compresión 6
                    break;
                case 'webp':
                    imagewebp($dest, $rutaDestino, 80);
                    break;
            }

            imagedestroy($src);
            imagedestroy($dest);

            $response['success'] = true;
            $response['nombre'] = $nombreFinal;
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
