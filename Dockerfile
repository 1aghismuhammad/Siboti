FROM php:8.2-apache

# 1. Instal dependensi sistem dan library untuk SQLite
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libsqlite3-dev

# 2. Instal ekstensi PHP yang dibutuhkan Laravel & SQLite
RUN docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd

# 3. Konfigurasi Apache: Ubah DocumentRoot ke folder /public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Aktifkan mod_rewrite Apache (PENTING untuk routing Laravel)
RUN a2enmod rewrite

# 5. Ambil Composer versi terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 6. Salin file proyek ke dalam container
COPY . .

# 7. Berikan izin akses awal ke folder storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80