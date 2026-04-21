<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8" />
    <xsl:param name="id_equipo" />

    <xsl:template match="/">
        <xsl:variable name="datos_equipo" select="//equipo[id=$id_equipo]" />

        <div class="cabecera-equipo">
            <img src="irudiak/{$datos_equipo/foto}" alt="Escudo" class="escudo-grande" />
            <h1 class="titulo-equipo">
                <xsl:value-of select="$datos_equipo/nombre" />
            </h1>
            <p class="info-estadio">Zelaia: <xsl:value-of select="$datos_equipo/zelaia" /></p>
        </div>

        <hr class="separador" />

        <div class="jugadores-grid">
            <xsl:for-each select="//jugador[@equipo=$id_equipo]">
                <div class="tarjeta-jugador">
                    <img src="irudiak/{@foto}" alt="{@nombre}" class="foto-jugador" />
                    <h3><xsl:value-of select="@nombre" /></h3>
                    <span class="posicion-tag"><xsl:value-of select="@posicion" /></span>
                </div>
            </xsl:for-each>
        </div>

        <div class="botonera-inferior">
            <a href="sailkapena.php" class="btn-volver">SAILKAPENERA ITZULI</a>
        </div>
    </xsl:template>
</xsl:stylesheet>