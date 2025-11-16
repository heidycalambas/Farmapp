<?php
/**
 * Test de Conexión MySQL - Diagnóstico
 * Accede desde: http://localhost/farmapp/test_mysql.php
 */

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Test MySQL - FarmApp</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .success { background: #d4edda; padding: 15px; border-radius: 5px; color: #155724; margin: 10px 0; }
        .error { background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24; margin: 10px 0; }
        .info { background: #d1ecf1; padding: 15px; border-radius: 5px; color: #0c5460; margin: 10px 0; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>🔍 Test de Conexión MySQL</h1>";

// Test 1: Sin contraseña
echo "<h2>Test 1: Conexión sin contraseña</h2>";
try {
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    echo "<div class='success'>
            <strong>✅ Conexión exitosa sin contraseña</strong><br>
            MySQL acepta conexiones sin contraseña para el usuario 'root'
          </div>";
    
    // Verificar si existe la base de datos
    $stmt = $pdo->query("SHOW DATABASES LIKE 'farmapp'");
    if ($stmt->rowCount() > 0) {
        echo "<div class='success'>
                <strong>✅ Base de datos 'farmapp' encontrada</strong>
              </div>";
        
        // Intentar conectar a la base de datos
        try {
            $pdo_db = new PDO('mysql:host=localhost;dbname=farmapp', 'root', '');
            $stmt = $pdo_db->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo "<div class='success'>
                    <strong>✅ Conexión a 'farmapp' exitosa</strong><br>
                    Tablas encontradas: " . count($tables) . "
                  </div>";
        } catch (PDOException $e) {
            echo "<div class='error'>
                    <strong>❌ Error al conectar a 'farmapp':</strong><br>
                    " . htmlspecialchars($e->getMessage()) . "
                  </div>";
        }
    } else {
        echo "<div class='error'>
                <strong>❌ Base de datos 'farmapp' NO encontrada</strong><br>
                Necesitas crearla en MySQL Workbench
              </div>";
    }
    
} catch (PDOException $e) {
    echo "<div class='error'>
            <strong>❌ Error sin contraseña:</strong><br>
            " . htmlspecialchars($e->getMessage()) . "
          </div>";
    
    // Test 2: Con contraseña común 'root'
    echo "<h2>Test 2: Conexión con contraseña 'root'</h2>";
    try {
        $pdo = new PDO('mysql:host=localhost', 'root', 'root');
        echo "<div class='success'>
                <strong>✅ Conexión exitosa con contraseña 'root'</strong><br>
                MySQL requiere contraseña. Usa 'root' como contraseña.
              </div>";
        echo "<div class='info'>
                <strong>💡 Solución:</strong> Edita config/database.php y cambia:<br>
                <code>'password' => 'root',</code>
              </div>";
    } catch (PDOException $e2) {
        echo "<div class='error'>
                <strong>❌ Error con contraseña 'root':</strong><br>
                " . htmlspecialchars($e2->getMessage()) . "
              </div>";
        
        // Test 3: Con contraseña vacía pero especificada
        echo "<h2>Test 3: Otras posibilidades</h2>";
        echo "<div class='info'>
                <strong>🔧 Posibles soluciones:</strong><br>
                1. Verifica que MySQL esté corriendo en XAMPP<br>
                2. Abre MySQL Workbench y verifica qué contraseña usas<br>
                3. Si no tienes contraseña, puede que necesites resetearla<br>
                4. Revisa el archivo SOLUCION_MYSQL.md para más opciones
              </div>";
    }
}

echo "<div class='info'>
        <strong>📝 Próximos pasos:</strong><br>
        1. Si el Test 1 funcionó: Tu configuración actual debería funcionar<br>
        2. Si el Test 2 funcionó: Cambia la contraseña en config/database.php<br>
        3. Si nada funcionó: Revisa SOLUCION_MYSQL.md para más opciones
      </div>";

echo "</body></html>";
?>

