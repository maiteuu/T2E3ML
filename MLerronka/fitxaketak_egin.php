<?php
session_start();

// Comprobamos la seguridad
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Cargamos el XML con la forma fácil (SimpleXML)
$xml = simplexml_load_file('liga.xml');

if ($_POST) {
    // Buscamos los equipos elegidos
    $ori = $xml->xpath("//equipos/equipo[id='{$_POST['origen']}']")[0];
    $des = $xml->xpath("//equipos/equipo[id='{$_POST['destino']}']")[0];

    // 1. CREAMOS EL HISTORIAL DEL FICHAJE
    $nuevo_fichaje = $xml->fichajes->addChild('fichaje');
    $nuevo_fichaje->addChild('jugador', $_POST['jugador']);
    
    $nodo_origen = $nuevo_fichaje->addChild('origen', $ori->nombre);
    $nodo_origen->addAttribute('escudo', '../irudiak/' . $ori->foto);

    $nodo_destino = $nuevo_fichaje->addChild('destino', $des->nombre);
    $nodo_destino->addAttribute('escudo', '../irudiak/' . $des->foto);

    $nuevo_fichaje->addChild('precio', $_POST['precio']);
    
    // 2. ACTUALIZAMOS EL EQUIPO DEL JUGADOR
    $jugador_a_mover = $xml->xpath("//jugadorLista/jugador[@nombre='{$_POST['jugador']}']")[0];
    $jugador_a_mover['equipo'] = $_POST['destino'];

    // 3. GUARDAMOS EL XML PERFECTAMENTE ORDENADO
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML()); // Le pasamos lo que hemos hecho con SimpleXML
    $dom->save('liga.xml');       // Sobrescribimos el archivo
    
    // Volvemos a la pantalla de fichajes
    header("Location: fitxaketak.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <title>Fitxaketa Berria</title>
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="icon" type="image/jpg" href="irudiak/balon.ico">
</head>
<body>
    <header>
        <div class="logo"><img class="eff" src="irudiak/EFFLOGOA.png" alt="EFF Logo"></div>
        <nav>
            <ul>
                <li><a href="index.php">HASIERA</a></li>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'arbitro'): ?>
                    <li class="dropdown"><a href="sailkapena.php">SAILKAPENA ▼</a><ul class="dropdown-menu"><li><a href="emaitza_form.php">Emaitza berria</a></li></ul></li>
                <?php else: ?>
                    <li><a href="sailkapena.php">SAILKAPENA</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
                    <li class="dropdown"><a href="fitxaketak.php">FITXAKETAK ▼</a><ul class="dropdown-menu"><li><a href="fitxaketa_form.php">Fitxaketa berria</a></li></ul></li>
                <?php else: ?>
                    <li><a href="fitxaketak.php">FITXAKETAK</a></li>
                <?php endif; ?>

                <li><a href="kontaktua.php">KONTAKTUA</a></li>
                <li class="dropdown"><a href="#">DENBORALDIA: <?php echo isset($texto_temp) ? $texto_temp : '24/25'; ?> ▼</a>
                    <ul class="dropdown-menu"><li><a href="?temp=2425">2024-2025</a></li><li><a href="?temp=2526">2025-2026</a></li></ul>
                </li>

                <?php if (isset($_SESSION['usuario'])): ?>
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
            <h2>Fitxaketa Berria</h2>
            <form method="POST" action="">
                
                <label>Jokalaria:</label>
                <select name="jugador" required>
                    <?php 
                    foreach ($xml->xpath("//jugadorLista/jugador") as $j) {
                        echo "<option>" . $j['nombre'] . "</option>"; 
                    }
                    ?>
                </select>

                <?php
                $opciones = "";
                foreach ($xml->xpath("//equipos/equipo") as $eq) {
                    $opciones .= "<option value='{$eq->id}'>{$eq->nombre}</option>";
                }
                ?>

                <label>Jatorrizko Taldea (Origen):</label>
                <select name="origen" required><?php echo $opciones; ?></select>

                <label>Helmuga Taldea (Destino):</label>
                <select name="destino" required><?php echo $opciones; ?></select>

                <label>Prezioa (€):</label>
                <input type="number" name="precio" required min="0">

                <button type="submit" class="btn-guardar">Gorde</button>
            </form>
            <div><a href="fitxaketak.php" class="btn-volver">Itzuli fitxaketetara</a></div>
        </div>
    </main>

    <footer>
        <div class="footer-info"><p>Lehendakari Aguirre, 97</p><p>646 78 98 78</p></div>
        <div class="social-icons">
            <a href="#" class="icon-circle"><img src="irudiak/facebook.png" class="footer-icon"></a>
            <a href="#" class="icon-circle"><img src="irudiak/gorjeo.png" class="footer-icon"></a>
            <a href="#" class="icon-circle"><img src="irudiak/youtube.png" class="footer-icon"></a>
            <a href="https://www.instagram.com/eff_fvf/reels/" class="icon-circle"><img src="irudiak/instagram.png" class="footer-icon"></a>
        </div>
    </footer>
</body>
</html>