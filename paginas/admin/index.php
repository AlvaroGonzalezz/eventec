<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: ../login/index.php");
  exit();
}
# Incluimos el archivo de conexión a la base de datos
include '../../paginas/conexion/conexion.php';
# Consulta para obtener los eventos
$sql = "SELECT 
            e.id_evento, 
            e.nombre, 
            e.descripcion, 
            e.fecha, 
            e.ubicacion, 
            e.organizador, 
            e.estatus, 
            c.nombre AS categoria
        FROM evento e
        INNER JOIN categoria c ON e.id_categoria = c.id_categoria
        ORDER BY e.fecha ASC";
# Ejecutamos la consulta
$resultado = $conexion->query($sql);


?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="../../recursos/imgs/icontec.png" type="image/x-icon">
  <title>Administración de Eventos</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


  <link rel="stylesheet" href="../../recursos/css/style.css">
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
      <a href="#" id="logout-link"><i class="bi bi-box-arrow-right"></i>Cerrar Sesión</a>

    </nav>
  </header>

  <div class="container-admin">
    <div class="titulo-admin">
      <h2>ADMINISTRACIÓN DE EVENTOS</h2>

    </div>
    <div class="barra-superior">
      <a href="#nuevo" class="btn-nuevo">
        <i class="bi bi-plus"></i> NUEVO EVENTO
      </a>

      <div class="buscador">
        <label for="buscar">Buscar:</label>
        <div class="input-con-icono">
          <i class="bi bi-search"></i>
          <input type="text" id="buscar" class="caja-buscar" placeholder="Evento">
        </div>
      </div>

    </div>

    <div class="contenedor-tabla">
      <table>
        <thead>
          <tr>
            <th>ID EVENTO</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Ubicación</th>
            <th>Organizador</th>
            <th>Estatus</th>
            <th>Categoría</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
              <td><?php echo $fila['id_evento']; ?></td>
              <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
              <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
              <td>
                <?php
                $fecha = date_create($fila['fecha']);
                echo date_format($fecha, 'd/m/Y') . "<br>a las " . date_format($fecha, 'H:i');
                ?>
              </td>
              <td><?php echo htmlspecialchars($fila['ubicacion']); ?></td>
              <td><?php echo htmlspecialchars($fila['organizador']); ?></td>
              <td>
                <?php echo ($fila['estatus'] == 1) ? 'Activo' : 'Inactivo'; ?>
              </td>

              <td><?php echo htmlspecialchars($fila['categoria']); ?></td>
              <td>
                <a href="#" class="btn-accion editar" data-bs-toggle="modal" data-bs-target="#editarEventoModal" data-id="<?= $fila['id_evento'] ?>">
                  <i class="bi bi-pencil-square"></i>
                </a>


                <a href="eliminar_evento.php?id=<?php echo $fila['id_evento']; ?>" class="btn-accion eliminar"><i class="bi bi-trash3-fill"></i></a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <form action="guardar_evento.php" method="POST" enctype="multipart/form-data" class="form-nuevo-evento" id="nuevo">
      <h2 class="titulo-formulario"><i class="bi bi-calendar-event-fill"></i> Nuevo Evento</h2>

      <div class="campo-form">
        <i class="bi bi-type"></i>
        <input type="text" name="nombre" placeholder="Nombre del Evento" required>
      </div>

      <div class="campo-form">
        <i class="bi bi-card-text"></i>
        <input type="text" name="descripcion" placeholder="Descripción" required>
      </div>

      <div class="campo-form">
        <i class="bi bi-calendar-event"></i>
        <input type="datetime-local" name="fecha_hora" required>
      </div>


      <div class="campo-form">
        <i class="bi bi-geo-alt"></i>
        <input type="text" name="ubicacion" placeholder="Ubicación" required>
      </div>

      <div class="campo-form">
        <i class="bi bi-person-badge"></i>
        <input type="text" name="organizador" placeholder="Organizador" required>
      </div>

      <div class="campo-form">
        <i class="bi bi-tags-fill"></i>
        <select name="categoria" required>
          <option disabled selected value="">Categoría</option>
          <option value="1">Académico</option>
          <option value="2">Deportivo</option>
          <option value="3">Social</option>
        </select>
        <i class="bi bi-caret-down-fill icono-derecha"></i>
      </div>

      <div class="campo-form">
        <i class="bi bi-image"></i>
        <input type="file" name="imagen" class="campo-archivo">
      </div>

      <button type="submit" class="btn-registrar">Registrar</button>
    </form>

  </div>
  <!-- Modal para editar evento -->
  <div class="modal fade" id="editarEventoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formEditarEvento" action="actualizar_evento.php" method="POST" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Editar Evento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id_evento" id="edit-id_evento">

            <div class="mb-3"><label>Nombre</label>
              <input type="text" name="nombre" id="edit-nombre" class="form-control" required>
            </div>

            <div class="mb-3"><label>Descripción</label>
              <input type="text" name="descripcion" id="edit-descripcion" class="form-control" required>
            </div>

            <div class="mb-3"><label>Fecha y Hora</label>
              <input type="datetime-local" name="fecha" id="edit-fecha" class="form-control" required>
            </div>

            <div class="mb-3"><label>Ubicación</label>
              <input type="text" name="ubicacion" id="edit-ubicacion" class="form-control" required>
            </div>

            <div class="mb-3"><label>Organizador</label>
              <input type="text" name="organizador" id="edit-organizador" class="form-control" required>
            </div>

            <div class="mb-3"><label>Categoría</label>
              <select name="categoria" id="edit-categoria" class="form-select" required>
                <option value="1">Académico</option>
                <option value="2">Deportivo</option>
                <option value="3">Social</option>
              </select>
            </div>

            <div class="mb-3">
              <label>Imagen actual</label><br>
              <img id="edit-imagen-preview" src="" alt="Imagen actual" class="img-thumbnail mb-2" style="height: 200px; width: 200px; object-fit: cover; ">
            </div>

            <div class="mb-3">
              <label>Cambiar Imagen</label>
              <input type="file" name="imagen" accept="image/*" class="form-control">
            </div>
          </div>

          <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Guardar Cambios</button>
          </div>
        </div>
      </form>
    </div>
  </div>



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
  <!-- Bootstrap 5.3 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.querySelectorAll('.btn-accion.editar').forEach(btn => {
      btn.addEventListener('click', function() {
        const idEvento = this.dataset.id;

        fetch('obtener_evento.php?id=' + idEvento)
          .then(res => res.json())
          .then(data => {
            document.getElementById('edit-id_evento').value = data.id_evento;
            document.getElementById('edit-nombre').value = data.nombre;
            document.getElementById('edit-descripcion').value = data.descripcion;
            document.getElementById('edit-fecha').value = data.fecha;
            document.getElementById('edit-ubicacion').value = data.ubicacion;
            document.getElementById('edit-organizador').value = data.organizador;
            document.getElementById('edit-categoria').value = data.id_categoria;
            document.getElementById('edit-imagen-preview').src = data.imagen;

            new bootstrap.Modal(document.getElementById('modalEditarEvento')).show();
          });
      });
    });
    document.getElementById('logout-link').addEventListener('click', function(event) {
      event.preventDefault(); // Evita que el enlace cargue la página

      Swal.fire({
        title: '¿Deseas cerrar sesión?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // Si confirma, redirige a cerrar_sesion.php
          window.location.href = '../admin/cerrar_sesion.php';
        }
      });
    });
  </script>


</body>

</html>