<?php session_start(); ?>
<!DOCTYPE html>
<html lang="eu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kontaktua – Euskal Futbol Federazioa</title>
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
    <div class="titulo-seccion">Kontaktua</div>

    <div class="contact-wrapper">
      
      <div class="map-column">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m" 
          width="100%" 
          height="100%" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>

      <div class="info-column">
        <section class="contact-section">
          <h2>Gurekin Harremanetan Jarri</h2>
          
          <div class="email-item">
            <span class="icon-red" aria-hidden="true">
              <img src="irudiak/email.png" alt="" width="20" height="16">
            </span>
            <div class="email-text"><strong>Zuzendaritza Posta Elektronikoa</strong><br>zuzendaritza@euskadifutbol.eus</div>
          </div>
          <div class="email-item">
            <span class="icon-red" aria-hidden="true">
              <img src="irudiak/email.png" alt="" width="20" height="16">
            </span>
            <div class="email-text"><strong>Lehiaketen Posta Elektronikoa</strong><br>competiciones@euskadifutbol.eus</div>
          </div>
        </section>
      </div>

    </div>

    <div class="survey-section">
      <h2>Bidaliguzu zure iritzia (Inkesta)</h2>
      
      <div class="google-form-wrapper">
        <iframe 
          src="https://docs.google.com/forms/d/e/1FAIpQLSe2EIeuVI0ze2PPCHkGMO41nFJfwqvQURCDesJJFZPmvAF3dw/viewform?embedded=true" 
          width="100%" 
          height="800" 
          frameborder="0" 
          marginheight="0" 
          marginwidth="0">Cargando…
        </iframe>
      </div>
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
      <a href="https://www.instagram.com/eff_fvf/reels/" class="icon-circle" aria-label="Instagram" target="_blank" rel="noopener">
        <img src="irudiak/instagram.png" alt="Instagram" class="footer-icon">
      </a>
    </div>
  </footer>

</body>
</html>