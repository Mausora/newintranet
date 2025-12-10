<?php
/*
  Proyecto: intranet iContel
  Archivo: test_moderngrid.php
  Descripción: Test de instalación de ModernGrid
  Versión: 1.0.0
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test ModernGrid - Instalación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        h2 {
            color: #34495e;
            margin-top: 30px;
        }
        .test-item {
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #ccc;
            background: #f9f9f9;
        }
        .success {
            border-left-color: #27ae60;
            background: #d4edda;
            color: #155724;
        }
        .error {
            border-left-color: #e74c3c;
            background: #f8d7da;
            color: #721c24;
        }
        .warning {
            border-left-color: #f39c12;
            background: #fff3cd;
            color: #856404;
        }
        .info {
            border-left-color: #3498db;
            background: #d1ecf1;
            color: #0c5460;
        }
        .icon {
            font-size: 18px;
            font-weight: bold;
            margin-right: 10px;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test de Instalación - ModernGrid</h1>
        <p>Esta página verifica que todos los componentes necesarios estén instalados correctamente.</p>
        
        <h2>📋 Tests Básicos</h2>
        
        <?php
        $allTestsPassed = true;
        
        // Test 1: Verificar PHP Version
        echo '<div class="test-item ';
        $phpVersion = phpversion();
        if (version_compare($phpVersion, '7.4.0', '>=')) {
            echo 'success"><span class="icon">✅</span><strong>Test 1:</strong> Versión de PHP: <code>' . $phpVersion . '</code> (Compatible)';
        } else {
            echo 'error"><span class="icon">❌</span><strong>Test 1:</strong> Versión de PHP: <code>' . $phpVersion . '</code> (Requiere 7.4+)';
            $allTestsPassed = false;
        }
        echo '</div>';
        
        // Test 2: Verificar ModernGrid.php
        echo '<div class="test-item ';
        if (file_exists('./lib/ModernGrid.php')) {
            echo 'success"><span class="icon">✅</span><strong>Test 2:</strong> Archivo <code>lib/ModernGrid.php</code> encontrado';
        } else {
            echo 'error"><span class="icon">❌</span><strong>Test 2:</strong> Archivo <code>lib/ModernGrid.php</code> NO encontrado';
            $allTestsPassed = false;
        }
        echo '</div>';
        
        // Test 3: Cargar clase ModernGrid
        echo '<div class="test-item ';
        try {
            require_once('./lib/ModernGrid.php');
            echo 'success"><span class="icon">✅</span><strong>Test 3:</strong> Clase ModernGrid cargada correctamente';
        } catch (Exception $e) {
            echo 'error"><span class="icon">❌</span><strong>Test 3:</strong> Error cargando ModernGrid: ' . $e->getMessage();
            $allTestsPassed = false;
        }
        echo '</div>';
        
        // Test 4: Crear instancia
        echo '<div class="test-item ';
        try {
            $grid = new ModernGrid('test.php', '1');
            echo 'success"><span class="icon">✅</span><strong>Test 4:</strong> Instancia de ModernGrid creada correctamente';
        } catch (Exception $e) {
            echo 'error"><span class="icon">❌</span><strong>Test 4:</strong> Error creando instancia: ' . $e->getMessage();
            $allTestsPassed = false;
        }
        echo '</div>';
        
        // Test 5: Verificar ExcelExporter.php
        echo '<div class="test-item ';
        if (file_exists('./lib/ExcelExporter.php')) {
            echo 'success"><span class="icon">✅</span><strong>Test 5:</strong> Archivo <code>lib/ExcelExporter.php</code> encontrado';
        } else {
            echo 'warning"><span class="icon">⚠️</span><strong>Test 5:</strong> Archivo <code>lib/ExcelExporter.php</code> NO encontrado (exportación Excel no funcionará)';
        }
        echo '</div>';
        
        // Test 6: Verificar vendor/autoload.php (PhpSpreadsheet)
        echo '<div class="test-item ';
        if (file_exists('../vendor/autoload.php')) {
            echo 'success"><span class="icon">✅</span><strong>Test 6:</strong> PhpSpreadsheet instalado (vendor/autoload.php encontrado)';
        } else {
            echo 'warning"><span class="icon">⚠️</span><strong>Test 6:</strong> PhpSpreadsheet NO instalado<br>';
            echo '<span style="margin-left: 30px;">Para instalar, ejecuta en el servidor:</span><br>';
            echo '<code style="display: block; margin-left: 30px; margin-top: 5px;">cd /path/to/intranet && composer require phpoffice/phpspreadsheet</code>';
        }
        echo '</div>';
        
        // Test 7: Verificar archivos modernizados
        echo '<div class="test-item ';
        $modernFiles = [
            'cabecera_modern.php' => 'Cabecera modernizada',
            'detalles_modern.php' => 'Detalles modernizados',
            'export_excel.php' => 'Script de exportación'
        ];
        
        $allModernFilesExist = true;
        foreach ($modernFiles as $file => $desc) {
            if (!file_exists('./' . $file)) {
                $allModernFilesExist = false;
                break;
            }
        }
        
        if ($allModernFilesExist) {
            echo 'success"><span class="icon">✅</span><strong>Test 7:</strong> Archivos modernizados encontrados:<br>';
            foreach ($modernFiles as $file => $desc) {
                echo '<span style="margin-left: 30px;">✓ ' . $file . ' (' . $desc . ')</span><br>';
            }
        } else {
            echo 'error"><span class="icon">❌</span><strong>Test 7:</strong> Faltan archivos modernizados:<br>';
            foreach ($modernFiles as $file => $desc) {
                $exists = file_exists('./' . $file);
                echo '<span style="margin-left: 30px;">' . ($exists ? '✓' : '✗') . ' ' . $file . '</span><br>';
            }
            $allTestsPassed = false;
        }
        echo '</div>';
        
        // Test 8: Extensiones PHP necesarias
        echo '<div class="test-item ';
        $requiredExtensions = ['mysqli', 'zip', 'xml', 'gd'];
        $missingExtensions = [];
        
        foreach ($requiredExtensions as $ext) {
            if (!extension_loaded($ext)) {
                $missingExtensions[] = $ext;
            }
        }
        
        if (empty($missingExtensions)) {
            echo 'success"><span class="icon">✅</span><strong>Test 8:</strong> Extensiones PHP requeridas instaladas';
        } else {
            echo 'warning"><span class="icon">⚠️</span><strong>Test 8:</strong> Faltan extensiones PHP: <code>' . implode(', ', $missingExtensions) . '</code>';
        }
        echo '</div>';
        
        ?>
        
        <h2>📊 Resultado Final</h2>
        
        <?php if ($allTestsPassed): ?>
            <div class="test-item success">
                <h3 style="margin: 0;">
                    <span class="icon">🎉</span>
                    ¡Instalación Completa y Correcta!
                </h3>
                <p style="margin-top: 10px;">Todos los tests críticos pasaron exitosamente.</p>
                <p><strong>Siguiente paso:</strong> Probar el grid completo en:</p>
                <ul>
                    <li><a href="cabecera_modern.php" target="_blank">cabecera_modern.php</a></li>
                    <li><a href="test_db.php" target="_blank">test_db.php</a> (test de conexión a BD)</li>
                </ul>
            </div>
        <?php else: ?>
            <div class="test-item error">
                <h3 style="margin: 0;">
                    <span class="icon">⚠️</span>
                    Instalación Incompleta
                </h3>
                <p style="margin-top: 10px;">Algunos tests fallaron. Revisa los errores arriba.</p>
            </div>
        <?php endif; ?>
        
        <h2>ℹ️ Información del Sistema</h2>
        <div class="test-item info">
            <strong>PHP:</strong> <?php echo PHP_VERSION; ?><br>
            <strong>Directorio:</strong> <?php echo __DIR__; ?><br>
            <strong>Fecha:</strong> <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>
</body>
</html>
