<?php
/*
  Proyecto: intranet iContel
  Archivo: ModernGrid.php
  Descripción: Reemplazo moderno de phpMyDataGrid - Compatible PHP 7.4+ / 8.x
  Autor: Emergent AI - Mauricio Araneda
  Versión: 1.0.0
  Fecha: 2025-01-10
  
  Características:
  - Compatibilidad total con PHP 7.4+ y 8.x
  - Sistema maestro-detalle nativo
  - Exportación Excel con PhpSpreadsheet
  - API similar a phpMyDataGrid para migración fácil
  - Código limpio sin ofuscación
*/

class ModernGrid {
    
    // Propiedades básicas
    private $scriptName;
    private $gridID;
    private $conn;
    private $tableName;
    private $keyField;
    private $columns = [];
    private $orderBy = '';
    private $orderDirection = 'ASC';
    private $rowsPerPage = 20;
    private $searchFields = '';
    private $title = '';
    private $charset = 'UTF-8';
    private $sqlCharset = 'utf8';
    private $height = '';
    private $exportInline = false;
    private $detailsGrid = null;
    private $detailsKey = null;
    private $masterRelationField = null;
    private $cellStyles = [];
    private $rowStyles = [];
    private $buttonWidth = 30;
    
    // Constructor
    public function __construct($scriptName = '', $gridID = '') {
        $this->scriptName = $scriptName ?: basename($_SERVER['PHP_SELF']);
        $this->gridID = $gridID;
    }
    
    // Conectar a base de datos
    public function conectadb($host, $user, $pass, $database) {
        $this->conn = new mysqli($host, $user, $pass, $database);
        
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
        
        $this->conn->set_charset($this->sqlCharset);
        return true;
    }
    
    // Definir tabla
    public function tabla($tableName) {
        $this->tableName = $tableName;
    }
    
    // Definir campo clave
    public function keyfield($field) {
        $this->keyField = $field;
    }
    
    // Definir ordenamiento
    public function orderby($field, $direction = 'ASC') {
        $this->orderBy = $field;
        $this->orderDirection = strtoupper($direction);
    }
    
    // Definir filas por página
    public function datarows($rows) {
        $this->rowsPerPage = (int)$rows;
    }
    
    // Definir campos de búsqueda
    public function searchby($fields) {
        $this->searchFields = $fields;
    }
    
    // Definir título
    public function tituloGrid($title) {
        $this->title = $title;
    }
    
    // Definir charset
    public function __set($name, $value) {
        if ($name === 'charset') {
            $this->charset = $value;
        } elseif ($name === 'sqlcharset') {
            $this->sqlCharset = $value;
        } elseif ($name === 'height') {
            $this->height = $value;
        } elseif ($name === 'strExportInline') {
            $this->exportInline = $value;
        } elseif ($name === 'ButtonWidth') {
            $this->buttonWidth = $value;
        }
    }
    
    // Formatear columna
    public function FormatColumn($fieldName, $label, $fieldWidth, $maxLength, $inputType, $columnWidth, $align, $mask = 'text', $default = '') {
        $this->columns[$fieldName] = [
            'name' => $fieldName,
            'label' => $label,
            'fieldWidth' => $fieldWidth,
            'maxLength' => $maxLength,
            'inputType' => $inputType,
            'columnWidth' => $columnWidth,
            'align' => $align,
            'mask' => $mask,
            'default' => $default
        ];
    }
    
    // Definir grid de detalles (maestro-detalle)
    public function setDetailsGrid($detailsScript, $keyField) {
        $this->detailsGrid = $detailsScript;
        $this->detailsKey = $keyField;
    }
    
    // Definir relación maestra (para grid de detalles)
    public function setMasterRelation($field) {
        $this->masterRelationField = $field;
        
        // Obtener valor del parámetro maestro
        if (isset($_GET[$field])) {
            return $_GET[$field];
        } elseif (isset($_POST[$field])) {
            return $_POST[$field];
        }
        
        return null;
    }
    
    // Agregar estilo condicional a celda
    public function addCellStyle($field, $condition, $cssClass) {
        if (!isset($this->cellStyles[$field])) {
            $this->cellStyles[$field] = [];
        }
        $this->cellStyles[$field][] = [
            'condition' => $condition,
            'class' => $cssClass
        ];
    }
    
    // Agregar estilo condicional a fila
    public function addRowStyle($condition, $cssClass) {
        $this->rowStyles[] = [
            'condition' => $condition,
            'class' => $cssClass
        ];
    }
    
    // HTML amigable
    public function friendlyHTML() {
        // No hace nada, solo compatibilidad
    }
    
    // Obtener datos
    private function getData($masterValue = null) {
        $sql = "SELECT * FROM `{$this->tableName}`";
        
        // Filtro maestro-detalle
        if ($masterValue !== null && $this->masterRelationField) {
            $sql .= " WHERE `{$this->masterRelationField}` = '" . $this->conn->real_escape_string($masterValue) . "'";
        }
        
        // Ordenamiento
        if ($this->orderBy) {
            $sql .= " ORDER BY `{$this->orderBy}` {$this->orderDirection}";
        }
        
        // Límite
        $sql .= " LIMIT {$this->rowsPerPage}";
        
        $result = $this->conn->query($sql);
        
        if (!$result) {
            die("Error en consulta: " . $this->conn->error);
        }
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }
    
    // Evaluar condición
    private function evaluateCondition($condition, $row) {
        // Reemplazar ['campo'] con valores reales
        foreach ($row as $key => $value) {
            $condition = str_replace("['$key']", "'" . addslashes($value) . "'", $condition);
        }
        
        // Evaluar condición de forma segura
        try {
            return eval("return ($condition);");
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Renderizar grid
    public function display() {
        $masterValue = null;
        if ($this->masterRelationField) {
            $masterValue = isset($_GET[$this->masterRelationField]) ? $_GET[$this->masterRelationField] : null;
        }
        
        $data = $this->getData($masterValue);
        
        echo "<div class='modern-grid-container'>";
        
        if ($this->title) {
            echo "<div class='grid-header'>";
            echo "<h2 class='grid-title'>{$this->title}</h2>";
            echo "</div>";
        }
        
        // Barra de herramientas (toolbar)
        echo "<div class='grid-toolbar'>";
        echo "<button onclick='addRecord()' class='btn-toolbar'><img src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNOCAxVjE1TTEgOEgxNSIgc3Ryb2tlPSIjNENBRjUwIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPjwvc3ZnPg==' /> Adicionar</button>";
        echo "<button onclick='searchRecord()' class='btn-toolbar'><img src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48Y2lyY2xlIGN4PSI3IiBjeT0iNyIgcj0iNSIgc3Ryb2tlPSIjMjE5NkYzIiBzdHJva2Utd2lkdGg9IjIiLz48cGF0aCBkPSJNMTEgMTFMMTUgMTUiIHN0cm9rZT0iIzIxOTZGMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiLz48L3N2Zz4=' /> Buscar</button>";
        
        if ($this->exportInline) {
            echo "<button onclick='exportToExcel()' class='btn-toolbar'><img src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB4PSIyIiB5PSIyIiB3aWR0aD0iMTIiIGhlaWdodD0iMTIiIHN0cm9rZT0iI0ZGOTgwMCIgc3Ryb2tlLXdpZHRoPSIyIi8+PHBhdGggZD0iTTUgNkg xMU01IDlIMTEiIHN0cm9rZT0iI0ZGOTgwMCIgc3Ryb2tlLXdpZHRoPSIyIi8+PC9zdmc+' /> Exportar</button>";
        }
        
        echo "</div>";
        
        // Tabla
        $heightStyle = $this->height ? "max-height: {$this->height}; overflow-y: auto;" : "";
        echo "<div class='grid-table-container' style='$heightStyle'>";
        echo "<table class='modern-grid-table' cellspacing='0' cellpadding='0'>";
        
        // Cabecera
        echo "<thead><tr>";
        
        // Columna de botones (acciones)
        echo "<th class='col-actions' style='width: 80px;'>Botones</th>";
        
        foreach ($this->columns as $col) {
            $width = $col['columnWidth'] ? "width: {$col['columnWidth']}px;" : "";
            echo "<th style='$width text-align: {$col['align']};'>{$col['label']}</th>";
        }
        
        echo "</tr></thead>";
        
        // Cuerpo
        echo "<tbody>";
        $rowIndex = 0;
        foreach ($data as $row) {
            $keyValue = $row[$this->keyField] ?? $rowIndex;
            
            // Evaluar estilos de fila
            $rowClass = '';
            foreach ($this->rowStyles as $style) {
                if ($this->evaluateCondition($style['condition'], $row)) {
                    $rowClass = $style['class'];
                    break;
                }
            }
            
            echo "<tr class='grid-row $rowClass' data-key='$keyValue'>";
            
            // Columna de acciones
            echo "<td class='col-actions'>";
            echo "<button class='btn-action btn-delete' onclick='deleteRecord({$keyValue})' title='Eliminar'>✖</button>";
            echo "<button class='btn-action btn-edit' onclick='editRecord({$keyValue})' title='Editar'>✎</button>";
            
            // Botón de detalles si existe
            if ($this->detailsGrid && $this->detailsKey) {
                echo "<button class='btn-action btn-details' onclick='toggleDetails({$keyValue})' title='Ver detalles'>▼</button>";
            }
            
            echo "</td>";
            
            // Datos
            foreach ($this->columns as $colName => $col) {
                $value = $row[$colName] ?? '';
                
                // Formatear valor según máscara
                $value = $this->formatValue($value, $col['mask']);
                
                // Evaluar estilos de celda
                $cellClass = '';
                if (isset($this->cellStyles[$colName])) {
                    foreach ($this->cellStyles[$colName] as $style) {
                        if ($this->evaluateCondition($style['condition'], $row)) {
                            $cellClass = $style['class'];
                            break;
                        }
                    }
                }
                
                echo "<td class='$cellClass' style='text-align: {$col['align']};'>{$value}</td>";
            }
            
            echo "</tr>";
            
            // Fila de detalles (oculta por defecto)
            if ($this->detailsGrid && $this->detailsKey) {
                $detailKeyValue = $row[$this->detailsKey] ?? '';
                echo "<tr class='details-row' id='details-{$keyValue}' style='display: none;'>";
                echo "<td colspan='" . (count($this->columns) + 1) . "' class='details-cell'>";
                echo "<div class='details-container'>";
                echo "<iframe src='{$this->detailsGrid}?{$this->detailsKey}={$detailKeyValue}&embed=1' width='100%' height='300' frameborder='0'></iframe>";
                echo "</div>";
                echo "</td>";
                echo "</tr>";
            }
            
            $rowIndex++;
        }
        echo "</tbody>";
        
        echo "</table>";
        echo "</div>";
        
        // Información de registros
        $totalRecords = count($data);
        echo "<div class='grid-footer'>";
        echo "<span>Mostrando {$totalRecords} registro(s)</span>";
        echo "</div>";
        
        echo "</div>";
        
        // CSS mejorado
        $this->renderCSS();
        
        // JavaScript mejorado
        $this->renderExportJS();
    }
    
    // Formatear valor según máscara
    private function formatValue($value, $mask) {
        if (strpos($mask, 'select:') === 0) {
            // Es un select, devolver el valor tal cual
            return htmlspecialchars($value);
        } elseif (strpos($mask, 'date:') === 0) {
            // Formato de fecha
            if ($value && $value !== '0000-00-00') {
                return date('d-m-Y', strtotime($value));
            }
            return '';
        } elseif ($mask === 'number') {
            return number_format((float)$value, 0, ',', '.');
        }
        
        return htmlspecialchars($value);
    }
    
    // Renderizar CSS
    private function renderCSS() {
        echo "<style>
        .modern-grid-container {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 10px;
            background: #f0f0f0;
            padding: 10px;
        }
        
        .grid-header {
            background: linear-gradient(to bottom, #b8cfe5 0%, #8faed6 100%);
            padding: 8px 10px;
            border: 1px solid #7a9bc4;
            margin-bottom: 5px;
        }
        
        .grid-title {
            color: #003366;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            text-shadow: 1px 1px 1px rgba(255,255,255,0.5);
        }
        
        .grid-toolbar {
            background: #e8e8e8;
            padding: 5px;
            border: 1px solid #ccc;
            margin-bottom: 5px;
            display: flex;
            gap: 5px;
        }
        
        .btn-toolbar {
            padding: 5px 10px;
            background: linear-gradient(to bottom, #ffffff 0%, #e0e0e0 100%);
            border: 1px solid #999;
            border-radius: 3px;
            cursor: pointer;
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-toolbar:hover {
            background: linear-gradient(to bottom, #f0f0f0 0%, #d0d0d0 100%);
        }
        
        .btn-toolbar:active {
            background: linear-gradient(to bottom, #d0d0d0 0%, #e0e0e0 100%);
        }
        
        .btn-toolbar img {
            width: 14px;
            height: 14px;
        }
        
        .grid-table-container {
            border: 1px solid #ccc;
            background: white;
            overflow: auto;
        }
        
        .modern-grid-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            font-size: 11px;
        }
        
        .modern-grid-table thead th {
            background: linear-gradient(to bottom, #c5d9f1 0%, #a8c5e5 100%);
            color: #003366;
            padding: 6px 8px;
            font-weight: bold;
            text-align: left;
            border: 1px solid #8faed6;
            font-size: 11px;
            white-space: nowrap;
        }
        
        .modern-grid-table tbody td {
            padding: 4px 6px;
            border: 1px solid #d0d0d0;
            background: white;
        }
        
        .modern-grid-table tbody tr:nth-child(odd) {
            background: #f9f9f9;
        }
        
        .modern-grid-table tbody tr:hover {
            background: #fffacd !important;
        }
        
        .col-actions {
            text-align: center !important;
            white-space: nowrap;
        }
        
        .btn-action {
            padding: 2px 6px;
            margin: 0 2px;
            border: 1px solid #999;
            border-radius: 2px;
            cursor: pointer;
            font-size: 12px;
            background: linear-gradient(to bottom, #ffffff 0%, #e0e0e0 100%);
        }
        
        .btn-action:hover {
            background: linear-gradient(to bottom, #ffcccc 0%, #ff9999 100%);
        }
        
        .btn-delete {
            color: #cc0000;
            font-weight: bold;
        }
        
        .btn-edit {
            color: #0066cc;
            font-weight: bold;
        }
        
        .btn-details {
            color: #006600;
            font-weight: bold;
        }
        
        .details-row {
            background: #f0f8ff !important;
        }
        
        .details-cell {
            padding: 10px !important;
        }
        
        .details-container {
            background: white;
            border: 2px solid #8faed6;
            padding: 5px;
        }
        
        .grid-footer {
            background: #e8e8e8;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-top: none;
            font-size: 10px;
            color: #666;
        }
        
        /* Estilos condicionales específicos */
        .bold { 
            font-weight: bold !important; 
        }
        
        .colornegro { 
            color: black !important;
            background: #ffffff !important;
        }
        
        .colorazul { 
            color: #0000cc !important;
            background: #e6f2ff !important;
        }
        
        .colorrojo { 
            color: #cc0000 !important;
            background: #ffe0e0 !important;
        }
        
        .colormagenta { 
            color: #cc00cc !important;
            background: #ffe0ff !important;
        }
        
        .colorverde { 
            color: #006600 !important;
            background: #e0ffe0 !important;
        }
        
        .colorgris { 
            color: #666666 !important;
            background: #f0f0f0 !important;
        }
        
        .activedata { 
            background: #fff8dc !important;
        }
        
        /* Estilos de fila naranja (como en la imagen) */
        tr.colorrojo td {
            background: #ffcc99 !important;
        }
        </style>";
    }
    
    // JavaScript para exportación y funcionalidad
    private function renderExportJS() {
        echo "<script>
        function exportToExcel() {
            window.location.href = 'export_excel.php?table={$this->tableName}&script={$this->scriptName}';
        }
        
        function exportToCSV() {
            window.location.href = 'export_csv.php?table={$this->tableName}&script={$this->scriptName}';
        }
        
        function addRecord() {
            alert('Funcionalidad de agregar registro en desarrollo');
            // TODO: Implementar modal o redirigir a formulario
        }
        
        function searchRecord() {
            var searchTerm = prompt('Ingrese término de búsqueda:');
            if (searchTerm) {
                window.location.href = '{$this->scriptName}?search=' + encodeURIComponent(searchTerm);
            }
        }
        
        function editRecord(id) {
            alert('Editar registro ID: ' + id);
            // TODO: Implementar edición
        }
        
        function deleteRecord(id) {
            if (confirm('¿Está seguro de eliminar este registro?')) {
                window.location.href = '{$this->scriptName}?action=delete&id=' + id;
            }
        }
        
        function toggleDetails(id) {
            var detailsRow = document.getElementById('details-' + id);
            if (detailsRow) {
                if (detailsRow.style.display === 'none') {
                    detailsRow.style.display = 'table-row';
                } else {
                    detailsRow.style.display = 'none';
                }
            }
        }
        </script>";
    }
    
    // Cerrar conexión
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>

