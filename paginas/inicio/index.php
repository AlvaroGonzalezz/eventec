<?php
include '../../paginas/conexion/conexion.php';

$sql = "SELECT id_evento, nombre, fecha, ubicacion, organizador, id_categoria, imagen FROM evento";
$resultado = $conexion->query($sql);

date_default_timezone_set('America/Mexico_City');
$anioActual = date("Y");
$mesActual = 6;

// Traemos eventos del mes actual
$sql2 = "SELECT fecha, nombre FROM evento WHERE YEAR(fecha) = $anioActual AND MONTH(fecha) = $mesActual ORDER BY fecha";
$resultado2 = $conexion->query($sql2);

$eventosPorDia = [];

if ($resultado2 && $resultado2->num_rows > 0) {
  while ($evento = $resultado2->fetch_assoc()) {
    $fechaEvento = strtotime($evento['fecha']);
    $diaEvento = intval(date('d', $fechaEvento));
    $mesEvento = intval(date('m', $fechaEvento));
    $anioEvento = intval(date('Y', $fechaEvento));

    if ($mesEvento == $mesActual && $anioEvento == $anioActual) {
      // Guarda los eventos en un array asociativo por día
      $eventosPorDia[$diaEvento][] = $evento['nombre'];
    }
  }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../../recursos/imgs/icontec.png" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="../../recursos/css/style.css" />

  <title>EVENTEC</title>
</head>

<body>
  <div class="img-fondo">
    <video autoplay muted loop playsinline class="video-fondo">
      <source src="../../recursos/videos/video-fondo.mp4" type="video/mp4">
      Tu navegador no soporta video HTML5.
    </video>
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
        <a href="../login/index.php"><i class="bi bi-person-fill"></i></i>Iniciar Sesión</a>
      </nav>
    </header>

    <div class="inicio">
      <h1>EVENTEC</h1>
      <hr />
      <h4>ENCUENTRA LOS PRÓXIMOS EVENTOS DEL INSTITUTO</h4>
      <a class="btn1" href="#eventos">EVENTOS</a>
    </div>
  </div>

  <div class="inicio-2">
    <!-- Sección de tarjetas -->
    <div class="tarjetas-categoria">
      <h2>CATEGORÍAS</h2>
      <p>Se presentan las categorías de los eventos del Instituto</p>
      <div class="card-container">
        <div class="card">
          <div class="blob"></div>
          <div class="bg" style="background-image: url(../../recursos/imgs/academicos.png);"></div>
          <div class="card-text">ACADEMICOS</div>
        </div>

        <div class="card">
          <div class="blob"></div>
          <div class="bg" style="background-image: url(../../recursos/imgs/culturales.png);"></div>
          <div class="card-text">CULTURALES</div>
        </div>

        <div class="card">
          <div class="blob"></div>
          <div class="bg" style="background-image: url('../../recursos/imgs/deportivos.png');"></div>
          <div class="card-text">DEPORTIVOS</div>
        </div>
      </div>
    </div>

    <div class="linea">
      <hr />
      <img src="../../recursos/imgs/icontec.png" />
      <hr />
    </div>

    <!-- Slider lineal agregado aquí -->
    <div class="slider-container">
      <div class="slider-track">
        <!-- Se duplican más palabras para que el efecto sea fluido y sin interrupciones -->
        <span class="slider-text">EVENTEC</span>
        <span class="slider-text">TEC SAN PEDRO</span>
        <span class="slider-text">EVENTEC</span>
        <span class="slider-text">TEC SAN PEDRO</span>
        <span class="slider-text">EVENTEC</span>
        <span class="slider-text">TEC SAN PEDRO</span>
        <span class="slider-text">EVENTEC</span>
        <span class="slider-text">TEC SAN PEDRO</span>
        <span class="slider-text">EVENTEC</span>

      </div>
    </div>
    <div class="carrusel">
      <div class="slider-track-img">
        <img src="../../recursos/imgs/imagen1.jpg" alt="Imagen 1" class="slider-img">
        <img src="../../recursos/imgs/imagen2.jpg" alt="Imagen 2" class="slider-img">
        <img src="../../recursos/imgs/imagen3.jpg" alt="Imagen 3" class="slider-img">
        <img src="../../recursos/imgs/Imagen4.jpg" alt="Imagen 4" class="slider-img">
        <img src="../../recursos/imgs/Imagen5.jpg" alt="Imagen 5" class="slider-img">
        <img src="../../recursos/imgs/Imagen6.jpg" alt="Imagen 6" class="slider-img">
        <img src="../../recursos/imgs/Imagen7.jpg" alt="Imagen 7" class="slider-img">
        <img src="../../recursos/imgs/Imagen8.jpg" alt="Imagen 8" class="slider-img">
        <img src="../../recursos/imgs/Imagen9.jpg" alt="Imagen 9" class="slider-img">
        <img src="../../recursos/imgs/Imagen10.jpg" alt="Imagen 10" class="slider-img">
        <img src="../../recursos/imgs/imagen1.jpg" alt="Imagen 1" class="slider-img">
        <img src="../../recursos/imgs/imagen2.jpg" alt="Imagen 2" class="slider-img">
        <img src="../../recursos/imgs/imagen3.jpg" alt="Imagen 3" class="slider-img">
        <img src="../../recursos/imgs/Imagen4.jpg" alt="Imagen 4" class="slider-img">
        <img src="../../recursos/imgs/Imagen5.jpg" alt="Imagen 5" class="slider-img">
        <img src="../../recursos/imgs/Imagen6.jpg" alt="Imagen 6" class="slider-img">
        <img src="../../recursos/imgs/Imagen7.jpg" alt="Imagen 7" class="slider-img">
        <img src="../../recursos/imgs/Imagen8.jpg" alt="Imagen 8" class="slider-img">
        <img src="../../recursos/imgs/Imagen9.jpg" alt="Imagen 9" class="slider-img">
        <img src="../../recursos/imgs/Imagen10.jpg" alt="Imagen 10" class="slider-img">
        <img src="../../recursos/imgs/imagen1.jpg" alt="Imagen 1" class="slider-img">
        <img src="../../recursos/imgs/imagen2.jpg" alt="Imagen 2" class="slider-img">
        <img src="../../recursos/imgs/imagen3.jpg" alt="Imagen 3" class="slider-img">
        <img src="../../recursos/imgs/Imagen4.jpg" alt="Imagen 4" class="slider-img">
        <img src="../../recursos/imgs/Imagen5.jpg" alt="Imagen 5" class="slider-img">
        <img src="../../recursos/imgs/Imagen6.jpg" alt="Imagen 6" class="slider-img">
        <img src="../../recursos/imgs/Imagen7.jpg" alt="Imagen 7" class="slider-img">
        <img src="../../recursos/imgs/Imagen8.jpg" alt="Imagen 8" class="slider-img">
        <img src="../../recursos/imgs/Imagen9.jpg" alt="Imagen 9" class="slider-img">
        <img src="../../recursos/imgs/Imagen10.jpg" alt="Imagen 10" class="slider-img">
      </div>
    </div>
    <div class="slider-container">
      <div class="slider-track">
        <!-- Se duplican más palabras para que el efecto sea fluido y sin interrupciones -->
        <span class="slider-text">EVENTEC</span>
        <span class="slider-text">TEC SAN PEDRO</span>
        <span class="slider-text">EVENTEC</span>
        <span class="slider-text">TEC SAN PEDRO</span>
        <span class="slider-text">EVENTEC</span>
        <span class="slider-text">TEC SAN PEDRO</span>
        <span class="slider-text">EVENTEC</span>
        <span class="slider-text">TEC SAN PEDRO</span>
        <span class="slider-text">EVENTEC</span>

      </div>
    </div>
    <div class="seccion-eventos" id="eventos">
      <h2>EVENTOS</h2>
      <p>Selecciona los filtros que desees y pulsa la lupa de búsqueda</p>
      <form id="form-filtro">
        <div class="barra-filtro">
          <div class="filtro-container">

            <select name="categoria">
              <option value="" disabled selected>CATEGORÍA</option>
              <option value="">TODOS</option>
              <option value="1">ACADÉMICOS</option>
              <option value="2">DEPORTIVOS</option>
              <option value="3">CULTURALES</option>

            </select>

            <div class="divider"></div>

            <select name="mes">
              <option value="" disabled selected>MES</option>
              <option value="">TODOS</option>
              <option value="01">ENERO</option>
              <option value="02">FEBRERO</option>
              <option value="03">MARZO</option>
              <option value="04">ABRIL</option>
              <option value="05">MAYO</option>
              <option value="06">JUNIO</option>
              <option value="07">JULIO</option>
              <option value="08">AGOSTO</option>
              <option value="09">SEPTIEMBRE</option>
              <option value="10">OCTUBRE</option>
              <option value="11">NOVIEMBRE</option>

              <option value="12">DICIEMBRE</option>
            </select>

            <div class="divider"></div>

            <input type="text" name="buscar" placeholder="BUSCAR" />

            <button type="submit">
              <i class="bi bi-search"></i>
            </button>

          </div>
        </div>
      </form>

      <div class="ag-format-container">
        <div class="ag-courses_box">
          <?php if ($resultado->num_rows > 0): ?>
            <?php while ($evento = $resultado->fetch_assoc()):
              $fechaOriginal = $evento['fecha']; // por ejemplo: 2025-06-08 10:00:00
              $fechaFormateada = date("d.m.Y", strtotime($fechaOriginal));
              $horaFormateada = date("h:i A", strtotime($fechaOriginal));
              $categorias = [
                1 => "Académico",
                2 => "Deportivo",
                3 => "Social"
              ];
              $categoriaNombre = $categorias[$evento['id_categoria']] ?? "Sin categoría";
            ?>
              <div class="ag-courses_item">
                <a href="#info-evento" class="ag-courses-item_link"
                  data-nombre="<?= htmlspecialchars($evento['nombre']) ?>"
                  data-fecha="<?= $fechaFormateada ?>"
                  data-hora="<?= $horaFormateada ?>"
                  data-ubicacion="<?= htmlspecialchars($evento['ubicacion']) ?>"
                  data-organizador="<?= htmlspecialchars($evento['organizador']) ?>"
                  data-categoria="<?= $categoriaNombre ?>"
                  data-imagen="<?= htmlspecialchars($evento['imagen']) ?>">
                  <div class="ag-courses-item_bg"></div>
                  <div class="ag-courses-item_title">
                    <?= htmlspecialchars($evento['nombre']) ?>
                  </div>
                  <div class="ag-courses-item_date-box">
                    Fecha:
                    <span class="ag-courses-item_date">
                      <?= date("d.m.Y", strtotime($evento['fecha'])) ?>
                    </span>
                  </div>
                </a>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p style="color: #fff;">No hay eventos registrados.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="calendario">
      <h2>CALENDARIO</h2>
      <p>Muestra los eventos del mes actual</p>
      <ul>
        <?php
        $diasDelMes = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);

        for ($dia = 1; $dia <= $diasDelMes; $dia++) {
          $fechaISO = sprintf('%04d-%02d-%02d', $anioActual, $mesActual, $dia);
          echo '<li><time datetime="' . $fechaISO . '">' . $dia . '</time>';

          if (isset($eventosPorDia[$dia])) {
            foreach ($eventosPorDia[$dia] as $eventoNombre) {
              echo '<div class="evento-existe">' . htmlspecialchars($eventoNombre) . '</div><br>';
            }
          } else {
            echo 'Ningún Evento';
          }

          echo '</li>';
        }
        ?>
      </ul>

    </div>

    <div id="info-evento" class="info-evento" style="display:none;">
      <!--Seccion de mas informacion-->
      <!-- Título superior -->
      <h2 class="informacion-titulo">Información del Evento</h2>

      <!-- Logo del evento -->
      <div class="logo-container">
        <img src="../../recursos/imgs/evento1.jpg" alt="Logo del Evento">
      </div>

      <!-- Título principal -->
      <div class="title">Hackaton Monterrey 2025</div>

      <!-- Descripción del evento -->
      <p class="descripcion-evento">
        Un evento académico donde los estudiantes demostrarán sus habilidades en programación.
      </p>

      <!-- Tabla de información -->
      <table>
        <tr>
          <td>Evento:</td>
          <td>HACKATON</td>
        </tr>
        <tr>
          <td>Fecha:</td>
          <td>18 Mayo</td>
        </tr>
        <tr>
          <td>Hora:</td>
          <td>10:00 AM</td>
        </tr>
        <tr>
          <td>Ubicación:</td>
          <td>Tec de Monterrey</td>
        </tr>
        <tr>
          <td>Organizador:</td>
          <td>Alumnos del Tec de Monterrey</td>
        </tr>
        <tr>
          <td>Categoría:</td>
          <td>Académico</td>
        </tr>
          
      </table>

    </div>
    <div class="btnRegresar">
      <a href="#eventos">Regresar a Eventos</a>
    </div>
    <footer>
      <img src="../../recursos/imgs/logo.png" alt="Logo Tec San Pedro">
      <div class="btn-social">
        <a href="https://www.facebook.com/oficialtecsp" target="_blank"><i class="bi bi-facebook"></i>FACEBOOK</a>
        <a href="https://www.instagram.com/leonestecsanpedro/" target="_blank"><i
            class="bi bi-instagram"></i>INSTAGRAM</a>
        <a href="https://www.tecsanpedro.edu.mx/" target="_blank"><i class="bi bi-globe2"></i>WEB</a>
      </div>
      <p>Copyright © 2025 Instituto Tecnológico Superior de San Pedro de las Colonias. <br>Todos los derechos
        reservados.</p>
             
    </footer>
  </div>
</body>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('.ag-courses-item_link');

    links.forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();

        const nombre = link.dataset.nombre;
        const fecha = link.dataset.fecha;
        const hora = link.dataset.hora;
        const ubicacion = link.dataset.ubicacion;
        const organizador = link.dataset.organizador;
        const categoria = link.dataset.categoria;
        const imagen = link.dataset.imagen;

        // Mostrar info
        document.querySelector('.info-evento .title').textContent = nombre;
        document.querySelector('.info-evento table').innerHTML = `
        <tr><td>Evento:</td><td>${nombre}</td></tr>
        <tr><td>Fecha:</td><td>${fecha}</td></tr>
        <tr><td>Hora:</td><td>${hora}</td></tr>
        <tr><td>Ubicación:</td><td>${ubicacion}</td></tr>
        <tr><td>Organizador:</td><td>${organizador}</td></tr>
        <tr><td>Categoría:</td><td>${categoria}</td></tr>
      `;
        document.querySelector('.logo-container img').src = imagen;

        document.getElementById('info-evento').style.display = 'block';

        // Scroll hacia abajo
        document.getElementById('info-evento').scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  });
  document.getElementById('form-filtro').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const params = new URLSearchParams(formData).toString();

    fetch('filtrar.php?' + params)
      .then(res => res.text())
      .then(html => {
        document.querySelector('.ag-courses_box').innerHTML = html;
        asignarEventosCards(); // vuelve a asignar eventos a los nuevos elementos
      })
      .catch(err => {
        console.error('Error al cargar eventos filtrados:', err);
      });

  });

  function asignarEventosCards() {
    document.querySelectorAll('.ag-courses-item_link').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();

        // Extraer los datos
        const nombre = this.dataset.nombre;
        const fecha = this.dataset.fecha;
        const hora = this.dataset.hora;
        const ubicacion = this.dataset.ubicacion;
        const organizador = this.dataset.organizador;
        const categoria = this.dataset.categoria;
        const imagen = this.dataset.imagen;

        // Insertar los datos en la sección #info-evento
        document.querySelector('#info-evento .title').textContent = nombre;
        document.querySelector('#info-evento .descripcion-evento').textContent = 'Información sobre el evento.';
        document.querySelector('#info-evento img').src = imagen;
        const tabla = document.querySelector('#info-evento table');
        tabla.innerHTML = `
        <tr><td>Evento:</td><td>${nombre}</td></tr>
        <tr><td>Fecha:</td><td>${fecha}</td></tr>
        <tr><td>Hora:</td><td>${hora}</td></tr>
        <tr><td>Ubicación:</td><td>${ubicacion}</td></tr>
        <tr><td>Organizador:</td><td>${organizador}</td></tr>
        <tr><td>Categoría:</td><td>${categoria}</td></tr>
      `;

        // Mostrar la sección
        document.getElementById('info-evento').style.display = 'block';
        // Desplazar a la sección
        document.getElementById('info-evento').scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  }
</script>

</html>