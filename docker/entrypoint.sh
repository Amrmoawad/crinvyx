#!/bin/sh
set -e

if [ -z "$APP_KEY" ]; then
    export APP_KEY="$(php artisan key:generate --show)"
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate --force

if [ "${RUN_SEEDER:-true}" = "true" ]; then
    php artisan db:seed --force
fi

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
