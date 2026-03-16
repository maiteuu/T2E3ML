<?php
session_start();
// 2. Cargamos el archivo XML
$xml = new DOMDocument;
$xml->load('liga.xml');

// 3. Cargamos el archivo XSL
$xsl = new DOMDocument;
$xsl->load('sailkapena.xsl');

// 4. Creamos el procesador XSLT de PHP
$procesador = new XSLTProcessor;

// 5. Le metemos nuestra plantilla XSL al procesador
$procesador->importStyleSheet($xsl);

?>





<!DOCTYPE html>
<link rel="icon" type="img/jpg" href="irudiak/balon.ico">
<html lang="eu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EFF – Euskal Futbol Federazioa</title>
  <link rel="stylesheet" href="css/styles.css?v=2" />
</head>

<body>

  <!-- CABECERA / MENÚ -->
  <header>
    <div class="logo">
      <!-- LOGO -->
      <img class="eff" src="irudiak/EFFLOGOA.png" alt="EFF Logo">
    </div>

    <nav>
    <ul>
        <li><a href="index.php">HASIERA</a></li>
        
        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'arbitro'): ?>
            <li class="dropdown">
                <a href="sailkapena.php">SAILKAPENA ▼</a>
                <ul class="dropdown-menu">
                    <li><a href="emaitza_form.php">Emaitza berria gehitu</a></li>
                </ul>
            </li>
        <?php else: ?>
            <li><a href="sailkapena.php">SAILKAPENA</a></li>
        <?php endif; ?>

        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
            <li class="dropdown">
                <a href="fitxaketak.php">FITXAKETAK ▼</a>
                <ul class="dropdown-menu">
                    <li><a href="fitxaketa_form.php">Fitxaketa berria gehitu</a></li>
                </ul>
            </li>
        <?php else: ?>
            <li><a href="fitxaketak.php">FITXAKETAK</a></li>
        <?php endif; ?>

        <li><a href="kontaktua.php">KONTAKTUA</a></li>

        <li class="dropdown">
            <a href="#">DENBORALDIA: <?php echo isset($texto_temp) ? $texto_temp : '24/25'; ?> ▼</a>
            <ul class="dropdown-menu">
                <li><a href="?temp=2425">2024-2025</a></li>
                <li><a href="?temp=2526">2025-2026</a></li>
            </ul>
        </li>

        <?php if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])): ?>
            <li><span class="user-rol-badge"> <?php echo $_SESSION['usuario']; ?></span></li>
            <li><a href="logout.php" class="btn-logout">ITXI SAIOA</a></li>
        <?php else: ?>
            <li><a href="loginform.php">HASI SAIOA</a></li>
        <?php endif; ?>
    </ul>
</nav>
  </header>

  <!-- CONTENIDO PRINCIPAL -->
 

  <main>
    
  <?php
    // 6. Transformamos el XML usando el XSL y lo imprimimos directamente en el HTML
    echo $procesador->transformToXML($xml);
    ?>
    
  </main>

   <!-- PIE DE PÁGINA -->
  <footer>


    <!-- DIRECCIÓN -->
    <div class="footer-info ">
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
          <a href="https://www.instagram.com/eff_fvf/reels/" class="icon-circle" aria-label="Instagram" target="_blank" rel="noopener">
            <img src="irudiak/instagram.png" alt="Instagram" class="footer-icon">
          </a>
    </div>
</footer>

</body>
</html>
