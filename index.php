<?php
/**
 * Punto de Entrada Principal desde la Raíz
 * FarmApp - Incluye directamente public/index.php
 */

// Cambiar al directorio public para mantener rutas relativas correctas
chdir(__DIR__ . '/public');

// Incluir el punto de entrada principal
require_once __DIR__ . '/public/index.php';

