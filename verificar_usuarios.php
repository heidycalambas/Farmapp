<?php
/**
 * Verificar Usuarios de Prueba
 * Accede desde: http://localhost/farmapp/verificar_usuarios.php
 */

require_once __DIR__ . '/config/config.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Verificar Usuarios - FarmApp</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; max-width: 900px; margin: 0 auto; }
        .success { background: #d4edda; padding: 15px; border-radius: 5px; color: #155724; margin: 10px 0; }
        .error { background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24; margin: 10px 0; }
        .info { background: #d1ecf1; padding: 15px; border-radius: 5px; color: #0c5460; margin: 10px 0; }
        .warning { background: #fff3cd; padding: 15px; border-radius: 5px; color: #856404; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #4CAF50; color: white; }
        .btn { display: inline-block; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px 10px 0; }
        .btn:hover { background: #45a049; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>👥 Verificación de Usuarios de Prueba</h1>";

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    // Verificar si existen usuarios
    $stmt = $conn->query("SELECT COUNT(*) as total FROM usuarios");
    $totalUsuarios = $stmt->fetch()['total'];
    
    echo "<div class='info'>
            <strong>📊 Total de usuarios en la base de datos:</strong> $totalUsuarios
          </div>";
    
    if ($totalUsuarios == 0) {
        echo "<div class='error'>
                <strong>❌ No hay usuarios en la base de datos</strong><br>
                Necesitas importar el archivo SQL con los datos de prueba.
              </div>";
        
        echo "<div class='warning'>
                <strong>🔧 Solución:</strong><br>
                1. Abre MySQL Workbench<br>
                2. Selecciona la base de datos 'farmapp'<br>
                3. Ve a: <strong>Server → Data Import</strong><br>
                4. Selecciona: <code>database/farmapp.sql</code><br>
                5. Haz clic en <strong>Start Import</strong>
              </div>";
    } else {
        // Mostrar usuarios existentes
        $stmt = $conn->query("
            SELECT u.id, u.nombre, u.email, u.rol_id, r.nombre as rol, u.activo
            FROM usuarios u 
            JOIN roles r ON u.rol_id = r.id 
            ORDER BY u.id
        ");
        $usuarios = $stmt->fetchAll();
        
        echo "<h2>Usuarios en la Base de Datos</h2>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Estado</th><th>Acción</th></tr>";
        
        $usuariosEsperados = [
            'admin@mail.com' => 'Administrador',
            'farma@mail.com' => 'Farmacéutico',
            'cliente@mail.com' => 'Cliente'
        ];
        
        $usuariosEncontrados = [];
        
        foreach ($usuarios as $usuario) {
            $estado = $usuario['activo'] ? '✅ Activo' : '❌ Inactivo';
            echo "<tr>";
            echo "<td>{$usuario['id']}</td>";
            echo "<td>{$usuario['nombre']}</td>";
            echo "<td>{$usuario['email']}</td>";
            echo "<td>{$usuario['rol']}</td>";
            echo "<td>$estado</td>";
            echo "<td>";
            
            if (isset($usuariosEsperados[$usuario['email']])) {
                echo "✅ Correcto";
                $usuariosEncontrados[] = $usuario['email'];
            } else {
                echo "⚠️ No es usuario de prueba";
            }
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        // Verificar si faltan usuarios
        $faltantes = array_diff(array_keys($usuariosEsperados), $usuariosEncontrados);
        
        if (empty($faltantes)) {
            echo "<div class='success'>
                    <strong>✅ Todos los usuarios de prueba están presentes</strong>
                  </div>";
            
            // Verificar contraseñas
            echo "<h2>🔐 Verificación de Contraseñas</h2>";
            
            $passwordTest = '123456';
            $stmt = $conn->prepare("SELECT password FROM usuarios WHERE email = ?");
            
            foreach ($usuariosEsperados as $email => $rol) {
                $stmt->execute([$email]);
                $user = $stmt->fetch();
                
                if ($user) {
                    if (password_verify($passwordTest, $user['password'])) {
                        echo "<div class='success'>
                                <strong>✅ $email:</strong> Contraseña correcta (123456)
                              </div>";
                    } else {
                        echo "<div class='error'>
                                <strong>❌ $email:</strong> La contraseña NO coincide con '123456'<br>
                                El hash en la BD no es correcto. Necesitas reimportar el SQL.
                              </div>";
                    }
                }
            }
            
            echo "<div class='info'>
                    <strong>💡 Credenciales de Prueba:</strong><br>
                    <strong>Administrador:</strong> admin@mail.com / 123456<br>
                    <strong>Farmacéutico:</strong> farma@mail.com / 123456<br>
                    <strong>Cliente:</strong> cliente@mail.com / 123456
                  </div>";
            
            echo "<a href='" . BASE_URL . "/index.php?action=login' class='btn'>🚀 Ir al Login</a>";
            
        } else {
            echo "<div class='warning'>
                    <strong>⚠️ Faltan usuarios de prueba:</strong><br>";
            foreach ($faltantes as $email) {
                echo "- $email<br>";
            }
            echo "</div>";
            
            echo "<div class='info'>
                    <strong>🔧 Solución:</strong> Reimporta el archivo <code>database/farmapp.sql</code> en MySQL Workbench
                  </div>";
        }
    }
    
    // Verificar tablas
    echo "<h2>📋 Verificación de Tablas</h2>";
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $tablasEsperadas = ['roles', 'usuarios', 'categorias', 'productos', 'inventario', 'pedidos', 'detalle_pedidos'];
    $tablasFaltantes = array_diff($tablasEsperadas, $tables);
    
    if (empty($tablasFaltantes)) {
        echo "<div class='success'>
                <strong>✅ Todas las tablas principales existen</strong><br>
                Total de tablas: " . count($tables) . "
              </div>";
    } else {
        echo "<div class='error'>
                <strong>❌ Faltan tablas importantes:</strong><br>";
        foreach ($tablasFaltantes as $tabla) {
            echo "- $tabla<br>";
        }
        echo "</div>";
        echo "<div class='warning'>
                <strong>🔧 Solución:</strong> Importa el archivo <code>database/farmapp.sql</code> completo
              </div>";
    }
    
} catch (Exception $e) {
    echo "<div class='error'>
            <strong>❌ Error:</strong><br>
            " . htmlspecialchars($e->getMessage()) . "
          </div>";
}

echo "    </div>
</body>
</html>";
?>

