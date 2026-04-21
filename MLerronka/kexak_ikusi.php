<?php
session_start();

// 1. SEGURIDAD: Solo Admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// 2. Cargamos el archivo XML de quejas
$xmlFile = 'kexak.xml';
if (!file_exists($xmlFile)) {
    $xmlData = "<?xml version='1.0' encoding='UTF-8'?><kexak></kexak>";
    $xml = new DOMDocument();
    $xml->loadXML($xmlData);
} else {
    $xml = new DOMDocument();
    $xml->load($xmlFile);
}

// 3. Cargamos el XSL
$xsl = new DOMDocument();
$xsl->load('kexak_ikusi.xsl');

// 4. Creamos el procesador
$procesador = new XSLTProcessor();
$procesador->importStyleSheet($xsl);
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kexak Ikusi – Euskal Futbol Federazioa</title>
    <link rel="icon" type="image/jpg" href="irudiak/balon.ico">
    <link rel="stylesheet" href="css/styles.css?v=10" />
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
                        <a href="kontaktua.php" class="menu-activo">KONTAKTUA ▼</a>
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
        <?php
        // 5. Transformamos e imprimimos la lista de quejas
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
        </div>
    </footer>
</body>
</html>