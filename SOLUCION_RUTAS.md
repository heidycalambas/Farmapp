# 🔧 Solución de Problemas de Rutas - FarmApp

## ✅ Cambios Realizados

He corregido el sistema de rutas para que funcione correctamente. Los cambios incluyen:

1. **index.php en la raíz**: Ahora incluye directamente `public/index.php` en lugar de redirigir
2. **.htaccess mejorado**: Configurado para manejar rutas correctamente
3. **public/.htaccess**: Creado para manejar archivos estáticos

## 🌐 URLs Correctas para Acceder

### Página Principal
```
http://localhost/farmapp/
http://localhost/farmapp/index.php
```

### Login
```
http://localhost/farmapp/index.php?action=login
```

### Registro
```
http://localhost/farmapp/index.php?action=registro
```

### Catálogo
```
http://localhost/farmapp/index.php?action=catalogo
```

### Test de Conexión
```
http://localhost/farmapp/index.php?action=test_connection
http://localhost/farmapp/public/test_connection.php
```

## ⚠️ Si Aún Ves Errores "Not Found"

### Verificar que mod_rewrite esté habilitado en Apache

1. Abre el archivo `httpd.conf` de Apache (normalmente en `C:\xampp\apache\conf\httpd.conf`)
2. Busca la línea: `#LoadModule rewrite_module modules/mod_rewrite.so`
3. Quita el `#` para descomentarla: `LoadModule rewrite_module modules/mod_rewrite.so`
4. Reinicia Apache en XAMPP

### Verificar la configuración de Apache

Asegúrate de que en `httpd.conf` esté configurado:

```apache
<Directory "C:/xampp/htdocs">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

O específicamente para farmapp:

```apache
<Directory "C:/xampp/htdocs/farmapp">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

### Alternativa: Usar directamente public/index.php

Si el .htaccess no funciona, puedes acceder directamente:

```
http://localhost/farmapp/public/index.php?action=login
```

## 🔍 Verificar que Todo Funciona

1. **Accede a la página principal:**
   - `http://localhost/farmapp/`
   - Deberías ver la página de inicio

2. **Prueba el login:**
   - `http://localhost/farmapp/index.php?action=login`
   - Deberías ver el formulario de login

3. **Verifica los estilos CSS:**
   - La página debe verse con estilos (no solo HTML plano)
   - Si no se ven estilos, verifica que `http://localhost/farmapp/public/css/style.css` sea accesible

4. **Prueba iniciar sesión:**
   - Email: `admin@mail.com`
   - Password: `123456`
   - Deberías ser redirigido al dashboard de administrador

## 📝 Notas Importantes

- El `BASE_URL` en `config/config.php` está configurado como `http://localhost/farmapp`
- Todas las rutas usan `BASE_URL . '/index.php?action=...'`
- Los archivos estáticos (CSS, JS, imágenes) están en `public/` y se acceden con `BASE_URL . '/public/...'`

## 🐛 Si Persisten los Problemas

1. Verifica que Apache esté corriendo
2. Verifica que PHP esté habilitado
3. Revisa los logs de error de Apache en `C:\xampp\apache\logs\error.log`
4. Asegúrate de que la carpeta `farmapp` esté en `C:\xampp\htdocs\farmapp` (o la ruta correcta de tu servidor)

---

**¿Todo funcionando?** Si aún tienes problemas, comparte el mensaje de error exacto que ves.

