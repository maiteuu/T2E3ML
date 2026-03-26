<?php
session_start();

$xmlFile = 'kexak.xml';
$mensaje_html = "";

// 1. Lógica para guardar la queja
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $mensaje = trim($_POST['mensaje']);
    $fecha = date("Y-m-d H:i:s");

    if (empty($nombre) || empty($apellido) || empty($email) || empty($mensaje)) {
        $mensaje_html = "<div class='error-mensaje'>Errorea: Eremu guztiak bete behar dira.</div>";
    } else {
        if (!file_exists($xmlFile)) {
            $baseXml = "<?xml version='1.0' encoding='UTF-8'?><kexak></kexak>";
            file_put_contents($xmlFile, $baseXml);
        }

        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->load($xmlFile);

        $nuevaKexa = $dom->createElement('kexa');
        $nuevaKexa->appendChild($dom->createElement('data', $fecha));
        $nuevaKexa->appendChild($dom->createElement('izena', htmlspecialchars($nombre)));
        $nuevaKexa->appendChild($dom->createElement('abizena', htmlspecialchars($apellido)));
        $nuevaKexa->appendChild($dom->createElement('emaila', htmlspecialchars($email)));
        $nuevaKexa->appendChild($dom->createElement('mezua', htmlspecialchars($mensaje)));

        $dom->documentElement->appendChild($nuevaKexa);
        $dom->save($xmlFile);

        $mensaje_html = "<div class='itxi'>Eskerrik asko! Zure mezua ondo bidali da.</div>";
    }
}

// 2. Preparamos el XSLT (Solo para lo que va dentro del MAIN)
$xmlDummy = new DOMDocument();
$xmlDummy->loadXML('<?xml version="1.0" encoding="UTF-8"?><datos></datos>');

$xsl = new DOMDocument();
$xsl->load('kontaktua.xsl');

$procesador = new XSLTProcessor();
$procesador->importStyleSheet($xsl);
$procesador->setParameter('', 'mensaje', $mensaje_html);
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontaktua – Euskal Futbol Federazioa</title>
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
                    <li><a href="kontaktua.php" class="menu-activo">KONTAKTUA</a></li>
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
        // 3. Imprimimos el formulario generado por el XSL
        echo $procesador->transformToXML($xmlDummy);
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