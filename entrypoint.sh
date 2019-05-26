#!/usr/bin/env bash

cd courses

chmod 777 -R storage

composer install

npm install

npm run prod

if [ "${APP_ENV}" == "local" ]; then
echo "local env"
cp .env.example.local .env
fi

php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force

nginx -g 'daemon on;'

mkdir -p /run/php/
php-fpm

env="$(echo "${APP_ENV}" | cut -d: -f1)"
if [ "${env}" == "local" ]; then
  echo "works local - ${env}";
  sh -c "while :; do sleep 60; done"
fi

exec "$@"