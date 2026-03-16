<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8" indent="yes" />

    <xsl:param name="equipo_id" />

    <xsl:template match="/">
        <xsl:variable name="equipo" select="liga_global/equipos/equipo[id = $equipo_id]" />

        <div class="contenedor-tabla">
            
            <div class="ficha-equipo">
                <img>
                    <xsl:attribute name="src">
                        <xsl:text>irudiak/</xsl:text>
                        <xsl:value-of select="$equipo/foto" />
                    </xsl:attribute>
                    <xsl:attribute name="alt">
                        <xsl:text>Escudo</xsl:text>
                    </xsl:attribute>
                </img>
                
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

            <div>
                <a href="sailkapena.php" class="btn-volver">Itzuli sailkapenera</a>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>