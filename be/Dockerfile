#download php image
From php:8.1.10 as php

#follwing part will execute after php container is up & running
#update php server
RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
RUN docker-php-ext-install pdo pdo_mysql bcmath

#set the working directory inside the container to /var/www/
#and copy the application code into the container
WORKDIR /var/www/
COPY . .

#copies the Composer binary from a separate Composer image (composer:2.7.2) into the PHP image.
#It ensures that Composer is available within the PHP container for managing dependencies during the build process.
COPY --from=composer:2.7.2 /usr/bin/composer /usr/bin/composer

#The ENV PORT=8000 line sets an environment variable named PORT with a default value
ENV PORT=8000

#it specifies the default command to run when the container starts
ENTRYPOINT ["docker/entrypoint.sh"]
