<?php
session_start();

// Si no hay sesión de administrador, redirige o devuelve error
if (!isset($_SESSION['admin_id'])) {
    http_response_code(403); // Acceso prohibido
    echo json_encode(['error' => 'Acceso no autorizado']);
    exit;
}

include '../../paginas/conexion/conexion.php';

// Sanear el ID recibido
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    http_response_code(400); // Solicitud incorrecta
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

$sql = "SELECT * FROM evento WHERE id_evento = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($fila = $result->fetch_assoc()) {
    echo json_encode($fila);
} else {
    echo json_encode([]);
}
?>
