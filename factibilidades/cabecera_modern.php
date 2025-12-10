<?php
/*
  Proyecto: intranet iContel
  Archivo: cabecera_modern.php
  Descripción: Versión modernizada de cabecera_new.php usando ModernGrid
  Ruta URL: https://intranet.icontel.cl/factibilidades/cabecera_modern.php
  Versión: 1.0.0
  
  Cambios:
  2025-01-10 (v1.0.0): Migración de phpMyDataGrid a ModernGrid
*/

// Incluir la nueva librería
require_once('./lib/ModernGrid.php');

// Crear el objeto grid
$objGrid = new ModernGrid('cabecera_modern.php', '1');

// Conectar a base de datos
$objGrid->conectadb("172.16.10.15", "data_studio", "1Ngr3s0.,", "tnasolut_factibilidades");

// Configurar grid de detalles (maestro-detalle)
$objGrid->setDetailsGrid("detalles_modern.php", "fac");

// Configuración HTML amigable
$objGrid->friendlyHTML();

// Definir tabla
$objGrid->tabla("cabecera");

// Título del grid
$objGrid->tituloGrid("Mantenedor de Factibilidades de TNA Solutions");

// Campos de búsqueda
$objGrid->searchby("tipo, estado, ejecutivo, fac, ancho_banda, nombre, contacto, contrato, direccion, comentario");

// Codificación
$objGrid->charset = 'UTF-8';
$objGrid->sqlcharset = "utf8";

// Campo clave
$objGrid->keyfield("fac");

// Ordenamiento
$objGrid->orderby("fac", "desc");

// Registros por página
$objGrid->datarows(25);

// Exportación inline
$objGrid->strExportInline = true;

// Calcular próximo número de factibilidad
$next_fact = fnext_fac();

// Fecha de hoy
$hoy = fhoy_str();
$dias = 1;

// Definir columnas
$objGrid->FormatColumn("fac", "FAC", 6, 6, 0, "20", "center", "number", $next_fact);
$objGrid->FormatColumn("sweet_op", "OP Sweet", 40, 40, 0, "40", "center", "text", "");
$objGrid->FormatColumn("tipo", "Tipo Servicio", 40, 30, 0, "80", "center", "select:Enlace:Upgrade:Satelital", "Enlace");
$objGrid->FormatColumn("ejecutivo", "Ejecutiv@", 40, 40, 0, "40", "center", "select:VTA:DAM:MAM:MAO:GRC:MRB:NDB:RMT:SWM", "GRC");
$objGrid->FormatColumn("estado", "Estado", 40, 30, 0, "150", "left", "select:00 sin solicitar:01 solicitado:02 cotizado proveedor:02 cotizado cliente:03 en seguimiento:03 En espera por cliente:03 En Formalizacion:03 aprobado por cliente:04 solicitar instalacion:05 instalacion:05 Inst espera Cliente:05 Renovacion:06 en provision:07 en produccion:08 dado de baja:09 sin factibilidad:10 rechazada cliente:11 cliente rechazado:12 trasladado:12 Reemplazada", "00 sin solicitar");
$objGrid->FormatColumn("rut", "R.U.T.", 150, 150, 0, "100", "left", "text", "");
$objGrid->FormatColumn("nombre", "Nombre Completo", 150, 150, 0, "150", "left", "text", "");
$objGrid->FormatColumn("direccion", "Direccion", 80, 80, 0, "400", "left", "text", "");
$objGrid->FormatColumn("contacto", "Contacto", 100, 200, 0, "300", "left", "text", "");
$objGrid->FormatColumn("ancho_banda", "Ancho de Banda", 100, 200, 0, "100", "right", "text", "");
$objGrid->FormatColumn("solicitud", "Fecha solicitud", 10, 10, 0, "80", "center", "date:dmyy:-", $hoy);
$objGrid->FormatColumn("aprobacion", "Fecha aprobacion", 10, 10, 0, "80", "center", "date:dmyy:-", "");
$objGrid->FormatColumn("compromiso_cliente", "Fecha Comprometida", 10, 10, 0, "80", "center", "date:dmyy:-", "");
$objGrid->FormatColumn("instalacion", "Fecha Instalacion", 10, 10, 0, "80", "center", "date:dmyy:-", "");
$objGrid->FormatColumn("dias", "Dias Habiles", 13, 20, 0, "30", "center", "number", $dias);
$objGrid->FormatColumn("comentario", "Comentarios", 200, 200, 0, "300", "left", "text", "");

// Estilos condicionales de celda
$objGrid->addCellStyle("fac", "['fac']<>'0'", "bold");
$objGrid->addCellStyle("estado", "['estado']=='00 sin solicitar'", "bold");
$objGrid->addCellStyle("estado", "['estado']=='01 solicitado'", "colornegro");
$objGrid->addCellStyle("estado", "['estado']=='02 cotizado cliente'", "colorazul");
$objGrid->addCellStyle("estado", "['estado']=='03 aprobado por cliente'", "bold");
$objGrid->addCellStyle("estado", "['estado']=='04 solicitar instalacion'", "bold");
$objGrid->addCellStyle("estado", "['estado']=='05 instalacion'", "colorrojo");
$objGrid->addCellStyle("estado", "['estado']=='06 en provision'", "colormagenta");
$objGrid->addCellStyle("estado", "['estado']=='07 en produccion'", "colorverde");
$objGrid->addCellStyle("estado", "['estado']=='09 sin factibilidad'", "colorgris");
$objGrid->addCellStyle("estado", "['estado']=='10 rechazada cliente'", "colorgris");

// Estilos condicionales de fila
$objGrid->addRowStyle("['estado']=='00 sin solicitar'", "colorrojo");
$objGrid->addRowStyle("['estado']=='02 cotizado cliente'", "activedata");

// Mostrar grid
$objGrid->display();

// ============================================
// FUNCIONES AUXILIARES
// ============================================

function fhoy_str() {
    $date = new DateTime();
    $fecha_str = $date->format('d-m-Y');
    return $fecha_str;
}

function fnext_fac() {
    $conn = new mysqli("172.16.10.15", "data_studio", "1Ngr3s0.,", "tnasolut_factibilidades");
    
    if ($conn->connect_error) {
        die("Error de Conexion: " . $conn->connect_error);
    }
    
    $sql = "SELECT * FROM `cabecera` ORDER BY `fac` DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    
    $fnext_fac = 1;
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $fnext_fac = $row['fac'];
        }
    }
    
    mysqli_free_result($result);
    $conn->close();
    
    return ($fnext_fac + 1);
}
?>
