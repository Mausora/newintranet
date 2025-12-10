<?php
/*
  Proyecto: intranet iContel
  Archivo: ExcelExporter.php
  Descripción: Exportador de datos a Excel usando PhpSpreadsheet
  Autor: Emergent AI - Mauricio Araneda
  Versión: 1.0.0
  Fecha: 2025-01-10
  
  Requiere: composer require phpoffice/phpspreadsheet
*/

require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExcelExporter {
    
    private $conn;
    private $tableName;
    private $columns;
    private $title;
    private $masterField = null;
    private $masterValue = null;
    
    public function __construct($host, $user, $pass, $database) {
        $this->conn = new mysqli($host, $user, $pass, $database);
        
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
        
        $this->conn->set_charset('utf8');
    }
    
    public function setTable($tableName) {
        $this->tableName = $tableName;
    }
    
    public function setColumns($columns) {
        $this->columns = $columns;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function setMasterFilter($field, $value) {
        $this->masterField = $field;
        $this->masterValue = $value;
    }
    
    public function export($filename = 'export.xlsx') {
        // Crear nuevo documento
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Título
        if ($this->title) {
            $sheet->setCellValue('A1', $this->title);
            $sheet->mergeCells('A1:' . $this->getColumnLetter(count($this->columns)) . '1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $currentRow = 3;
        } else {
            $currentRow = 1;
        }
        
        // Cabeceras
        $col = 0;
        foreach ($this->columns as $column) {
            $cellAddress = $this->getColumnLetter($col) . $currentRow;
            $sheet->setCellValue($cellAddress, $column['label']);
            
            // Estilo de cabecera
            $sheet->getStyle($cellAddress)->getFont()->setBold(true);
            $sheet->getStyle($cellAddress)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('2c3e50');
            $sheet->getStyle($cellAddress)->getFont()->getColor()->setRGB('FFFFFF');
            $sheet->getStyle($cellAddress)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            
            // Ancho de columna
            $sheet->getColumnDimension($this->getColumnLetter($col))->setWidth(15);
            
            $col++;
        }
        
        $currentRow++;
        
        // Obtener datos
        $data = $this->getData();
        
        // Llenar datos
        foreach ($data as $row) {
            $col = 0;
            foreach ($this->columns as $colName => $column) {
                $value = $row[$colName] ?? '';
                
                // Formatear valor
                $value = $this->formatValue($value, $column['mask']);
                
                $cellAddress = $this->getColumnLetter($col) . $currentRow;
                $sheet->setCellValue($cellAddress, $value);
                
                // Alineación
                $alignment = Alignment::HORIZONTAL_LEFT;
                if ($column['align'] === 'center') {
                    $alignment = Alignment::HORIZONTAL_CENTER;
                } elseif ($column['align'] === 'right') {
                    $alignment = Alignment::HORIZONTAL_RIGHT;
                }
                $sheet->getStyle($cellAddress)->getAlignment()->setHorizontal($alignment);
                
                $col++;
            }
            $currentRow++;
        }
        
        // Bordes
        $lastCol = $this->getColumnLetter(count($this->columns) - 1);
        $lastRow = $currentRow - 1;
        $startRow = $this->title ? 3 : 1;
        
        $sheet->getStyle("A{$startRow}:{$lastCol}{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        
        // Autoajustar columnas
        foreach (range(0, count($this->columns) - 1) as $col) {
            $sheet->getColumnDimension($this->getColumnLetter($col))->setAutoSize(true);
        }
        
        // Descargar archivo
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    
    private function getData() {
        $sql = "SELECT * FROM `{$this->tableName}`";
        
        // Filtro maestro
        if ($this->masterField && $this->masterValue) {
            $sql .= " WHERE `{$this->masterField}` = '" . $this->conn->real_escape_string($this->masterValue) . "'";
        }
        
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
    
    private function formatValue($value, $mask) {
        if (strpos($mask, 'date:') === 0) {
            if ($value && $value !== '0000-00-00') {
                return date('d-m-Y', strtotime($value));
            }
            return '';
        } elseif ($mask === 'number') {
            return number_format((float)$value, 0, ',', '.');
        }
        
        return $value;
    }
    
    private function getColumnLetter($index) {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($index < 26) {
            return $letters[$index];
        }
        
        $first = floor($index / 26) - 1;
        $second = $index % 26;
        
        return $letters[$first] . $letters[$second];
    }
    
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
