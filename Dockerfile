FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    git \
    supervisor \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    libgmp-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js yang lebih aman (official method)
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) pdo pdo_pgsql zip pcntl bcmath gmp gd 

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files first (for Docker layer caching)
COPY composer.json composer.lock ./

# Copy npm files first
COPY package*.json ./

# Install Node dependencies
RUN npm install

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-interaction

# Build frontend assets
# RUN NODE_OPTIONS=--max_old_space_size=1024 npm run build

RUN mkdir -p storage/framework/{cache,sessions,testing,views} \
    && mkdir -p database/ \
    && touch database/database.sqlite \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database \
    && chmod 664 database/database.sqlite

# Copy supervisord config
COPY ./docker/affilab-worker.conf /etc/supervisor/conf.d/affilab-worker.conf

RUN echo "[supervisord]\nnodaemon=true\nuser=root\n\n[include]\nfiles=/etc/supervisor/conf.d/*.conf" > /etc/supervisor/supervisord.conf

EXPOSE 9000
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]