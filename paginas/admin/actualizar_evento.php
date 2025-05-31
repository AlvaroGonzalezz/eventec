<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Acceso denegado',
                text: 'Debes iniciar sesión como administrador',
                confirmButtonText: 'Aceptar'
            }).then(() => { window.location.href = '../../login.php'; });
        });
    </script>";
    exit;
}

include '../../paginas/conexion/conexion.php';
echo "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<style>
.swal2-confirm { background:#b30000 !important; }
.swal2-confirm:hover { background:rgb(74, 16, 11) !important; }
</style>
";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Método no permitido',
                confirmButtonText: 'Aceptar'
            }).then(() => { window.location.href = '../../paginas/login/index.html'; });
        });
    </script>";
    exit;
}

// Sanitización y validación
$id_evento    = intval($_POST['id_evento'] ?? 0);
$nombre       = trim($_POST['nombre'] ?? '');
$descripcion  = trim($_POST['descripcion'] ?? '');
$fecha        = $_POST['fecha'] ?? '';
$ubicacion    = trim($_POST['ubicacion'] ?? '');
$organizador  = trim($_POST['organizador'] ?? '');
$id_categoria = intval($_POST['categoria'] ?? 0);

if (
    $id_evento <= 0 || empty($nombre) || empty($descripcion) ||
    empty($fecha) || empty($ubicacion) || empty($organizador) || $id_categoria <= 0
) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Datos inválidos',
                text: 'Completa todos los campos correctamente',
                confirmButtonText: 'Aceptar'
            }).then(() => { window.history.back(); });
        });
    </script>";
    exit;
}

// Manejo de imagen
$imagen_nombre = null;
$subir_imagen = false;
$carpeta_destino = '../../recursos/imgs/eventos/';

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $imagen_tmp = $_FILES['imagen']['tmp_name'];
    $imagen_nombre = basename($_FILES['imagen']['name']);
    $extension = pathinfo($imagen_nombre, PATHINFO_EXTENSION);
    $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array(strtolower($extension), $permitidas)) {
        // Renombrar imagen para evitar colisiones
        $nuevo_nombre = 'evento_' . time() . '.' . $extension;
        $ruta_completa = $carpeta_destino . $nuevo_nombre;

        if (move_uploaded_file($imagen_tmp, $ruta_completa)) {
            $imagen_nombre = $ruta_completa;
            $subir_imagen = true;

            // Eliminar imagen anterior (opcional)
            $sql_old = "SELECT imagen FROM evento WHERE id_evento = ?";
            $stmt_old = $conexion->prepare($sql_old);
            $stmt_old->bind_param("i", $id_evento);
            $stmt_old->execute();
            $stmt_old->bind_result($imagen_anterior);
            if ($stmt_old->fetch() && $imagen_anterior && file_exists($carpeta_destino . $imagen_anterior)) {
                unlink($carpeta_destino . $imagen_anterior);
            }
            $stmt_old->close();
        }
    }
}

// Actualización
if ($subir_imagen) {
    $sql = "UPDATE evento 
            SET nombre = ?, descripcion = ?, fecha = ?, ubicacion = ?, organizador = ?, id_categoria = ?, imagen = ?
            WHERE id_evento = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssssi", $nombre, $descripcion, $fecha, $ubicacion, $organizador, $id_categoria, $imagen_nombre, $id_evento);
} else {
    $sql = "UPDATE evento 
            SET nombre = ?, descripcion = ?, fecha = ?, ubicacion = ?, organizador = ?, id_categoria = ?
            WHERE id_evento = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssssi", $nombre, $descripcion, $fecha, $ubicacion, $organizador, $id_categoria, $id_evento);
}

if ($stmt->execute()) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Actualizado',
                text: 'El evento se actualizó correctamente',
                confirmButtonText: 'Aceptar'
            }).then(() => { window.location.href = 'index.php'; });
        });
    </script>";
} else {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo actualizar el evento',
                confirmButtonText: 'Aceptar'
            }).then(() => { window.history.back(); });
        });
    </script>";
}

$stmt->close();
$conexion->close();
?>
