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
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'ID inválido',
                text: 'No se pudo eliminar el evento',
                confirmButtonText: 'Aceptar'
            }).then(() => { window.location.href = 'index.php'; });
        });
    </script>";
    exit;
}

// Eliminar evento
$sql = "DELETE FROM evento WHERE id_evento = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Eliminado',
                text: 'Evento eliminado correctamente',
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
                text: 'No se pudo eliminar el evento',
                confirmButtonText: 'Aceptar'
            }).then(() => { window.location.href = 'index.php'; });
        });
    </script>";
}
?>
