<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: ../admin/index.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../recursos/imgs/icontec.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../recursos/css/style.css">
    <title>Login - EVENTEC</title>
</head>

<body>
    <header>
        <img src="../../recursos/imgs/logo.png" alt="Logo Tec San Pedro">
        <!-- Checkbox oculto -->
        <input type="checkbox" id="menu-toggle">
        <!-- Icono menú como label -->
        <label for="menu-toggle" class="menu-icon">
            <i class="bi bi-list"></i>
        </label>

        <nav class="nav-links">
            <a href="../inicio/index.php"><i class="bi bi-house-door"></i>Inicio</a>
            <a href="../acerca-de/index.html"><i class="bi bi-info-circle"></i>Acerca De</a>
        </nav>
    </header>

    <div class="login">
        <h2>SISTEMA ADMINISTRATIVO</h2>
        <p>Ingresa tus credenciales para acceder al sistema administrativo.</p>
        <form class="form" action="login.php" method="POST">
            <p id="heading">INICIAR SESIÓN</p>

            <div class="field">
                <!-- Icono usuario -->
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    viewBox="0 0 16 16">
                    <!-- ...icono omitido por brevedad... -->
                </svg>
                <input name="email" autocomplete="off" placeholder="Correo Electrónico" class="input-field" type="email"
                    required>
            </div>

            <div class="field">
                <!-- Icono candado -->
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    viewBox="0 0 16 16">
                    <!-- ...icono omitido por brevedad... -->
                </svg>
                <input name="contrasena" placeholder="Contraseña" class="input-field" type="password" required>
            </div>

            <button class="button3" type="submit">Acceder <i class="bi bi-arrow-right"></i></button>
        </form>


        <footer>
            <img src="../../recursos/imgs/logo.png" alt="Logo Tec San Pedro">
            <div class="btn-social">
                <a href="https://www.facebook.com/oficialtecsp" target="_blank"><i
                        class="bi bi-facebook"></i>FACEBOOK</a>
                <a href="https://www.instagram.com/leonestecsanpedro/" target="_blank"><i
                        class="bi bi-instagram"></i>INSTAGRAM</a>
                <a href="https://www.tecsanpedro.edu.mx/" target="_blank"><i class="bi bi-globe2"></i>WEB</a>
            </div>
            <p>Copyright © 2025 Instituto Tecnológico Superior de San Pedro de las Colonias. <br>Todos los derechos
                reservados.</p><br>
        </footer>

    </div>
</body>

</html>