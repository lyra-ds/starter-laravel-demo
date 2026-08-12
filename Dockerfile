# Assets primeiro: o build do Vite não precisa do PHP, e separar as camadas
# evita reconstruir o mundo a cada mudança de template.
FROM node:24-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
RUN npm ci
COPY resources ./resources
RUN npm run build

FROM dunglas/frankenphp:php8.4
WORKDIR /app

RUN install-php-extensions pdo_sqlite opcache zip intl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --no-interaction

COPY . .
COPY --from=assets /app/public/build ./public/build

# O banco do demo é um arquivo: sem serviço externo, e um volume no Docploy
# preserva os usuários registrados entre deploys. Sem volume, cada deploy
# recomeça do seeder — aceitável para uma vitrine.
RUN mkdir -p database && touch database/database.sqlite \
    && composer dump-autoload --optimize \
    && chown -R www-data:www-data storage bootstrap/cache database

ENV SERVER_NAME=:80
EXPOSE 80

CMD ["sh", "-c", "php artisan migrate --force && php artisan db:seed --force && frankenphp run --config /etc/caddy/Caddyfile"]
