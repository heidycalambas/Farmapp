<?php
/**
 * Crear/Corregir Usuarios de Prueba
 * Accede desde: http://localhost/farmapp/crear_usuarios_prueba.php
 * 
 * Este script crea o actualiza los usuarios de prueba con las contraseñas correctas
 */

require_once __DIR__ . '/config/config.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Crear Usuarios de Prueba - FarmApp</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; max-width: 800px; margin: 0 auto; }
        .success { background: #d4edda; padding: 15px; border-radius: 5px; color: #155724; margin: 10px 0; }
        .error { background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24; margin: 10px 0; }
        .info { background: #d1ecf1; padding: 15px; border-radius: 5px; color: #0c5460; margin: 10px 0; }
        .btn { display: inline-block; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px 10px 0; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>👥 Crear/Corregir Usuarios de Prueba</h1>";

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    // Hash de la contraseña '123456'
    // Este es el mismo hash que está en el archivo SQL
    $passwordHash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
    
    // Verificar que el hash funciona
    if (!password_verify('123456', $passwordHash)) {
        // Si el hash del SQL no funciona, generar uno nuevo
        $passwordHash = password_hash('123456', PASSWORD_DEFAULT);
        echo "<div class='info'>
                <strong>ℹ️ Generando nuevo hash para la contraseña '123456'</strong>
              </div>";
    }
    
    // Usuarios de prueba
    $usuarios = [
        [
            'id' => 1,
            'nombre' => 'Administrador',
            'email' => 'admin@mail.com',
            'password' => $passwordHash,
            'telefono' => '1234567890',
            'direccion' => 'Calle Admin 123',
            'rol_id' => 1, // Administrador
            'activo' => 1
        ],
        [
            'id' => 2,
            'nombre' => 'Farmacéutico',
            'email' => 'farma@mail.com',
            'password' => $passwordHash,
            'telefono' => '0987654321',
            'direccion' => 'Calle Farma 456',
            'rol_id' => 2, // Farmacéutico
            'activo' => 1
        ],
        [
            'id' => 3,
            'nombre' => 'Cliente Test',
            'email' => 'cliente@mail.com',
            'password' => $passwordHash,
            'telefono' => '5555555555',
            'direccion' => 'Calle Cliente 789',
            'rol_id' => 3, // Cliente
            'activo' => 1
        ]
    ];
    
    echo "<div class='info'>
            <strong>📝 Creando/Actualizando usuarios de prueba...</strong>
          </div>";
    
    $creados = 0;
    $actualizados = 0;
    $errores = 0;
    
    foreach ($usuarios as $usuario) {
        try {
            // Verificar si el usuario existe
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE id = ? OR email = ?");
            $stmt->execute([$usuario['id'], $usuario['email']]);
            $existe = $stmt->fetch();
            
            if ($existe) {
                // Actualizar usuario existente
                $stmt = $conn->prepare("
                    UPDATE usuarios 
                    SET nombre = ?, email = ?, password = ?, telefono = ?, direccion = ?, rol_id = ?, activo = ?
                    WHERE id = ?
                ");
                $stmt->execute([
                    $usuario['nombre'],
                    $usuario['email'],
                    $usuario['password'],
                    $usuario['telefono'],
                    $usuario['direccion'],
                    $usuario['rol_id'],
                    $usuario['activo'],
                    $usuario['id']
                ]);
                $actualizados++;
                echo "<div class='success'>
                        <strong>✅ Actualizado:</strong> {$usuario['email']} (ID: {$usuario['id']})
                      </div>";
            } else {
                // Crear nuevo usuario
                $stmt = $conn->prepare("
                    INSERT INTO usuarios (id, nombre, email, password, telefono, direccion, rol_id, activo)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $usuario['id'],
                    $usuario['nombre'],
                    $usuario['email'],
                    $usuario['password'],
                    $usuario['telefono'],
                    $usuario['direccion'],
                    $usuario['rol_id'],
                    $usuario['activo']
                ]);
                $creados++;
                echo "<div class='success'>
                        <strong>✅ Creado:</strong> {$usuario['email']} (ID: {$usuario['id']})
                      </div>";
            }
        } catch (PDOException $e) {
            $errores++;
            echo "<div class='error'>
                    <strong>❌ Error con {$usuario['email']}:</strong><br>
                    " . htmlspecialchars($e->getMessage()) . "
                  </div>";
        }
    }
    
    echo "<div class='info'>
            <strong>📊 Resumen:</strong><br>
            ✅ Creados: $creados<br>
            ✅ Actualizados: $actualizados<br>
            ❌ Errores: $errores
          </div>";
    
    if ($errores == 0) {
        echo "<div class='success'>
                <strong>✅ ¡Usuarios de prueba listos!</strong><br><br>
                <strong>Credenciales:</strong><br>
                <strong>Administrador:</strong> admin@mail.com / 123456<br>
                <strong>Farmacéutico:</strong> farma@mail.com / 123456<br>
                <strong>Cliente:</strong> cliente@mail.com / 123456
              </div>";
        
        echo "<a href='" . BASE_URL . "/index.php?action=login' class='btn'>🚀 Ir al Login</a>";
        echo "<a href='" . BASE_URL . "/verificar_usuarios.php' class='btn'>🔍 Verificar Usuarios</a>";
    }
    
} catch (Exception $e) {
    echo "<div class='error'>
            <strong>❌ Error:</strong><br>
            " . htmlspecialchars($e->getMessage()) . "
          </div>";
    
    echo "<div class='info'>
            <strong>🔧 Posibles soluciones:</strong><br>
            1. Verifica que la base de datos 'farmapp' exista<br>
            2. Verifica que las tablas 'usuarios' y 'roles' existan<br>
            3. Asegúrate de haber importado el archivo SQL completo<br>
            4. Revisa que los roles existan (1=Admin, 2=Farmacéutico, 3=Cliente)
          </div>";
}

echo "    </div>
</body>
</html>";
?>

