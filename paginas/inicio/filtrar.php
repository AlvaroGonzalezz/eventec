<?php
include '../conexion/conexion.php';
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Tomar parámetros y limpiar
$categoria = isset($_GET['categoria']) && $_GET['categoria'] !== '' ? intval($_GET['categoria']) : null;
$mes = isset($_GET['mes']) && $_GET['mes'] !== '' ? intval($_GET['mes']) : null;
$buscar = isset($_GET['buscar']) && trim($_GET['buscar']) !== '' ? $conexion->real_escape_string(trim($_GET['buscar'])) : null;

$sql = "SELECT * FROM evento WHERE 1=1";

if ($categoria !== null) {
  $sql .= " AND id_categoria = $categoria";
}
if ($mes !== null) {
  $sql .= " AND MONTH(fecha) = $mes";
}
if ($buscar !== null) {
  $sql .= " AND nombre LIKE '%$buscar%'";
}

$sql .= " ORDER BY fecha ASC";

$resultado = $conexion->query($sql);

$categorias = [1 => "Académico", 2 => "Deportivo", 3 => "Social"];

if ($resultado && $resultado->num_rows > 0) {
  while ($evento = $resultado->fetch_assoc()) {
    $fechaFormateada = date("d.m.Y", strtotime($evento['fecha']));
    $horaFormateada = date("h:i A", strtotime($evento['fecha']));
    $categoriaNombre = $categorias[$evento['id_categoria']] ?? "Sin categoría";

    echo '<div class="ag-courses_item">
      <a href="#info-evento" class="ag-courses-item_link"
        data-nombre="' . htmlspecialchars($evento['nombre']) . '"
        data-fecha="' . $fechaFormateada . '"
        data-hora="' . $horaFormateada . '"
        data-ubicacion="' . htmlspecialchars($evento['ubicacion']) . '"
        data-organizador="' . htmlspecialchars($evento['organizador']) . '"
        data-categoria="' . $categoriaNombre . '"
        data-imagen="' . htmlspecialchars($evento['imagen']) . '">
        <div class="ag-courses-item_bg"></div>
        <div class="ag-courses-item_title">' . htmlspecialchars($evento['nombre']) . '</div>
        <div class="ag-courses-item_date-box">Fecha: <span class="ag-courses-item_date">' . $fechaFormateada . '</span></div>
      </a>
    </div>';
  }
} else {
  echo '<p style="color: #fff; text-align:center; font-family: JetBrains Mono;">No hay eventos registrados.</p>';
}
?>
