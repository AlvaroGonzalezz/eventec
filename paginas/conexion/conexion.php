<?php 

$conexion = mysqli_connect("localhost", "root", "", "eventec");
if (!$conexion) {
    die("Conexión Fallida: " . mysqli_connect_error());
}

