<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="css/styles.css?v=2" />
</head>

<body>
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
    <main>
        <section>
            <article>

                <?php if (isset($_GET['itxi'])): ?>
                    <p class="itxi">Saioa itxi da</p>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <p class="error">Erabiltzailea edo pasahitza okerrak dira</p>
                <?php endif; ?>

                <form action="balidazioa.php" method="post">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Idatzi erabiltzailea" required>
                    <br><br>

                    <label for="contrasena">Pasahitza:</label>
                    <input type="password" id="contrasena" name="contrasena" placeholder="Idatzi pasahitza" required>
                    <br><br>

                    <input type="submit" value="Bidali" class="botoiak">
                </form>
            </article>
        </section>
    </main>

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
            <a href="https://www.instagram.com/eff_fvf/reels/" class="icon-circle" aria-label="Instagram"
                target="_blank" rel="noopener">
                <img src="irudiak/instagram.png" alt="Instagram" class="footer-icon">
            </a>
        </div>
    </footer>
</body>

</html>