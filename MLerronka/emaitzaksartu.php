<?php
session_start();

// 1. SEGURIDAD: Solo Árbitros pueden meter resultados
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'arbitro') {
    header("Location: index.php");
    exit();
}

$archivo_xml = 'liga.xml';
// Cargamos el XML
$xml = simplexml_load_file($archivo_xml);
$error = "";

// 2. SI EL ÁRBITRO ENVÍA EL FORMULARIO...
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Limpiamos los espacios en blanco con trim()
    $local = trim($_POST['local']);
    $visitante = trim($_POST['visitante']);
    $goles_local = $_POST['goles_local'];
    $goles_visitante = $_POST['goles_visitante'];

    // --- REGLA 1: Un equipo no puede jugar contra sí mismo ---
    if ($local === $visitante) {
        $error = "Errorea: Ezin da talde bera aukeratu bi aldiz!";
    } else {
        // --- REGLA 2: Comprobar si el partido ya se ha jugado ---
        $partido_repetido = false;

        // Recorremos los partidos que ya están en el XML
        if ($xml->partidos && $xml->partidos->partido) {
            foreach ($xml->partidos->partido as $p) {
                $xml_local = trim((string) $p->local);
                $xml_visitante = trim((string) $p->visitante);

                if ($xml_local === $local && $xml_visitante === $visitante) {
                    $partido_repetido = true;
                    break;
                }
            }
        }

        // Si hemos detectado que está repetido, mostramos error
        if ($partido_repetido) {
            $error = "Errorea: Partidu hau jokatuta dago!";
        } else {
            // --- GUARDAMOS EL PARTIDO ---
            $nuevo_partido = $xml->partidos->addChild('partido');
            $nuevo_partido->addChild('local', $local);
            $nuevo_partido->addChild('visitante', $visitante);
            $nuevo_partido->addChild('goles_local', $goles_local);
            $nuevo_partido->addChild('goles_visitante', $goles_visitante);

            // Borramos clasificaciones antiguas por si acaso
            if (isset($xml->clasificacion_actual)) {
                unset($xml->clasificacion_actual);
            }
            if (isset($xml->clasificacion_global)) {
                unset($xml->clasificacion_global);
            }

            // Guardamos el XML ordenado
            $dom = new DOMDocument('1.0');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($xml->asXML());
            $dom->save($archivo_xml);

            // Volvemos a la tabla de clasificación
            header("Location: sailkapena.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emaitzak sartu - Euskal Futbol Federazioa</title>
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
        <div class="formulario-caja">
            <h2>Partiduaren Emaitza Sartu</h2>

            <?php if ($error != ""): ?>
                <div class="error-mensaje">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">

                <?php
                $opciones_equipos = "";
                if ($xml) {
                    foreach ($xml->xpath("//equipos/equipo") as $eq) {
                        $nombre_eq = (string) $eq->nombre;
                        $opciones_equipos .= "<option value='$nombre_eq'>$nombre_eq</option>";
                    }
                }
                ?>

                <div>
                    <label>Etxeko Taldea (Local):</label>
                    <select name="local" required>
                        <option value="" disabled selected>-- Aukeratu Taldea --</option>
                        <?php echo $opciones_equipos; ?>
                    </select>
                </div>

                <div>
                    <label>Etxeko Golak (Goles Local):</label>
                    <input type="number" name="goles_local" required min="0">
                </div>

                <hr>

                <div>
                    <label>Kanpoko Taldea (Visitante):</label>
                    <select name="visitante" required>
                        <option value="" disabled selected>-- Aukeratu Taldea --</option>
                        <?php echo $opciones_equipos; ?>
                    </select>
                </div>

                <div>
                    <label>Kanpoko Golak (Goles Visitante):</label>
                    <input type="number" name="goles_visitante" required min="0">
                </div>

                <button type="submit" class="btn-guardar">
                    Gorde Emaitza
                </button>
            </form>
        </div>
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