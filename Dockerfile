# For use in GitLab CI with the CRM.
# Needs to be pushed to the GitLab Container Registry for the SuiteCRM repository.
FROM php:7.2.18-apache-stretch

# Install packages for running SuiteCRM and its dependencies.
# git is required by composer
# gnupg and apt-transport-https are necessary for installing Chrome.
RUN apt-get update && apt-get install -y apt-utils \
    git \
    libzip-dev \
    zip \
    libpng-dev \
    libicu-dev \
    g++ \
    mysql-client \
    gnupg \
    apt-transport-https \
    libcurl3-dev \
    libxml2-dev \
    libc-client-dev \
    libkrb5-dev

# Install MySQL, zip, intl, mbstring, imap, curl, etc. for SuiteCRM and/or Composer.
RUN docker-php-ext-configure intl
RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl
RUN docker-php-ext-install pdo_mysql mysqli zip gd intl mbstring imap curl json
RUN docker-php-ext-install gettext

# Install Composer and move it to the bin folder so it can be used with just `composer`.
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Install Chrome and ChromeDriver
RUN curl -sSL https://dl.google.com/linux/linux_signing_key.pub | apt-key add - && echo "deb https://dl.google.com/linux/chrome/deb/ stable main" > /etc/apt/sources.list.d/google-chrome.list
RUN apt-get update -qqy && apt-get install -yy google-chrome-stable
RUN wget https://chromedriver.storage.googleapis.com/74.0.3729.6/chromedriver_linux64.zip
# Unzip chromedriver into the /usr/bin/ so the command is accessible across the system.
RUN unzip -o chromedriver_linux64.zip -d /usr/local/bin/

# Clean up the container to minimize its size.
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
