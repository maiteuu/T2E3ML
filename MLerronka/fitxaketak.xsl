<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8" indent="yes" />
    <xsl:param name="usuario" />

    <xsl:template match="/liga_global">
        <div class="titulo-seccion">Azken Fitxaketak</div>
        <div class="contenedor-fichajes">
            <xsl:for-each select="fichajes/fichaje">
                <div class="tarjeta-fichaje">
                    <div class="fichaje-cabecera">
                        <h3><xsl:value-of select="jugador" /></h3>
                        <span class="precio"><xsl:value-of select="precio" /> €</span>
                    </div>
                    <div class="fichaje-trayectoria">
                        <div class="equipo-fichaje">
                            <xsl:variable name="img_origen" select="substring-after(origen/@escudo, '../')" />
                            <img src="{$img_origen}" alt="Escudo Origen" />
                            <p><xsl:value-of select="origen" /></p>
                        </div>
                        <div class="flecha-fichaje"><span>&#10142;</span></div>
                        <div class="equipo-fichaje">
                            <xsl:variable name="img_destino" select="substring-after(destino/@escudo, '../')" />
                            <img src="{$img_destino}" alt="Escudo Destino" />
                            <p><xsl:value-of select="destino" /></p>
                        </div>
                    </div>
                    <div class="seccion-comentarios">
                        <h4>Iruzkinak</h4>
                        <xsl:choose>
                            <xsl:when test="iruzkinak/iruzkina">
                                <xsl:for-each select="iruzkinak/iruzkina">
                                    <div class="comentario-item">
                                        <span class="comentario-autor"><xsl:value-of select="@erabiltzailea"/>:</span> 
                                        <xsl:text> </xsl:text><xsl:value-of select="."/>
                                    </div>
                                </xsl:for-each>
                            </xsl:when>
                            <xsl:otherwise>
                                <div class="comentario-item" style="color: #777; border-bottom: none;">
                                    Ez dago iruzkinik. Izan lehena iritzia ematen!
                                </div>
                            </xsl:otherwise>
                        </xsl:choose>
                        <xsl:choose>
                            <xsl:when test="$usuario != ''">
                                <form method="POST" action="fitxaketak.php" class="form-comentario">
                                    <input type="hidden" name="jugador" value="{jugador}" />
                                    <input type="text" name="iruzkina" class="input-comentario" placeholder="Zer iruditzen zaizu fitxaketa hau?" required="required" />
                                    <button type="submit" class="btn-comentario">Bidali</button>
                                </form>
                            </xsl:when>
                            <xsl:otherwise>
                                <div class="mensaje-login-comentario">
                                    Iruzkin bat uzteko, <a href="loginform.php" style="color: var(--eff-green, #00893d); font-weight: bold;">hasi saioa</a>.
                                </div>
                            </xsl:otherwise>
                        </xsl:choose>
                    </div>
                </div>
            </xsl:for-each>
        </div>
    </xsl:template>
</xsl:stylesheet> 