<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8" indent="yes" doctype-system="about:legacy-compat" />

    <xsl:param name="equipo_id" />

    <xsl:template match="/">
        <xsl:variable name="equipo" select="liga_global/equipos/equipo[id=$equipo_id]" />

        <html lang="eu">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>Ficha del Equipo - <xsl:value-of select="$equipo/nombre" /></title>
            <link rel="icon" type="image/jpg" href="irudiak/balon.ico" />
            <link rel="stylesheet" href="css/styles.css"/>
        </head>
        <body>
            <header>
                <div class="logo">
                    <img class="eff" src="irudiak/EFFLOGOA.png" alt="EFF Logo" />
                </div>
                <nav>
                    <ul>
                        <li><a href="index.html">HASIERA</a></li>
                        <li><a href="sailkapena.php">SAILKAPENA</a></li>
                        <li><a href="#">FITXAKETAK</a></li>
                        <li><a href="loginform.php">HASI SAIOA</a></li>
                    </ul>
                </nav>
            </header>

            <main>
                <div class="contenedor-tabla">
                    
                    <div class="ficha-equipo">
                        <img src="irudiak/{$equipo/foto}" alt="Escudo" />
                        
                        <h1><xsl:value-of select="$equipo/nombre" /></h1>
                        <p><strong>Sorrera urtea:</strong> <xsl:value-of select="$equipo/anioCreacion" /></p>
                        <p><strong>Zelaia:</strong> <xsl:value-of select="$equipo/zelaia" /></p>
                    </div>

                    <div class="titulo">Plantilla</div>
                    <table>
                        <thead>
                            <tr>
                                <th>IZENA</th>
                                <th>POSIZIOA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <xsl:for-each select="liga_global/jugadores/jugadorLista/jugador[@equipo=$equipo_id]">
                                <tr>
                                    <td><xsl:value-of select="@nombre" /></td>
                                    <td><xsl:value-of select="@posicion" /></td>
                                </tr>
                            </xsl:for-each>
                        </tbody>
                    </table>

                    <div style="text-align: center;">
                        <a href="sailkapena.php" class="btn-volver">Itzuli sailkapenera</a>
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
                        <img src="irudiak/facebook.png" alt="Facebook" class="footer-icon" />
                    </a>
                    <a href="#" class="icon-circle" aria-label="X" target="_blank" rel="noopener">
                        <img src="irudiak/gorjeo.png" alt="X" class="footer-icon" />
                    </a>
                    <a href="#" class="icon-circle" aria-label="YouTube" target="_blank" rel="noopener">
                        <img src="irudiak/youtube.png" alt="YouTube" class="footer-icon" />
                    </a>
                    <a href="https://www.instagram.com/eff_fvf/reels/" class="icon-circle" aria-label="Instagram" target="_blank" rel="noopener">
                        <img src="irudiak/instagram.png" alt="Instagram" class="footer-icon" />
                    </a>
                </div>
            </footer>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>