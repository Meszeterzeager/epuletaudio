FROM dunglas/frankenphp:latest

WORKDIR /app

# System dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libfreetype6-dev \
    libicu-dev \
    libzip-dev \
    default-mysql-client \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN install-php-extensions \
    pdo_mysql \
    redis \
    gd \
    zip \
    intl \
    opcache \
    pcntl \
    bcmath \
    exif

# PHP config
COPY docker/php.ini $PHP_INI_DIR/conf.d/app.ini

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# PHP dependencies (cached layer)
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-scripts

# Node dependencies (cached layer)
COPY package.json package-lock.json* ./
RUN npm install --no-audit --no-fund

# Copy application
COPY . .

RUN composer dump-autoload --optimize

# Frontend build (no-op until a build script exists)
RUN npm run build --if-present

# Storage directories & permissions
RUN mkdir -p storage/logs \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/app/public \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80 443

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=80", "--admin-port=2019", "--workers=2"]
