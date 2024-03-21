#!/bin/bash

#install composer if not already install
if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

#create env file if not exist
if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

#run following commands only if container is app(php)
role=${CONTAINER_ROLE:-app}

if [ "$role" = "app" ]; then
    php artisan migrate
    php artisan key:generate
    php artisan cache:clear
    php artisan config:clear
    php artisan optimize:clear
    php artisan route:clear

    php artisan serve --port=$PORT --host=0.0.0.0 --env=.env
fi

exec docker-php-entrypoint "$@"
