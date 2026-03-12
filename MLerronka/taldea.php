<?php
// 1. Recoger el ID de la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: No has seleccionado ningún equipo.");
}
$id_equipo = $_GET['id'];

// 2. Cargamos el archivo XML
$xml = new DOMDocument;
$xml->load('liga.xml');

// 3. Cargamos el archivo XSL (¡que vamos a crear ahora!)
$xsl = new DOMDocument;
$xsl->load('taldea.xsl');

// 4. Creamos el procesador XSLT de PHP
$procesador = new XSLTProcessor;
$procesador->importStyleSheet($xsl);

// 5. LA MAGIA: Le pasamos la ID del equipo desde PHP hacia el archivo XSLT
$procesador->setParameter('', 'equipo_id', $id_equipo);

// 6. Transformamos e imprimimos
echo $procesador->transformToXML($xml);
?>