<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8" indent="yes" />

    <xsl:template match="/kexak">
        <div class="contenedor-centrado">
            <h2 class="titulo-principal-contacto">JASOTAKO KEXAK</h2>
        </div>
        
        <div class="kexak-zerrenda">
            <xsl:choose>
                <xsl:when test="count(kexa) = 0">
                    <div class="formulario-caja texto-centrado">
                        <p>Momentuz ez dago kexarik.</p>
                    </div>
                </xsl:when>
                
                <xsl:otherwise>
                    <xsl:for-each select="kexa">
                        <xsl:sort select="data" order="descending" />
                        
                        <div class="kexa-tarjeta">
                            <div class="kexa-header">
                                <xsl:value-of select="izena" /> <xsl:text> </xsl:text> <xsl:value-of select="abizena" />
                            </div>
                            
                            <div class="kexa-meta">
                                <xsl:value-of select="emaila" /> | <xsl:value-of select="data" />
                            </div>
                            
                            <hr class="separador-formulario" />
                            
                            <div class="kexa-body">
                                <xsl:value-of select="mezua" />
                            </div>
                        </div>
                    </xsl:for-each>
                </xsl:otherwise>
            </xsl:choose>
        </div>
    </xsl:template>
</xsl:stylesheet>