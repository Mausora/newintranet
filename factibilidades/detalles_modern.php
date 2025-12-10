<?php
/*
  Proyecto: intranet iContel
  Archivo: detalles_modern.php
  Descripción: Versión modernizada de detalles_new.php usando ModernGrid
  Ruta URL: https://intranet.icontel.cl/factibilidades/detalles_modern.php
  Versión: 1.0.0
  
  Cambios:
  2025-01-10 (v1.0.0): Migración de phpMyDataGrid a ModernGrid
*/

// Incluir la nueva librería
require_once('./lib/ModernGrid.php');

// Crear el objeto grid
$objGrid = new ModernGrid('detalles_modern.php', '2');

// Conectar a base de datos
$objGrid->conectadb("172.16.10.15", "data_studio", "1Ngr3s0.,", "tnasolut_factibilidades");

// Definir relación con tabla maestra y obtener el valor del id
$fac = $objGrid->setMasterRelation("fac");

// Registros por página
$objGrid->datarows(50);

// Definir tabla
$objGrid->tabla("detalle");

// Codificación
$objGrid->charset = 'UTF-8';
$objGrid->sqlcharset = "utf8";

// Campo clave
$objGrid->keyfield("id");

// Ordenamiento
$objGrid->orderby("tipo", "ASC");

// Título
$objGrid->tituloGrid("Detalles de Factibilidad FAC: " . ($fac ?? ''));

// Campos de búsqueda
$objGrid->searchby("estado, tipo, proveedor, mbps, datacenter");

// Exportación inline
$objGrid->strExportInline = true;

// Definir columnas
$objGrid->FormatColumn("fac", "FAC", 6, 6, 0, "50", "center", "number", $fac);
$objGrid->FormatColumn("estado", "Estado", 40, 30, 0, "100", "left", "select:Consulta:Cotizado:Aprobado:Rechazado", "Consulta");
$objGrid->FormatColumn("tipo", "Tipo Conexión", 50, 50, 0, "120", "left", "text", "");
$objGrid->FormatColumn("mbps", "Mbps", 30, 30, 0, "80", "right", "text", "");
$objGrid->FormatColumn("proveedor", "Proveedor", 50, 50, 0, "120", "left", "text", "");
$objGrid->FormatColumn("cod_serv", "Cod. Servicio", 30, 30, 0, "100", "left", "text", "");
$objGrid->FormatColumn("cot", "# COT", 15, 15, 0, "80", "left", "text", "");
$objGrid->FormatColumn("plazo", "Plazo", 10, 10, 0, "60", "right", "number", "");
$objGrid->FormatColumn("inst_costo", "Costo Instalación", 10, 10, 0, "100", "right", "number", "");
$objGrid->FormatColumn("mes_costo", "Costo Mensual", 10, 10, 0, "100", "right", "number", "");
$objGrid->FormatColumn("inst_venta", "Venta Instalación", 10, 10, 0, "100", "right", "number", "");
$objGrid->FormatColumn("mes_venta", "Venta Mensual", 10, 10, 0, "100", "right", "number", "");
$objGrid->FormatColumn("margen_inst", "Margen Inst.", 10, 10, 0, "80", "right", "number", "");
$objGrid->FormatColumn("margen_mensual", "Margen Mens.", 10, 10, 0, "80", "right", "number", "");
$objGrid->FormatColumn("datacenter", "Data Center", 50, 50, 0, "100", "left", "text", "");
$objGrid->FormatColumn("comentarios", "Comentarios", 200, 200, 0, "300", "left", "text", "");

// Estilos condicionales
$objGrid->addCellStyle("estado", "['estado']=='Consulta'", "colornegro");
$objGrid->addCellStyle("estado", "['estado']=='Cotizado'", "colorazul");
$objGrid->addCellStyle("estado", "['estado']=='Aprobado'", "colorverde");
$objGrid->addCellStyle("estado", "['estado']=='Rechazado'", "colorgris");

// Mostrar grid
$objGrid->display();
?>
