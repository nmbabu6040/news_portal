# Step 1: Base Image (PHP 8.2 with FrankenPHP)
FROM dunglas/frankenphp:1-php8.2-bookworm AS base

# Install required PHP Extensions for Laravel
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && install-php-extensions intl zip pdo_mysql gd bcmath opcache

WORKDIR /app

# Step 2: Composer Dependencies Stage
FROM base AS dependencies
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --optimize-autoloader \
    --prefer-dist

COPY . .

RUN mkdir -p \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        bootstrap/cache

RUN composer dump-autoload --no-dev --classmap-authoritative

# Step 3: Frontend Assets Build Stage (Vite / Tailwind / Bootstrap)
FROM node:22-bookworm AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN npm run build

# Final Runtime Stage
FROM base AS runtime

COPY --from=dependencies /app /app
COPY --from=frontend /app/public/build /app/public/build

# Root ইউজার দিয়ে পারমিশন ফুল ওপেন করা (Railway Container Fix)
USER root
RUN chmod -R 777 /app/storage /app/bootstrap/cache

ENV PORT=80 \
    SERVER_NAME=":80" \
    APP_ENV=production \
    APP_DEBUG=true \
    LOG_CHANNEL=stderr \
    FRANKENPHP_CONFIG="web_root /app/public"

EXPOSE 80

CMD ["frankenphp", "php-server", "--root", "/app/public"]
