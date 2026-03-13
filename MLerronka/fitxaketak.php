<?php
// 1. Cargamos el archivo XML principal
$xml = new DOMDocument;
$xml->load('liga.xml');

// 2. Cargamos el archivo XSL de fichajes
$xsl = new DOMDocument;
$xsl->load('fitxaketak.xsl');

// 3. Creamos el procesador XSLT
$procesador = new XSLTProcessor;
$procesador->importStyleSheet($xsl);
?>

<!DOCTYPE html>
<html lang="eu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fitxaketak – Euskal Futbol Federazioa</title>
  <link rel="icon" type="image/jpg" href="irudiak/balon.ico">
  <link rel="stylesheet" href="css/styles.css?v=3" />
</head>
<body>

  <header>
    <div class="logo">
      <img class="eff" src="irudiak/EFFLOGOA.png" alt="EFF Logo">
    </div>
    <nav>
      <ul>
        <<li><a href="index.html">HASIERA</a></li>
        <li><a href="sailkapena.php">SAILKAPENA</a></li>
        <li><a href="fitxaketak.php">FITXAKETAK</a></li>
        <li><a href="kontaktua.html">KONTAKTUA</a></li>
        <li><a href="loginform.php">HASI SAIOA</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <?php
      // 4. Transformamos e imprimimos el contenido de las tarjetas
      echo $procesador->transformToXML($xml);
    ?>
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
      <a href="https://www.instagram.com/eff_fvf/reels/" class="icon-circle" aria-label="Instagram" target="_blank" rel="noopener">
        <img src="irudiak/instagram.png" alt="Instagram" class="footer-icon">
      </a>
    </div>
  </footer>
</body>
</html>