FROM php:8.1.21-fpm-bullseye

# Copy composer.lock and composer.json
COPY src/composer.lock src/composer.json /data/

WORKDIR /data

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    locales \
    libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# install and enable xdebug
RUN pecl install xdebug-3.2.0RC1 \
	&& docker-php-ext-enable xdebug

RUN apt-get -qq -y update \
  && apt-get --no-install-recommends -qq -y install apt-transport-https curl \
  # mssql odbc driver
  && apt-get install -y gnupg2

RUN apt-get update -yqq \
    && apt-get install -y --no-install-recommends openssl \ 
    && sed -i 's,^\(MinProtocol[ ]*=\).*,\1'TLSv1.0',g' /etc/ssl/openssl.cnf \
    && sed -i 's,^\(CipherString[ ]*=\).*,\1'DEFAULT@SECLEVEL=1',g' /etc/ssl/openssl.cnf\
    && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --enable-gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer self-update

COPY ./infra/docker/php/php.development.ini /usr/local/etc/php/php.ini
COPY ./infra/docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./infra/docker/php/php.deploy.ini /usr/local/etc/php/php.ini
COPY ./infra/docker/php/openssl.cnf /etc/ssl/openssl.cnf

# Add user for laravel application
# RUN groupadd -g 1000 www
# RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY src/ /data

# # Copy existing application directory permissions
# COPY --chown=www:www . /data

# # Change current user to www
# USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
