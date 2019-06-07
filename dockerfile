FROM php:7.3-apache
LABEL maintainer "Mark N Carpenter Jr <mcarpenter@smtcorp.com>"

# Set our Envrionment Variables.
ENV ALLOW_EMPTY_PASSWORD="yes" \
    APACHE_HTTPS_PORT_NUMBER="443" \
    APACHE_HTTP_PORT_NUMBER="80" \
    MARIADB_HOST="mariadb" \
    MARIADB_PORT_NUMBER="3306" \
    MARIADB_ROOT_PASSWORD="" \
    MARIADB_ROOT_USER="root" \
    MYSQL_CLIENT_CREATE_DATABASE_NAME="" \
    MYSQL_CLIENT_CREATE_DATABASE_PASSWORD="" \
    MYSQL_CLIENT_CREATE_DATABASE_PRIVILEGES="ALL" \
    MYSQL_CLIENT_CREATE_DATABASE_USER="" \
    SUITECRM_DATABASE_NAME="suitecrm" \
    SUITECRM_DATABASE_PASSWORD="" \
    SUITECRM_DATABASE_USER="suitecrm" \
    SUITECRM_HOST="127.0.0.1" \
    SUITECRM_HTTP_TIMEOUT="3600" \
    SUITECRM_USERNAME="user" \
    SUITECRM_PASSWORD="bitnami" \
    SUITECRM_EMAIL="user@example.com" \
    SUITECRM_LAST_NAME="Name" \
    SUITECRM_SMTP_HOST="" \
    SUITECRM_SMTP_PASSWORD="" \
    SUITECRM_SMTP_PORT="" \
    SUITECRM_SMTP_PROTOCOL="" \
    SUITECRM_SMTP_USER="" \
    SUITECRM_VALIDATE_USER_IP="yes"

# Get our dependancies
RUN apt update && apt upgrade -y && apt install -y \
    libxml2-dev \
    zlib1g-dev \
    libzip-dev \
    libcurl4-gnutls-dev \
    libjpeg-dev \
    libpng-dev \
    git \
    curl \
    wget \
    ca-certificates \
    xz-utils \
    && docker-php-ext-install -j$(nproc) dom \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install -j$(nproc) curl \
    && docker-php-ext-install -j$(nproc) gd \
    # && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    # && docker-php-ext-install -j$(nproc) gd \
    && rm -r /var/lib/apt/lists/*

# Grab Suite from the master branch of our repository.
RUN mkdir /SMT && git clone -b master http://dev2/gitlab/dev/suite-crm.git /SMT/suitecrm \
    && cd /SMT/suitecrm

# Install Composer, we might consider adding any other Suite install Deps here
# Composer should cover them all though.
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php && php -r "unlink('composer-setup.php');"
RUN php composer.phar update --no-plugins --no-scripts --working-dir=/SMT/suitecrm \
    && php composer.phar install --no-plugins --no-scripts --working-dir=/SMT/suitecrm


# Start the SILENT install of SuiteCRM
RUN cd /SMT/suitecrm \
    && php -B "\$_REQUEST = array('goto' => 'SilentInstall');" -F install.php

# Expose our appications ports
EXPOSE 80 443