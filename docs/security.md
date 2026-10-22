# Revisión de seguridad — 2026-10-22

## Resultado verificado

- PHP 8.3.36 instalado para la validación local. El PHP predeterminado del equipo sigue siendo 8.4.14; para ejecutar este proyecto localmente, anteponer `/opt/homebrew/opt/php@8.3/bin` al PATH de la terminal. El servidor publicado aún debe actualizarse siguiendo `server-update.md`.
- Composer exige PHP `~8.3.36 || ~8.4.27 || ~8.5.12`. La plataforma de resolución es 8.3.36. `tools/check-php-security.php` verifica la versión real de CLI; Docker ejecuta esta comprobación antes de iniciar su servicio y CI antes de instalar dependencias.
- El verificador rechaza las versiones conocidas sin parche y también ramas nuevas no revisadas. Los parches backportados por una distribución requieren verificación independiente del proveedor; el verificador no los presume.
- Actualizadas 35 dependencias PHP compatibles, incluyendo Laravel 12.70.1 y componentes Symfony. `composer audit` no detecta vulnerabilidades conocidas.
- Sustituida la cadena Mix/Webpack por esbuild. Eliminadas sus dependencias vulnerables, incluido `braces`, sin ignorar alertas ni aplicar parches locales a paquetes externos. `npm audit`: cero alertas, frente a 32 al iniciar la revisión.
- La compilación utiliza Bootstrap 5.3.8 y jQuery 3.7.1 desde el lockfile. Las copias antiguas de estas bibliotecas en `resources/vendor` ya no forman parte de los bundles activos.
- Se conservan los nombres de CSS/JS y `mix-manifest.json` usados por las vistas, con hashes de contenido para invalidar caché. Fuentes y recursos CSS se emiten en `public/css/assets`. `npm run hot` y `npm run watch-poll` son alias de observación de archivos; no abren un servidor de desarrollo.

## Controles de la aplicación

- Autenticación para filtrar mensajes y eliminarlos en bloque.
- Permiso `manage-users` en el servidor, reservado al rol `admin`.
- Validación y selección explícita de campos de contacto; el visitante no puede asignar `state`.
- Máximo cinco solicitudes por minuto para contacto y suscripción.
- Validación de correos, roles existentes y contraseñas nuevas de al menos 12 caracteres.
- Imágenes JPEG/PNG de hasta 5 MiB, con validación de contenido y extensión. Clientes y equipo usan nombres aleatorios con extensión deducida del contenido.
- Los controladores de imágenes modificados guardan campos validados.
- Volcados SQL locales de la raíz excluidos de Git.

## Verificaciones

- Pruebas unitarias y de seguridad con PHP 8.3.36.
- Compilación de producción e instalación reproducible con `npm ci`.
- Archivos del manifiesto y referencias a fuentes/imágenes CSS comprobados.
- Inicio público responde HTTP 200 y se renderiza sin errores de consola en navegador local.
- CI comprueba el parche real de PHP, auditorías Composer/npm, compilación y pruebas de seguridad y unitarias.

Esto no certifica toda la aplicación. Las bibliotecas copiadas manualmente que permanecen en `resources/vendor` no están cubiertas por `npm audit`; tampoco se ha auditado el sistema operativo ni el servidor de producción.

Aviso oficial del parche PHP2Shell: https://www.php.net/archive/2026.php#2026-10-21-5
