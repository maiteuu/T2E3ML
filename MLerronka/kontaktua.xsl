<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8" indent="yes" />
    
    <xsl:param name="mensaje" />

    <xsl:template match="/">
        <div class="formulario-caja">
            <h2 class="titulo-principal-contacto">KEXA EDO IRADOKIZUNA</h2>
            <p class="texto-centrado">Bete formulario hau gurekin harremanetan jartzeko.</p>
            
            <xsl:if test="$mensaje != ''">
                <xsl:value-of select="$mensaje" disable-output-escaping="yes" />
            </xsl:if>

            <form method="POST" action="kontaktua.php">
                
                <h3 class="titulo-formulario">1. Identifikazioa</h3>
                
                <div class="form-group">
                    <label class="form-label">Izena (Nombre):</label>
                    <input type="text" name="nombre" required="required" />
                </div>
                <div class="form-group">
                    <label class="form-label">Abizena (Apellido):</label>
                    <input type="text" name="apellido" required="required" />
                </div>
                <div class="form-group">
                    <label class="form-label">Emaila (Correo):</label>
                    <input type="email" name="email" required="required" />
                </div>

                <hr class="separador-formulario" />

                <h3 class="titulo-formulario">2. Asuntua</h3>
                
                <div class="form-group">
                    <label class="form-label">Mezua (Mensaje):</label>
                    <textarea name="mensaje" class="campo-texto-largo" required="required" placeholder="Idatzi zure kexa edo iradokizuna hemen..."></textarea>
                </div>

                <button type="submit" class="btn-guardar">Bidali Kexa</button>
            </form>
        </div>
    </xsl:template>
</xsl:stylesheet>