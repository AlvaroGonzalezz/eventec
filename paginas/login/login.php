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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener y limpiar datos del formulario
    $email = trim($_POST['email']);
    $contrasena = trim($_POST['contrasena']);

    // Preparar la consulta para evitar inyección SQL
    $stmt = $conexion->prepare("SELECT * FROM administrador WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Función para mostrar alerta con SweetAlert2
    function mostrarAlerta($titulo, $mensaje, $tipo, $url_redirigir = null)
    {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '$titulo',
                text: '$mensaje',
                icon: '$tipo',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed || result.dismiss) {";
        if ($url_redirigir) {
            echo "window.location.href = '$url_redirigir';";
        } else {
            echo "window.history.back();";
        }
        echo "}
            });
        });
    </script>";
        exit;
    }


    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificar contraseña (hash guardado en BD)
        if (password_verify($contrasena, $usuario['contraseña'])) {
            // Guardar datos en sesión
            $_SESSION['admin_id'] = $usuario['id_administrador'];
            $_SESSION['admin_email'] = $usuario['email'];

            // Mostrar alerta de éxito y redirigir al dashboard
            mostrarAlerta('¡Bienvenido!', 'Inicio de sesión correcto, se te redireccionará al sistema administrativo', 'success', '../admin/index.php');
        } else {
            // Contraseña incorrecta
            mostrarAlerta('Error', 'Contraseña incorrecta.', 'error');
        }
    } else {
        // Email no registrado
        mostrarAlerta('Error', 'Correo no registrado.', 'error');
    }

    $stmt->close();
    $conexion->close();
}
