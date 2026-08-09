#!/bin/bash
set -e

php artisan package:discover --ansi

if [ "${SKIP_BOOTSTRAP_CACHE:-false}" = "true" ]; then
    echo "Bootstrap cache kihagyva."
elif [ "${APP_ENV:-production}" = "local" ]; then
    echo "Local environment: cache artifacts kihagyva."
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
else
    echo "Production environment: cache artifacts generálása."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "Storage symlink ellenőrzése..."
php artisan storage:link || true

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force
    echo "Migrations complete."
fi

exec "$@"
