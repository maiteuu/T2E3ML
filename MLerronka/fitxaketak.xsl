<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8" indent="yes" />

    <xsl:template match="/">
        <div class="titulo-seccion">Azken Fitxaketak</div>
        
        <div class="contenedor-fichajes">
            <xsl:for-each select="liga_global/fichajes/fichaje">
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

                        <div class="flecha-fichaje">
                            <span>&#10142;</span>
                        </div>

                        <div class="equipo-fichaje">
                            <xsl:variable name="img_destino" select="substring-after(destino/@escudo, '../')" />
                            <img src="{$img_destino}" alt="Escudo Destino" />
                            <p><xsl:value-of select="destino" /></p>
                        </div>

                    </div>
                </div>
            </xsl:for-each>
        </div>
    </xsl:template>
</xsl:stylesheet>