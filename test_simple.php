<?php
/**
 * Test Simple - Verifica que PHP y las rutas funcionen
 * Accede desde: http://localhost/farmapp/test_simple.php
 */

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Test Simple - FarmApp</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .success { background: #d4edda; padding: 15px; border-radius: 5px; color: #155724; margin: 10px 0; }
        .info { background: #d1ecf1; padding: 15px; border-radius: 5px; color: #0c5460; margin: 10px 0; }
        .error { background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24; margin: 10px 0; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>🔍 Test Simple - FarmApp</h1>";

echo "<div class='success'>
        <strong>✅ PHP está funcionando correctamente</strong><br>
        Versión PHP: " . phpversion() . "<br>
        Servidor: " . $_SERVER['SERVER_SOFTWARE'] . "
      </div>";

echo "<div class='info'>
        <strong>📂 Información del Sistema:</strong><br>
        Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>
        Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br>
        Request URI: " . $_SERVER['REQUEST_URI'] . "<br>
        Current Directory: " . __DIR__ . "
      </div>";

// Verificar si existe index.php
if (file_exists(__DIR__ . '/index.php')) {
    echo "<div class='success'>
            <strong>✅ index.php encontrado en la raíz</strong>
          </div>";
} else {
    echo "<div class='error'>
            <strong>❌ index.php NO encontrado en la raíz</strong><br>
            Buscado en: " . __DIR__ . "/index.php
          </div>";
}

// Verificar si existe public/index.php
if (file_exists(__DIR__ . '/public/index.php')) {
    echo "<div class='success'>
            <strong>✅ public/index.php encontrado</strong>
          </div>";
} else {
    echo "<div class='error'>
            <strong>❌ public/index.php NO encontrado</strong>
          </div>";
}

// Verificar configuración
if (file_exists(__DIR__ . '/config/config.php')) {
    echo "<div class='success'>
            <strong>✅ config/config.php encontrado</strong>
          </div>";
    
    // Intentar cargar la configuración
    try {
        require_once __DIR__ . '/config/config.php';
        echo "<div class='success'>
                <strong>✅ Configuración cargada correctamente</strong><br>
                BASE_URL: " . (defined('BASE_URL') ? BASE_URL : 'No definido') . "
              </div>";
    } catch (Exception $e) {
        echo "<div class='error'>
                <strong>❌ Error al cargar configuración:</strong><br>
                " . htmlspecialchars($e->getMessage()) . "
              </div>";
    }
} else {
    echo "<div class='error'>
            <strong>❌ config/config.php NO encontrado</strong>
          </div>";
}

echo "<div class='info'>
        <strong>🔗 Enlaces de Prueba:</strong><br>
        <a href='index.php'>Ir a index.php</a><br>
        <a href='index.php?action=login'>Ir a login</a><br>
        <a href='public/index.php?action=login'>Ir a public/index.php?action=login</a>
      </div>";

echo "</body></html>";
?>

