<?php
session_start();

// 1. Recogemos el ID del equipo (si no hay, por defecto el 1)
$id_equipo = isset($_GET['id']) ? $_GET['id'] : 1;

// 2. Cargamos XML y XSL
$xml = new DOMDocument;
$xml->load('liga.xml');

$xsl = new DOMDocument;
$xsl->load('taldea.xsl');

// 3. Configuramos el procesador y pasamos el ID del equipo
$procesador = new XSLTProcessor;
$procesador->importStyleSheet($xsl);
$procesador->setParameter('', 'id_equipo', $id_equipo);

// 4. Transformamos
$contenido_jugadores = $procesador->transformToXML($xml);
?>

<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <title>Taldea - Euskal Futbol Federazioa</title>
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
        <div class="contenedor-principal-taldea">
            <?php echo $contenido_jugadores; ?>
        </div>
    </main>

    <footer>
        <div class="footer-info">
            <p>Lehendakari Aguirre, 97 | 646 78 98 78</p>
        </div>
    </footer>
</body>

</html>