# 🚀 Siguiente Paso: Subir a InfinityFree

## ✅ Estado Actual

- ✅ Conexión a MySQL funcionando
- ✅ Base de datos creada
- ⚠️ Usuarios de prueba necesitan verificación

---

## 📋 Paso 1: Verificar y Corregir Usuarios de Prueba

### 1.1. Ejecutar Verificación

Abre en tu navegador:
```
http://localhost/farmapp/verificar_usuarios.php
```

Este script te dirá:
- ✅ Si los usuarios existen
- ✅ Si las contraseñas están correctas
- ❌ Qué falta o está mal

### 1.2. Si los usuarios NO existen o están mal:

**Opción A: Reimportar el SQL completo**

1. Abre **MySQL Workbench**
2. Selecciona la base de datos `farmapp`
3. **IMPORTANTE:** Primero elimina las tablas existentes:
   - Clic derecho en `farmapp` → **Drop Schema...** → **Drop Now**
   - O elimina las tablas manualmente
4. Crea la base de datos de nuevo:
   ```sql
   CREATE DATABASE farmapp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
5. Ve a: **Server → Data Import**
6. Selecciona: **Import from Self-Contained File**
7. Busca: `C:\farmapp\database\farmapp.sql`
8. En **Default Target Schema**, selecciona `farmapp`
9. Haz clic en **Start Import**
10. ✅ Espera a que termine

**Opción B: Insertar usuarios manualmente**

Si solo faltan los usuarios, ejecuta esto en MySQL Workbench:

```sql
USE farmapp;

-- Insertar usuarios de prueba (password: 123456)
INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `telefono`, `direccion`, `rol_id`, `activo`) VALUES
(1, 'Administrador', 'admin@mail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1234567890', 'Calle Admin 123', 1, 1),
(2, 'Farmacéutico', 'farma@mail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0987654321', 'Calle Farma 456', 2, 1),
(3, 'Cliente Test', 'cliente@mail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '5555555555', 'Calle Cliente 789', 3, 1)
ON DUPLICATE KEY UPDATE 
    nombre = VALUES(nombre),
    password = VALUES(password),
    telefono = VALUES(telefono),
    direccion = VALUES(direccion),
    rol_id = VALUES(rol_id),
    activo = VALUES(activo);
```

### 1.3. Verificar que funciona

1. Ve a: `http://localhost/farmapp/index.php?action=login`
2. Prueba iniciar sesión con:
   - **Email:** `admin@mail.com`
   - **Password:** `123456`
3. ✅ Deberías ser redirigido al dashboard de administrador

---

## 🌐 Paso 2: Preparar para InfinityFree

### 2.1. Obtener Credenciales de InfinityFree

1. Inicia sesión en tu cuenta de **InfinityFree**
2. Ve al **Panel de Control** (cPanel)
3. Busca la sección **"MySQL Databases"** o **"Bases de datos MySQL"**
4. Anota esta información:
   - **Host MySQL:** (ejemplo: `sqlXXX.epizy.com` o `localhost`)
   - **Nombre de usuario MySQL:** (ejemplo: `epiz_XXXXXX`)
   - **Nombre de la base de datos:** (ejemplo: `epiz_XXXXXX_farmapp`)
   - **Contraseña MySQL:** (la que configuraste)

### 2.2. Crear Base de Datos en InfinityFree

1. En el panel de InfinityFree, ve a **MySQL Databases**
2. Crea una nueva base de datos llamada `farmapp`
3. Crea un nuevo usuario MySQL (si no tienes uno)
4. Asigna el usuario a la base de datos
5. Anota todas las credenciales

### 2.3. Importar Base de Datos a InfinityFree

**Opción A: Usando phpMyAdmin de InfinityFree (Recomendado)**

1. En el panel de InfinityFree, busca **phpMyAdmin**
2. Abre phpMyAdmin
3. Selecciona tu base de datos en el menú lateral
4. Ve a la pestaña **"Importar"** o **"Import"**
5. Selecciona el archivo: `database/farmapp.sql`
6. Haz clic en **"Continuar"** o **"Go"**
7. ✅ Espera a que termine la importación

**Opción B: Usando línea de comandos (si tienes acceso SSH)**

```bash
mysql -h sqlXXX.epizy.com -u epiz_XXXXXX -p epiz_XXXXXX_farmapp < database/farmapp.sql
```

---

## 📤 Paso 3: Subir Archivos a InfinityFree

### 3.1. Preparar Archivos

**IMPORTANTE:** Antes de subir, haz una copia de seguridad de tu proyecto local.

### 3.2. Subir vía FTP

1. Descarga un cliente FTP (recomendado: **FileZilla** - gratuito)
2. Conecta a tu servidor InfinityFree:
   - **Host:** `ftpupload.net` (o el que te proporcionen)
   - **Usuario:** Tu usuario de InfinityFree
   - **Contraseña:** Tu contraseña de InfinityFree
   - **Puerto:** 21
3. Sube TODOS los archivos de la carpeta `farmapp` a:
   - `htdocs/` o `public_html/` (según tu servidor)
4. ⚠️ **MANTÉN la estructura de carpetas:**
   ```
   htdocs/
   ├── config/
   ├── controllers/
   ├── models/
   ├── views/
   ├── public/
   ├── database/
   ├── utils/
   ├── index.php
   └── .htaccess
   ```

### 3.3. Actualizar Configuración para Producción

1. **Edita `config/database.php` en el servidor** (o edítalo localmente y súbelo):
   - Cambia: `$isProduction = true;`
   - Completa las credenciales de InfinityFree:
   ```php
   private $configProduction = [
       'host' => 'sqlXXX.epizy.com', // Tu host de InfinityFree
       'dbname' => 'epiz_XXXXXX_farmapp', // Tu nombre de BD
       'username' => 'epiz_XXXXXX', // Tu usuario
       'password' => 'tu_password_aqui', // Tu contraseña
       'charset' => 'utf8mb4'
   ];
   ```

2. **Edita `config/config.php` en el servidor:**
   - Cambia `BASE_URL` a tu dominio:
   ```php
   define('BASE_URL', 'https://tu-dominio.epizy.com');
   ```
   O si usas un subdominio:
   ```php
   define('BASE_URL', 'https://tu-subdominio.epizy.com');
   ```

### 3.4. Configurar Permisos

1. Asegúrate de que la carpeta `public/images/productos/` tenga permisos de escritura
2. En el panel de InfinityFree, ve a **File Manager**
3. Busca la carpeta `public/images/productos/`
4. Clic derecho → **Change Permissions** → Marca **755** o **777**

---

## ✅ Paso 4: Verificar en Producción

1. Abre tu navegador y ve a tu dominio de InfinityFree
2. Deberías ver la página principal de FarmApp
3. Prueba iniciar sesión:
   - **Email:** `admin@mail.com`
   - **Password:** `123456`
4. ✅ Si funciona, ¡listo!

---

## 🔧 Solución de Problemas Comunes

### Error: "Error de conexión a la base de datos"

- Verifica que las credenciales en `config/database.php` sean correctas
- En InfinityFree, a veces el host es `localhost` en lugar del host externo
- Verifica que la base de datos exista en InfinityFree

### Las imágenes no se cargan

- Verifica que `BASE_URL` en `config/config.php` sea correcto
- Verifica permisos de la carpeta `public/images/productos/`
- Asegúrate de que las rutas sean correctas

### Sesiones no funcionan

- En InfinityFree, verifica la configuración de sesiones en PHP
- Puede que necesites configurar la ruta de sesiones manualmente

---

## 📝 Checklist Final

### Antes de Subir
- [ ] Usuarios de prueba funcionan en localhost
- [ ] La aplicación funciona completamente en localhost
- [ ] Tengo las credenciales de InfinityFree
- [ ] Base de datos creada en InfinityFree
- [ ] Archivo SQL importado en InfinityFree

### Después de Subir
- [ ] Todos los archivos subidos vía FTP
- [ ] `$isProduction = true` en `database.php`
- [ ] Credenciales de InfinityFree configuradas
- [ ] `BASE_URL` actualizado con mi dominio
- [ ] Permisos de carpetas configurados
- [ ] La aplicación funciona en mi dominio
- [ ] Puedo iniciar sesión en producción

---

**¿Listo para continuar?** Primero verifica los usuarios con `verificar_usuarios.php` y luego seguimos con InfinityFree.

