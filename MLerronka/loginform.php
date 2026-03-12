<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <img src="irudiak/logoa.png" alt="Logoa">
        <br><br>
        <nav>
            <h1>Sartzea debekatuta. Egin logina jarraitzeko.</h1>
        </nav>
    </header>
    <main>
        <section>
            <article>
                <h2>Erabiltzaileen login-a</h2>
                
                <?php if(isset($_GET['itxi'])): ?>
                    <p class="itxi">Saioa itxi da</p>
                <?php endif; ?>

                <?php if(isset($_GET['error'])): ?>
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
        <h3>© Markel egindako ariketa</h3>
    </footer>
</body>
</html>