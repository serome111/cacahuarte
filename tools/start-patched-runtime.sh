#!/bin/sh
set -eu
php /var/www/html/tools/check-php-security.php
exec /usr/local/bin/start-container "$@"
