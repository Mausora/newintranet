<?php
/*
  Proyecto: intranet iContel
  Archivo: test_db.php
  Descripción: Test de conexión a base de datos para ModernGrid
  Versión: 1.0.0
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ============================================
// CONFIGURACIÓN - AJUSTAR SEGÚN TU SERVIDOR
// ============================================
$dbHost = "172.16.10.15";  // Cambiar a "localhost" en producción
$dbUser = "data_studio";    // Tu usuario MySQL
$dbPass = "1Ngr3s0.,";      // Tu contraseña MySQL
$dbName = "tnasolut_factibilidades";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Base de Datos - ModernGrid</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th {
            background: #34495e;
            color: white;
            padding: 8px;
            text-align: left;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔌 Test de Conexión a Base de Datos</h1>
        <p>Verificando conexión y estructura de la base de datos para ModernGrid.</p>
        
        <div class="test-item info">
            <strong>📋 Configuración Actual:</strong><br>
            Host: <code><?php echo $dbHost; ?></code><br>
            Usuario: <code><?php echo $dbUser; ?></code><br>
            Base de Datos: <code><?php echo $dbName; ?></code>
        </div>
        
        <h2>🔍 Tests de Conexión</h2>
        
        <?php
        $allTestsPassed = true;
        $conn = null;
        
        // Test 1: Verificar extensión mysqli
        echo '<div class="test-item ';
        if (extension_loaded('mysqli')) {
            echo 'success"><span class="icon">✅</span><strong>Test 1:</strong> Extensión mysqli instalada';
        } else {
            echo 'error"><span class="icon">❌</span><strong>Test 1:</strong> Extensión mysqli NO instalada';
            $allTestsPassed = false;
        }
        echo '</div>';
        
        // Test 2: Intentar conexión
        echo '<div class="test-item ';
        try {
            $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
            
            if ($conn->connect_error) {
                echo 'error"><span class="icon">❌</span><strong>Test 2:</strong> Error de conexión<br>';
                echo '<code>' . $conn->connect_error . '</code>';
                $allTestsPassed = false;
            } else {
                echo 'success"><span class="icon">✅</span><strong>Test 2:</strong> Conexión exitosa a la base de datos';
                $conn->set_charset('utf8');
            }
        } catch (Exception $e) {
            echo 'error"><span class="icon">❌</span><strong>Test 2:</strong> Excepción durante conexión<br>';
            echo '<code>' . $e->getMessage() . '</code>';
            $allTestsPassed = false;
        }
        echo '</div>';
        
        if ($conn && !$conn->connect_error) {
            // Test 3: Verificar tabla cabecera
            echo '<div class="test-item ';
            $result = $conn->query("SELECT COUNT(*) as total FROM cabecera");
            if ($result) {
                $row = $result->fetch_assoc();
                $totalCabecera = $row['total'];
                echo 'success"><span class="icon">✅</span><strong>Test 3:</strong> Tabla <code>cabecera</code> accesible<br>';
                echo '<span style="margin-left: 30px;">📊 Total de registros: <strong>' . $totalCabecera . '</strong></span>';
            } else {
                echo 'error"><span class="icon">❌</span><strong>Test 3:</strong> No se puede acceder a tabla <code>cabecera</code><br>';
                echo '<code>' . $conn->error . '</code>';
                $allTestsPassed = false;
            }
            echo '</div>';
            
            // Test 4: Verificar tabla detalle
            echo '<div class="test-item ';
            $result = $conn->query("SELECT COUNT(*) as total FROM detalle");
            if ($result) {
                $row = $result->fetch_assoc();
                $totalDetalle = $row['total'];
                echo 'success"><span class="icon">✅</span><strong>Test 4:</strong> Tabla <code>detalle</code> accesible<br>';
                echo '<span style="margin-left: 30px;">📊 Total de registros: <strong>' . $totalDetalle . '</strong></span>';
            } else {
                echo 'error"><span class="icon">❌</span><strong>Test 4:</strong> No se puede acceder a tabla <code>detalle</code><br>';
                echo '<code>' . $conn->error . '</code>';
                $allTestsPassed = false;
            }
            echo '</div>';
            
            // Test 5: Obtener datos de muestra
            echo '<div class="test-item ';
            $result = $conn->query("SELECT fac, estado, nombre, rut FROM cabecera ORDER BY fac DESC LIMIT 5");
            if ($result && $result->num_rows > 0) {
                echo 'success"><span class="icon">✅</span><strong>Test 5:</strong> Datos de muestra de <code>cabecera</code><br>';
                echo '<div style="margin-left: 30px; margin-top: 10px; overflow-x: auto;">';
                echo '<table>';
                echo '<tr><th>FAC</th><th>Estado</th><th>Nombre</th><th>RUT</th></tr>';
                
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['fac']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['estado']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['nombre']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['rut']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '</div>';
            } else {
                echo 'warning"><span class="icon">⚠️</span><strong>Test 5:</strong> No hay datos en tabla <code>cabecera</code>';
            }
            echo '</div>';
            
            $conn->close();
        }
        ?>
        
        <h2>📊 Resultado Final</h2>
        
        <?php if ($allTestsPassed): ?>
            <div class="test-item success">
                <h3 style="margin: 0;">
                    <span class="icon">🎉</span>
                    ¡Base de Datos Configurada Correctamente!
                </h3>
                <p style="margin-top: 10px;">Todos los tests pasaron exitosamente.</p>
                <p><strong>Siguiente paso:</strong> Probar ModernGrid completo:</p>
                <ul>
                    <li><a href="cabecera_modern.php" target="_blank">cabecera_modern.php</a></li>
                    <li><a href="test_moderngrid.php" target="_blank">test_moderngrid.php</a></li>
                </ul>
            </div>
        <?php else: ?>
            <div class="test-item error">
                <h3 style="margin: 0;">
                    <span class="icon">⚠️</span>
                    Problemas de Conexión Detectados
                </h3>
                <p style="margin-top: 10px;">Revisa los errores arriba y ajusta la configuración.</p>
            </div>
        <?php endif; ?>
        
        <div style="margin-top: 30px; padding: 15px; background: #f0f0f0; border-radius: 5px;">
            <p style="margin: 0; font-size: 12px; color: #666;">
                <strong>Proyecto:</strong> intranet iContel | 
                <strong>Fecha:</strong> <?php echo date('Y-m-d H:i:s'); ?>
            </p>
        </div>
    </div>
</body>
</html>
