<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8" />
    <xsl:param name="usuario" />

    <xsl:template match="/liga_global">
        <div class="lista-partidos">
            <xsl:for-each select="partidos/partido">
                
                <xsl:variable name="nombre_local" select="local" />
                <xsl:variable name="nombre_visitante" select="visitante" />
                
                <xsl:variable name="foto_local" select="/liga_global/equipos/equipo[nombre=$nombre_local]/foto" />
                <xsl:variable name="foto_visitante" select="/liga_global/equipos/equipo[nombre=$nombre_visitante]/foto" />

                <div style="background: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 20px; padding: 20px;">
                    <div class="marcador-fila" style="margin-bottom: 0; box-shadow: none; padding: 0;">
                        <div class="equipo local">
                            <span class="nombre-equipo"><xsl:value-of select="local" /></span>
                            <img src="irudiak/{$foto_local}" alt="{local}" class="escudo-resultado" />
                        </div>
                        <div class="resultado-caja">
                            <span class="goles"><xsl:value-of select="goles_local" /></span>
                            <span class="guion">-</span>
                            <span class="goles"><xsl:value-of select="goles_visitante" /></span>
                        </div>
                        <div class="equipo visitante">
                            <img src="irudiak/{$foto_visitante}" alt="{visitante}" class="escudo-resultado" />
                            <span class="nombre-equipo"><xsl:value-of select="visitante" /></span>
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
                                <form method="POST" action="emaitzak.php" class="form-comentario">
                                    <input type="hidden" name="local_obj" value="{local}" />
                                    <input type="hidden" name="visitante_obj" value="{visitante}" />
                                    <input type="text" name="iruzkina" class="input-comentario" placeholder="Zer iruditzen zaizu partidua?" required="required" />
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