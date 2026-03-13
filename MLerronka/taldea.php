<?php
session_start();
// 1. Recoger el ID de la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: No has seleccionado ningún equipo.");
}
$id_equipo = $_GET['id'];

// 2. Cargamos el archivo XML
$xml = new DOMDocument;
$xml->load('liga.xml');

// 3. Cargamos el archivo XSL
$xsl = new DOMDocument;
$xsl->load('taldea.xsl');

// 4. Creamos el procesador XSLT de PHP
$procesador = new XSLTProcessor;
$procesador->importStyleSheet($xsl);

// 5. Le pasamos la ID del equipo desde PHP hacia el archivo XSLT
$procesador->setParameter('', 'equipo_id', $id_equipo);
?>

<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taldea – Euskal Futbol Federazioa</title>
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
                <li><a href="index.php">HASIERA</a></li>
                <li><a href="sailkapena.php">SAILKAPENA</a></li>
                <li><a href="fitxaketak.php">FITXAKETAK</a></li>
                <li><a href="kontaktua.php">KONTAKTUA</a></li>
                
                <?php if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])): ?>
                    <li><span class="user-rol-badge">👤 <?php echo $_SESSION['usuario']; ?></span></li>
                    <li><a href="logout.php" class="btn-logout">ITXI SAIOA</a></li>
                <?php else: ?>
                    <li><a href="loginform.php">HASI SAIOA</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <?php
        // 6. Transformamos e imprimimos la ficha del equipo
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
            <a href="https://www.instagram.com/eff_fvf/reels/" class="icon-circle" aria-label="Instagram"
                target="_blank" rel="noopener">
                <img src="irudiak/instagram.png" alt="Instagram" class="footer-icon">
            </a>
        </div>
    </footer>
</body>

</html>