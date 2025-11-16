# 🗄️ Guía Rápida: Importar Base de Datos con MySQL Workbench

## 📋 Pasos para Importar farmapp.sql

### Paso 1: Abrir MySQL Workbench

1. Abre **MySQL Workbench** desde el menú de inicio
2. Conecta a tu servidor local:
   - Busca la conexión "Local instance MySQL" o similar
   - Haz doble clic para conectar
   - Si te pide contraseña y no la tienes configurada, déjala vacía

### Paso 2: Crear la Base de Datos

**Opción A: Usando el botón visual**

1. En la barra de herramientas, busca el icono de **"Create a new schema"** (base de datos con un +)
2. O ve a: **Database** → **Create Schema**
3. Nombre: `farmapp`
4. Default Collation: `utf8mb4_unicode_ci`
5. Haz clic en **"Apply"**

**Opción B: Usando SQL**

1. Abre una nueva pestaña de consultas (icono SQL o `Ctrl + T`)
2. Escribe:
```sql
CREATE DATABASE farmapp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
3. Haz clic en **"Execute"** (icono de rayo) o presiona `Ctrl + Shift + Enter`
4. Verifica que aparezca `farmapp` en el panel lateral izquierdo

### Paso 3: Importar el Archivo SQL

**Método Recomendado: Data Import**

1. Ve al menú: **Server** → **Data Import**
2. Selecciona **"Import from Self-Contained File"**
3. Haz clic en **"..."** junto al campo de archivo
4. Navega a: `C:\farmapp\database\farmapp.sql`
5. En la sección **"Default Target Schema"**:
   - Selecciona `farmapp` del dropdown
   - O haz clic en **"New"** y crea `farmapp` si no aparece
6. Asegúrate de que esté marcado **"Dump Structure and Data"**
7. Haz clic en **"Start Import"** (botón en la esquina inferior derecha)
8. ✅ Espera a que termine (verás un mensaje verde de éxito)

**Método Alternativo: Abrir y Ejecutar Script**

1. **IMPORTANTE:** Primero haz **doble clic** en la base de datos `farmapp` en el panel lateral izquierdo (SCHEMAS)
   - Esto la selecciona como base de datos activa (verás que se pone en negrita)
2. Abre una nueva pestaña de consultas: **File** → **New Query Tab** (o `Ctrl + T`)
3. Abre el archivo SQL: **File** → **Open SQL Script**
4. Navega a: `C:\farmapp\database\farmapp.sql`
5. Verifica que en el dropdown de schemas (barra superior) aparezca `farmapp` seleccionado
6. Haz clic en **"Execute"** (icono de rayo) o presiona `Ctrl + Shift + Enter`
7. ✅ Revisa el panel de resultados para ver los mensajes de éxito

**Nota:** El archivo SQL ahora incluye `USE farmapp;` al inicio, pero siempre es buena práctica seleccionar la BD manualmente.

### Paso 4: Verificar la Importación

1. En el panel lateral izquierdo, expande la base de datos `farmapp`
2. Expande **"Tables"**
3. Deberías ver estas tablas:
   - ✅ `categorias`
   - ✅ `detalle_pedidos`
   - ✅ `inventario`
   - ✅ `logs_sistema`
   - ✅ `mensajes`
   - ✅ `notificaciones`
   - ✅ `pedidos`
   - ✅ `productos`
   - ✅ `reportes`
   - ✅ `roles`
   - ✅ `usuarios`

4. Para verificar datos, haz clic derecho en una tabla → **"Select Rows - Limit 1000"**
   - Por ejemplo, en `usuarios` deberías ver 3 usuarios de prueba
   - En `productos` deberías ver 8 productos

### Paso 5: Probar la Conexión desde PHP

1. Abre tu navegador
2. Ve a: `http://localhost/farmapp/test_connection.php`
3. Deberías ver:
   - ✅ Mensaje de "Conexión exitosa"
   - ✅ Lista de todas las tablas
   - ✅ Usuarios de prueba
   - ✅ Cantidad de productos

## 🔧 Solución de Problemas

### Error: "Access denied for user 'root'@'localhost'"

**Solución:**
- Verifica que MySQL esté corriendo en XAMPP/Laragon
- Si tienes contraseña, úsala al conectar
- Si no tienes contraseña, déjala vacía

### Error: "Unknown database 'farmapp'"

**Solución:**
- Asegúrate de haber creado la base de datos primero (Paso 2)
- Verifica que el nombre sea exactamente `farmapp` (sin espacios, minúsculas)

### Error: "No database selected" (Error Code: 1046)

**Solución:**
- **Haz doble clic** en la base de datos `farmapp` en el panel lateral izquierdo (SCHEMAS)
- Verás que el nombre se pone en **negrita** - esto significa que está seleccionada
- O verifica que en el dropdown de schemas (barra superior de la pestaña SQL) aparezca `farmapp`
- El archivo SQL ya incluye `USE farmapp;` pero asegúrate de tener la BD seleccionada antes de ejecutar

### Error al importar: "Table already exists"

**Solución:**
- Si ya importaste antes, elimina las tablas existentes:
  1. En MySQL Workbench, expande `farmapp` → `Tables`
  2. Selecciona todas las tablas (Ctrl + Click)
  3. Clic derecho → **"Drop Tables..."** → **"Drop Now"**
  4. Vuelve a importar

### El archivo SQL no se encuentra

**Solución:**
- Verifica que el archivo esté en: `C:\farmapp\database\farmapp.sql`
- Si está en otra ubicación, navega hasta ella en el diálogo de importación

### La importación se queda colgada

**Solución:**
- Cierra y vuelve a abrir MySQL Workbench
- Verifica que MySQL esté corriendo correctamente
- Intenta usar el método alternativo (abrir y ejecutar script)

## ✅ Checklist de Verificación

- [ ] MySQL Workbench está abierto y conectado
- [ ] Base de datos `farmapp` creada
- [ ] Archivo `farmapp.sql` importado exitosamente
- [ ] Puedo ver las 11 tablas en el panel lateral
- [ ] La tabla `usuarios` tiene 3 registros
- [ ] La tabla `productos` tiene 8 registros
- [ ] `test_connection.php` muestra "Conexión exitosa"
- [ ] Puedo acceder a `http://localhost/farmapp` sin errores

---

**¿Todo listo?** Ahora puedes continuar con la configuración para InfinityFree cuando estés listo para subir a producción.


