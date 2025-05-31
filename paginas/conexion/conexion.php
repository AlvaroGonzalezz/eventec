<?php 
# Conexión a la base de datos
# host, usuario, contraseña, base de datos
$conexion = mysqli_connect("localhost", "root", "", "eventec");
if (!$conexion) {
    die("Conexión Fallida: " . mysqli_connect_error());
}

