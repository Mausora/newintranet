<?php
/*
  Proyecto: intranet iContel
  Archivo: export_excel.php
  Descripción: Script de exportación a Excel para ModernGrid
  Autor: Emergent AI - Mauricio Araneda
  Versión: 1.0.0
  Fecha: 2025-01-10
*/

require_once('./lib/ExcelExporter.php');

// Configuración de base de datos
$dbHost = "172.16.10.15";
$dbUser = "data_studio";
$dbPass = "1Ngr3s0.,";
$dbName = "tnasolut_factibilidades";

// Obtener parámetros
$table = $_GET['table'] ?? 'cabecera';
$script = $_GET['script'] ?? '';
$masterField = $_GET['master_field'] ?? null;
$masterValue = $_GET['master_value'] ?? null;

// Configurar columnas según tabla
$columns = [];
$title = '';
$filename = 'export.xlsx';

if ($table === 'cabecera') {
    $title = 'Factibilidades TNA Solutions';
    $filename = 'factibilidades_' . date('Y-m-d') . '.xlsx';
    $columns = [
        'fac' => ['label' => 'FAC', 'mask' => 'number', 'align' => 'center'],
        'sweet_op' => ['label' => 'OP Sweet', 'mask' => 'text', 'align' => 'center'],
        'tipo' => ['label' => 'Tipo Servicio', 'mask' => 'text', 'align' => 'center'],
        'ejecutivo' => ['label' => 'Ejecutiv@', 'mask' => 'text', 'align' => 'center'],
        'estado' => ['label' => 'Estado', 'mask' => 'text', 'align' => 'left'],
        'rut' => ['label' => 'R.U.T.', 'mask' => 'text', 'align' => 'left'],
        'nombre' => ['label' => 'Nombre Completo', 'mask' => 'text', 'align' => 'left'],
        'direccion' => ['label' => 'Dirección', 'mask' => 'text', 'align' => 'left'],
        'contacto' => ['label' => 'Contacto', 'mask' => 'text', 'align' => 'left'],
        'ancho_banda' => ['label' => 'Ancho de Banda', 'mask' => 'text', 'align' => 'right'],
        'solicitud' => ['label' => 'Fecha Solicitud', 'mask' => 'date:dmyy:-', 'align' => 'center'],
        'aprobacion' => ['label' => 'Fecha Aprobación', 'mask' => 'date:dmyy:-', 'align' => 'center'],
        'compromiso_cliente' => ['label' => 'Fecha Comprometida', 'mask' => 'date:dmyy:-', 'align' => 'center'],
        'instalacion' => ['label' => 'Fecha Instalación', 'mask' => 'date:dmyy:-', 'align' => 'center'],
        'dias' => ['label' => 'Días Hábiles', 'mask' => 'number', 'align' => 'center'],
        'comentario' => ['label' => 'Comentarios', 'mask' => 'text', 'align' => 'left']
    ];
} elseif ($table === 'detalle') {
    $title = 'Detalles de Factibilidad';
    $filename = 'detalle_factibilidad_' . date('Y-m-d') . '.xlsx';
    $columns = [
        'fac' => ['label' => 'FAC', 'mask' => 'number', 'align' => 'center'],
        'estado' => ['label' => 'Estado', 'mask' => 'text', 'align' => 'left'],
        'tipo' => ['label' => 'Tipo', 'mask' => 'text', 'align' => 'left'],
        'mbps' => ['label' => 'MBPS', 'mask' => 'text', 'align' => 'right'],
        'proveedor' => ['label' => 'Proveedor', 'mask' => 'text', 'align' => 'left'],
        'cod_serv' => ['label' => 'Código Servicio', 'mask' => 'text', 'align' => 'left'],
        'cot' => ['label' => 'Cotización', 'mask' => 'text', 'align' => 'left'],
        'plazo' => ['label' => 'Plazo', 'mask' => 'number', 'align' => 'right'],
        'inst_costo' => ['label' => 'Instalación Costo', 'mask' => 'number', 'align' => 'right'],
        'mes_costo' => ['label' => 'Mensual Costo', 'mask' => 'number', 'align' => 'right'],
        'inst_venta' => ['label' => 'Instalación Venta', 'mask' => 'number', 'align' => 'right'],
        'mes_venta' => ['label' => 'Mensual Venta', 'mask' => 'number', 'align' => 'right'],
        'margen_inst' => ['label' => 'Margen Instalación', 'mask' => 'number', 'align' => 'right'],
        'margen_mensual' => ['label' => 'Margen Mensual', 'mask' => 'number', 'align' => 'right'],
        'datacenter' => ['label' => 'Datacenter', 'mask' => 'text', 'align' => 'left'],
        'comentarios' => ['label' => 'Comentarios', 'mask' => 'text', 'align' => 'left']
    ];
}

// Crear exportador
$exporter = new ExcelExporter($dbHost, $dbUser, $dbPass, $dbName);
$exporter->setTable($table);
$exporter->setColumns($columns);
$exporter->setTitle($title);

// Filtro maestro si existe
if ($masterField && $masterValue) {
    $exporter->setMasterFilter($masterField, $masterValue);
}

// Exportar
$exporter->export($filename);
?>
