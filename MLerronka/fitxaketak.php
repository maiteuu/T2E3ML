<?php
session_start();
$xmlFile = 'liga.xml';

// LÓGICA: GUARDAR EL COMENTARIO EN EL FICHAJE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['iruzkina']) && isset($_SESSION['usuario'])) {
    $jugador_objetivo = $_POST['jugador'];
    $texto_iruzkina = trim($_POST['iruzkina']);
    $usuario_actual = $_SESSION['usuario'];

    if (!empty($texto_iruzkina)) {
        $xmlDoc = new DOMDocument();
        $xmlDoc->preserveWhiteSpace = false;
        $xmlDoc->formatOutput = true;
        $xmlDoc->load($xmlFile);

        $xpath = new DOMXPath($xmlDoc);
        // Ruta exacta adaptada a tu liga.xml
        $fichaje = $xpath->query("/liga_global/fichajes/fichaje[jugador='$jugador_objetivo']")->item(0);

        if ($fichaje) {
            $iruzkinak_node = $fichaje->getElementsByTagName('iruzkinak')->item(0);
            if (!$iruzkinak_node) {
                $iruzkinak_node = $xmlDoc->createElement('iruzkinak');
                $fichaje->appendChild($iruzkinak_node);
            }
            $nuevo_iruzkina = $xmlDoc->createElement('iruzkina', htmlspecialchars($texto_iruzkina));
            $nuevo_iruzkina->setAttribute('erabiltzailea', htmlspecialchars($usuario_actual));
            $iruzkinak_node->appendChild($nuevo_iruzkina);
            $xmlDoc->save($xmlFile);
        }
    }
    header("Location: fitxaketak.php");
    exit();
}

$xml = new DOMDocument;
$xml->load('liga.xml');
$xsl = new DOMDocument;
$xsl->load('fitxaketak.xsl');
$usuario_sesion = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
$procesador = new XSLTProcessor;
$procesador->importStyleSheet($xsl);
$procesador->setParameter('', 'usuario', $usuario_sesion);
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxaketak  - Euskal Futbol Federazioa</title>
    <link rel="icon" type="image/jpg" href="irudiak/balon.ico">
    <link rel="stylesheet" href="css/styles.css?v=10" />
</head>
<body>
    <header>
        <div class="logo"><img class="eff" src="irudiak/EFFLOGOA.png" alt="EFF Logo"></div>
        <nav>
            <ul>
                <li><a href="index.php">HASIERA</a></li>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'arbitro'): ?>
                    <li class="dropdown"><a href="sailkapena.php">SAILKAPENA ▼</a><ul class="dropdown-menu"><li><a href="emaitzaksartu.php">Emaitza berria gehitu</a></li></ul></li>
                <?php else: ?><li><a href="sailkapena.php">SAILKAPENA</a></li><?php endif; ?>
                <li><a href="emaitzak.php">EMAITZAK</a></li>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
                    <li class="dropdown"><a href="fitxaketak.php">FITXAKETAK ▼</a><ul class="dropdown-menu"><li><a href="fitxaketak_egin.php">Fitxaketa berria gehitu</a></li></ul></li>
                <?php else: ?><li><a href="fitxaketak.php">FITXAKETAK</a></li><?php endif; ?>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
                    <li class="dropdown"><a href="kontaktua.php">KONTAKTUA ▼</a><ul class="dropdown-menu"><li><a href="kexak_ikusi.php">Kexak Ikusi</a></li></ul></li>
                <?php else: ?><li><a href="kontaktua.php">KONTAKTUA</a></li><?php endif; ?>
                <?php if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])): ?>
                    <li><span class="user-rol-badge"> <?php echo $_SESSION['usuario']; ?></span></li>
                    <li><a href="logout.php" class="btn-logout">ITXI SAIOA</a></li>
                <?php else: ?><li><a href="loginform.php">HASI SAIOA</a></li><?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <?php echo $procesador->transformToXML($xml); ?>
    </main>
    <footer>
        <div class="footer-info"><p>Lehendakari Aguirre, 97</p><p>646 78 98 78</p></div>
    </footer>
</body>
</html>