<?php
session_start();

echo "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<style>
.swal2-confirm { background:#b30000 !important; }
.swal2-confirm:hover { background:rgb(74, 16, 11) !important; }
</style>
";

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

// Si no se ha confirmado aún, mostrar confirmación
if (!isset($_GET['confirmado'])) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción eliminará el evento de forma permanente',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#b30000',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'eliminar_evento.php?id=$id&confirmado=1';
                } else {
                    window.location.href = 'index.php';
                }
            });
        });
    </script>";
    exit;
}

// Si se confirmó, proceder a eliminar
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
