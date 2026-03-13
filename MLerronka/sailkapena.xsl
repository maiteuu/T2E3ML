<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" encoding="UTF-8" indent="yes" />

    <xsl:template match="/">
        <div class="contenedor-tabla">
            <div class="titulo">Futbol Txapelketaren sailkapena</div>

            <table>
                <thead>
                    <tr>
                        <th>POS</th>
                        <th>ARMARRIA</th>
                        <th>TALDEAK</th>
                        <th>PJ</th>
                        <th>PG</th>
                        <th>PE</th>
                        <th>PP</th>
                        <th>GF</th>
                        <th>GC</th>
                        <th>DG</th>
                        <th>PTS</th>
                    </tr>
                </thead>
                <tbody>
                    <xsl:for-each select="liga_global/clasificacion_actual/fila">
                        <xsl:sort select="puntos" data-type="number" order="descending" />

                        <tr>
                            <xsl:attribute name="class">
                                <xsl:choose>
                                    <xsl:when test="position() = 1">fila-champions</xsl:when>
                                    <xsl:when test="position() = 2">fila-europa</xsl:when>
                                    <xsl:when test="position() = last()">fila-descenso</xsl:when>
                                </xsl:choose>
                            </xsl:attribute>

                            <td>
                                <xsl:value-of select="position()" />
                            </td>

                            <td>
                                <xsl:variable name="id_equipo" select="equipo_id" />
                                <xsl:variable name="escudo" select="/liga_global/equipos/equipo[id=$id_equipo]/foto" />
                                <img>
                                    <xsl:attribute name="src">
                                        <xsl:text>irudiak/</xsl:text>
                                        <xsl:value-of select="$escudo" />
                                    </xsl:attribute>
                                    <xsl:attribute name="width">30</xsl:attribute>
                                    <xsl:attribute name="alt">Escudo</xsl:attribute>
                                </img>
                            </td>

                            <td>
                                <a>
                                    <xsl:attribute name="href">
                                        <xsl:text>taldea.php?id=</xsl:text>
                                        <xsl:value-of select="equipo_id" />
                                    </xsl:attribute>
                                    <b><xsl:value-of select="nombre" /></b>
                                </a>
                            </td>

                            <td><xsl:value-of select="pj" /></td>
                            <td><xsl:value-of select="pg" /></td>
                            <td><xsl:value-of select="pe" /></td>
                            <td><xsl:value-of select="pp" /></td>
                            <td><xsl:value-of select="gf" /></td>
                            <td><xsl:value-of select="gc" /></td>
                            <td><xsl:value-of select="dg" /></td>
                            <td class="puntos">
                                <b><xsl:value-of select="puntos" /></b>
                            </td>
                        </tr>
                    </xsl:for-each>
                </tbody>
            </table>

            <div class="leyenda">
                <div class="item-leyenda">
                    <div class="color-box color-champions"></div>
                    <span>1º - Champions League</span>
                </div>
                <div class="item-leyenda">
                    <div class="color-box color-europa"></div>
                    <span>2º - Europa League</span>
                </div>
                <div class="item-leyenda">
                    <div class="color-box color-descenso"></div>
                    <span>6º - Descenso</span>
                </div>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>