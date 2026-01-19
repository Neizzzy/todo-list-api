FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    libzip-dev
RUN docker-php-ext-install pdo pdo_sqlite zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

WORKDIR /app

COPY . .
RUN composer install

RUN > database/database.sqlite

CMD ["bash", "-c", "php artisan migrate:refresh --seed --force && php artisan serve --host=0.0.0.0 --port=$PORT"]
