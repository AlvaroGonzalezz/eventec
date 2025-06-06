<?php
session_start();
include '../../paginas/conexion/conexion.php';

echo "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<style>
.swal2-confirm { background:#b30000 !important; }
.swal2-confirm:hover { background:rgb(74, 16, 11) !important; }
</style>
";

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre       = trim($_POST['nombre'] ?? '');
    $descripcion  = trim($_POST['descripcion'] ?? '');
    $fecha        = $_POST['fecha_hora'] ?? '';
    $ubicacion    = trim($_POST['ubicacion'] ?? '');
    $organizador  = trim($_POST['organizador'] ?? '');
    $id_categoria = intval($_POST['categoria'] ?? 0);
    $id_admin     = $_SESSION['admin_id'];
    $estatus      = 1;
    $fecha_creacion = date('Y-m-d H:i:s');

    // Validar campos obligatorios
    if (empty($nombre) || empty($descripcion) || empty($fecha) || empty($ubicacion) || empty($organizador) || $id_categoria <= 0) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Faltan datos obligatorios',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    history.back();
                });
            });
        </script>";
        exit;
    }

    // Manejo de la imagen
    $ruta_imagen = '';
    if (!empty($_FILES['imagen']['name'])) {
        $directorio = '../../recursos/imgs/eventos/';
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombreArchivo = uniqid() . '_' . basename($_FILES['imagen']['name']);
        $rutaCompleta = $directorio . $nombreArchivo;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaCompleta)) {
            $ruta_imagen = '../../recursos/imgs/eventos/' . $nombreArchivo;
        }
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO evento (nombre, descripcion, fecha, fecha_creacion, ubicacion, organizador, imagen, estatus, id_categoria, id_administrador) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("ssssssssii", $nombre, $descripcion, $fecha, $fecha_creacion, $ubicacion, $organizador, $ruta_imagen, $estatus, $id_categoria, $id_admin);

        if ($stmt->execute()) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Evento registrado correctamente',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                });
            </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al guardar el evento: " . addslashes($stmt->error) . "',
                        confirmButtonText: 'Aceptar'
                    });
                });
            </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la consulta: " . addslashes($conexion->error) . "',
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>";
    }
} else {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Método no permitido',
                confirmButtonText: 'Aceptar'
            });
        });
    </script>";
}
