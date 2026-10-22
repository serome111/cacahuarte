# Actualizar Cacahuarte en el servidor

Estos cambios no actualizan PHP del servidor mediante `git pull`. El parche real de PHP y el reinicio de los procesos web son imprescindibles para CVE-2026-109618 y CVE-2026-109619.

## 1. Antes de actualizar

Respaldar la base de datos, `.env` y archivos subidos (`storage/app/public` y `public/images`). No ejecutar `migrate:fresh`, no regenerar `APP_KEY` y no eliminar volúmenes Docker.

Identificar si el sitio usa Docker, PHP-FPM, Apache/mod_php o un panel de hosting. Anotar la versión de PHP del sitio desde el panel o la configuración del servicio; `php -v` solo identifica CLI y puede ser diferente de la versión web.

## 2. Actualizar PHP

Instalar una versión estable con parche: PHP **8.3.36 o posterior de 8.3**, **8.4.27 o posterior de 8.4**, o **8.5.12 o posterior de 8.5**. Para este proyecto se valida 8.3.36. Actualizar también las extensiones PHP instaladas desde el mismo proveedor.

En Ubuntu/Debian, si ya se usa PHP 8.3 con FPM y los repositorios configurados ofrecen 8.3.36 o posterior:

```sh
sudo apt-get update
apt-cache policy php8.3-cli php8.3-fpm php8.3-common
sudo apt-get install --only-upgrade php8.3-cli php8.3-fpm php8.3-common
```

No continuar si la versión candidata sigue sin parche. Usar el paquete corregido del proveedor, actualizar desde el panel de hosting o cambiar a una rama admitida. Algunas distribuciones aplican backports con un número anterior: comprobar explícitamente ambos CVE en el aviso del proveedor; el verificador del repositorio rechazará ese número antiguo por precaución.

Reiniciar los procesos que sirven PHP después de instalar el parche. Con FPM 8.3:

```sh
sudo systemctl restart php8.3-fpm
```

Si se usa Apache con mod_php, reiniciar Apache (`sudo systemctl restart apache2`). En paneles o contenedores usar el reinicio correspondiente. Confirmar que el sitio está conectado al servicio actualizado y que no quedan trabajadores web antiguos en ejecución.

## 3. Actualizar el proyecto

Después de actualizar PHP, desde la carpeta del repositorio y con la CLI de la misma rama parcheada:

```sh
git pull --ff-only
php tools/check-php-security.php
composer install --no-dev --prefer-dist --optimize-autoloader
composer check-platform-reqs --no-dev
composer audit --no-dev
php artisan optimize:clear
php artisan config:cache
```

Configurar en `.env` `APP_ENV=production` y `APP_DEBUG=false`. Si el sitio funciona exclusivamente por HTTPS, configurar `SESSION_SECURE_COOKIE=true`. No copiar `.env.example` encima de `.env` existente.

Los CSS/JS compilados, fuentes y manifiesto se incluyen en Git, de modo que Node no es necesario en el servidor para publicarlos. Para recompilar, se requiere Node 22 o posterior:

```sh
npm ci
npm audit
npm run production
```

Reiniciar los trabajadores de colas si se usan (`php artisan queue:restart`). Esta actualización no requiere cambios de esquema de base de datos.

## Alternativa: Docker Compose/Sail

El Compose del repositorio es un entorno Sail de desarrollo; no debe adoptarse como configuración nueva de producción. Si ya es el entorno usado, se cambió de PHP 8.0 a 8.3 y se añadió un control de versión antes del arranque. Con Composer disponible y dependencias instaladas:

```sh
docker compose build --pull --no-cache laravel.test
docker compose run --rm --no-deps laravel.test php tools/check-php-security.php
docker compose up -d --no-deps laravel.test
docker compose exec laravel.test php tools/check-php-security.php
docker compose exec laravel.test composer check-platform-reqs --no-dev
```

La reconstrucción debe obtener paquetes corregidos; cambiar `8.0` a `8.3` en YAML por sí solo no instala el parche. Si el verificador falla, no publicar esa imagen. Nunca usar `docker compose down -v` como paso de actualización.

## 4. Comprobar

- Repetir `php tools/check-php-security.php` y comprobar por separado la versión del servicio web desde el panel o binario FPM/Apache. No publicar `phpinfo()`.
- Revisar inicio, inicio de sesión, productos, iconos, imágenes y formulario de contacto.
- Un visitante debe recibir rechazo al consultar o borrar mensajes mediante las rutas administrativas.
- Revisar registros de acceso y de PHP por archivos, procesos o solicitudes anómalas. Instalar el parche no elimina una intrusión previa.

Referencia: https://www.php.net/archive/2026.php#2026-10-21-5
