# 🔧 Solución: Error de Conexión a MySQL

## ❌ Error que estás viendo:
```
Access denied for user 'root'@'localhost' (using password: NO)
```

Esto significa que MySQL está rechazando la conexión porque requiere una contraseña, o el usuario root no tiene permisos.

---

## ✅ Solución 1: Verificar si MySQL tiene contraseña (Recomendado)

### Opción A: Si MySQL NO tiene contraseña (XAMPP por defecto)

1. Abre **MySQL Workbench**
2. Intenta conectar con:
   - Username: `root`
   - Password: (déjalo vacío)
3. Si conecta sin contraseña, entonces el problema es otro (ver Solución 2)

### Opción B: Si MySQL SÍ tiene contraseña

1. Abre **MySQL Workbench**
2. Conecta usando tu contraseña
3. Edita el archivo `config/database.php`
4. Cambia la línea 19:
   ```php
   'password' => 'tu_contraseña_aqui', // Pega tu contraseña aquí
   ```

---

## ✅ Solución 2: Configurar MySQL sin contraseña (XAMPP)

Si quieres usar MySQL sin contraseña (como viene por defecto en XAMPP):

### Paso 1: Verificar el estado de MySQL

1. Abre **XAMPP Control Panel**
2. Verifica que MySQL esté corriendo (verde)
3. Si no está corriendo, inícialo

### Paso 2: Resetear la contraseña de root (si es necesario)

1. Abre **MySQL Workbench**
2. Si no puedes conectar, abre una terminal de Windows
3. Navega a: `C:\xampp\mysql\bin`
4. Ejecuta:
   ```bash
   mysql.exe -u root
   ```
   O si pide contraseña:
   ```bash
   mysql.exe -u root -p
   ```
   (y presiona Enter si no tienes contraseña)

5. Una vez dentro de MySQL, ejecuta:
   ```sql
   ALTER USER 'root'@'localhost' IDENTIFIED BY '';
   FLUSH PRIVILEGES;
   EXIT;
   ```

### Paso 3: Verificar la configuración

1. Abre `config/database.php`
2. Verifica que la línea 19 sea:
   ```php
   'password' => '',  // Vacío, sin contraseña
   ```

---

## ✅ Solución 3: Usar una contraseña específica

Si prefieres usar una contraseña:

### Paso 1: Configurar contraseña en MySQL

1. Abre **MySQL Workbench**
2. Conecta a tu servidor
3. Ejecuta:
   ```sql
   ALTER USER 'root'@'localhost' IDENTIFIED BY 'tu_contraseña';
   FLUSH PRIVILEGES;
   ```

### Paso 2: Actualizar config/database.php

1. Abre `config/database.php`
2. Cambia la línea 19:
   ```php
   'password' => 'tu_contraseña',  // La misma que configuraste arriba
   ```

---

## ✅ Solución 4: Verificar que la base de datos existe

Aunque el error es de autenticación, asegúrate de que:

1. La base de datos `farmapp` existe
2. Está creada en MySQL Workbench
3. Tiene las tablas importadas

### Verificar en MySQL Workbench:

1. Abre MySQL Workbench
2. Conecta a tu servidor
3. En el panel lateral, busca `farmapp`
4. Si no existe, créala:
   ```sql
   CREATE DATABASE farmapp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

---

## 🔍 Diagnóstico Rápido

### Test 1: Verificar conexión básica

Abre una terminal y ejecuta:
```bash
cd C:\xampp\mysql\bin
mysql.exe -u root
```

- Si conecta: MySQL no tiene contraseña → Usa `'password' => ''` en database.php
- Si pide contraseña: MySQL tiene contraseña → Configúrala en database.php

### Test 2: Verificar desde PHP

1. Crea un archivo `test_mysql.php` en la raíz:
   ```php
   <?php
   try {
       $pdo = new PDO('mysql:host=localhost', 'root', '');
       echo "✅ Conexión exitosa sin contraseña";
   } catch (PDOException $e) {
       echo "❌ Error: " . $e->getMessage();
       echo "<br>Intenta con contraseña...";
       try {
           $pdo = new PDO('mysql:host=localhost', 'root', 'root');
           echo "✅ Conexión exitosa con contraseña 'root'";
       } catch (PDOException $e2) {
           echo "❌ Error: " . $e2->getMessage();
       }
   }
   ?>
   ```
2. Accede desde: `http://localhost/farmapp/test_mysql.php`

---

## 📝 Configuración Actual en database.php

Tu archivo `config/database.php` tiene:
```php
'username' => 'root',
'password' => '',  // ← Esto está vacío
```

**Si MySQL requiere contraseña**, cambia esta línea.

---

## ✅ Checklist Final

- [ ] MySQL está corriendo en XAMPP (verde)
- [ ] Puedo conectar a MySQL desde MySQL Workbench
- [ ] La contraseña en `config/database.php` coincide con la de MySQL
- [ ] La base de datos `farmapp` existe
- [ ] Las tablas están importadas en `farmapp`
- [ ] `$isProduction = false` en database.php

---

**¿Qué solución probaste?** Comparte el resultado para ayudarte mejor.

