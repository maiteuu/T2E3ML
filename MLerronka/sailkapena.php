<?php
session_start();

// 1. CARGAMOS EL XML ORIGINAL
$archivo_xml = 'liga.xml';
$xml = simplexml_load_file($archivo_xml);

$clasificacion = [];

if ($xml) {
  // 2. PREPARAMOS LA PIZARRA CON LOS IDs
  foreach ($xml->xpath("//equipos/equipo") as $eq) {
    $nombre = (string) $eq->nombre;
    $id = (string) $eq->id;
    $clasificacion[$nombre] = [
      'id' => $id,
      'nombre' => $nombre,
      'puntos' => 0,
      'jugados' => 0,
      'ganados' => 0,
      'empatados' => 0,
      'perdidos' => 0,
      'gf' => 0,
      'gc' => 0
    ];
  }

  // 3. LEEMOS LOS RESULTADOS Y CALCULAMOS
  $partidos = $xml->xpath("//partidos/partido");
  if ($partidos) {
    foreach ($partidos as $partido) {
      $local = (string) $partido->local;
      $visitante = (string) $partido->visitante;
      $gl = (int) $partido->goles_local;
      $gv = (int) $partido->goles_visitante;

      if (isset($clasificacion[$local]) && isset($clasificacion[$visitante])) {
        $clasificacion[$local]['jugados']++;
        $clasificacion[$visitante]['jugados']++;

        $clasificacion[$local]['gf'] += $gl;
        $clasificacion[$local]['gc'] += $gv;
        $clasificacion[$visitante]['gf'] += $gv;
        $clasificacion[$visitante]['gc'] += $gl;

        if ($gl > $gv) {
          $clasificacion[$local]['puntos'] += 3;
          $clasificacion[$local]['ganados']++;
          $clasificacion[$visitante]['perdidos']++;
        } elseif ($gl < $gv) {
          $clasificacion[$visitante]['puntos'] += 3;
          $clasificacion[$visitante]['ganados']++;
          $clasificacion[$local]['perdidos']++;
        } else {
          $clasificacion[$local]['puntos'] += 1;
          $clasificacion[$visitante]['puntos'] += 1;
          $clasificacion[$local]['empatados']++;
          $clasificacion[$visitante]['empatados']++;
        }
      }
    }
  }

  // 4. INYECTAMOS LA CLASIFICACIÓN EN LA MEMORIA (NO EN EL ARCHIVO)
  unset($xml->clasificacion_actual);
  $nodo_clasificacion = $xml->addChild('clasificacion_actual');

  foreach ($clasificacion as $eq) {
    $fila = $nodo_clasificacion->addChild('fila');
    $fila->addChild('equipo_id', $eq['id']);
    $fila->addChild('nombre', $eq['nombre']);
    $fila->addChild('pj', $eq['jugados']);
    $fila->addChild('pg', $eq['ganados']);
    $fila->addChild('pe', $eq['empatados']);
    $fila->addChild('pp', $eq['perdidos']);
    $fila->addChild('gf', $eq['gf']);
    $fila->addChild('gc', $eq['gc']);
    $fila->addChild('dg', $eq['gf'] - $eq['gc']);
    $fila->addChild('puntos', $eq['puntos']);
  }
}

// 5. PROCESAMOS EL XSLT CON LOS DATOS EN MEMORIA
// Convertimos nuestro SimpleXML (que tiene la tabla en memoria) a DOMDocument
$xmlDoc = new DOMDocument('1.0');
$xmlDoc->loadXML($xml->asXML());
// ¡OJO! Aquí estaba la clave: YA NO HACEMOS $xmlDoc->save('liga.xml');

// Cargamos el diseño XSLT
$xslDoc = new DOMDocument();
$xslDoc->load('sailkapena.xsl');

// Mezclamos ambos
$proc = new XSLTProcessor();
$proc->importStyleSheet($xslDoc);

// Guardamos el HTML resultante
$tabla_html_final = $proc->transformToXML($xmlDoc);
?>

<!DOCTYPE html>
<html lang="eu">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sailkapena - Euskal Futbol Federazioa</title>
  <link rel="icon" type="image/jpg" href="irudiak/balon.ico">
  <link rel="stylesheet" href="css/styles.css?v=6" />
</head>

<body>

  <header>
    <div class="logo">
      <img class="eff" src="irudiak/EFFLOGOA.png" alt="EFF Logo">
    </div>
    <nav>
      <ul>
        <li><a href="index.php">HASIERA</a></li>

        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'arbitro'): ?>
          <li class="dropdown">
            <a href="sailkapena.php">SAILKAPENA ▼</a>
            <ul class="dropdown-menu">
              <li><a href="emaitzaksartu.php">Emaitza berria gehitu</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li><a href="sailkapena.php">SAILKAPENA</a></li>
        <?php endif; ?>

        <li><a href="emaitzak.php">EMAITZAK</a></li>

        <li><a href="fitxaketak.php">FITXAKETAK</a></li>

        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
          <li class="dropdown">
            <a href="kontaktua.php">KONTAKTUA ▼</a>
            <ul class="dropdown-menu">
              <li><a href="kexak_ikusi.php">Kexak Ikusi</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li><a href="kontaktua.php">KONTAKTUA</a></li>
        <?php endif; ?>

        <?php if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])): ?>
          <li><span class="user-rol-badge"> <?php echo $_SESSION['usuario']; ?></span></li>
          <li><a href="logout.php" class="btn-logout">ITXI SAIOA</a></li>
        <?php else: ?>
          <li><a href="loginform.php">HASI SAIOA</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <main>
    <?php echo $tabla_html_final; ?>
  </main>

  <footer>
    <div class="footer-info">
      <p>Lehendakari Aguirre, 97</p>
      <p>646 78 98 78</p>
    </div>
    <div class="social-icons">
      <a href="#" class="icon-circle" aria-label="Facebook" target="_blank" rel="noopener">
        <img src="irudiak/facebook.png" alt="Facebook" class="footer-icon">
      </a>
      <a href="#" class="icon-circle" aria-label="X" target="_blank" rel="noopener">
        <img src="irudiak/gorjeo.png" alt="X" class="footer-icon">
      </a>
      <a href="#" class="icon-circle" aria-label="YouTube" target="_blank" rel="noopener">
        <img src="irudiak/youtube.png" alt="YouTube" class="footer-icon">
      </a>
      <a href="https://www.instagram.com/eff_fvf/reels/" class="icon-circle" aria-label="Instagram" target="_blank"
        rel="noopener">
        <img src="irudiak/instagram.png" alt="Instagram" class="footer-icon">
      </a>
    </div>
  </footer>

</body>

</html>