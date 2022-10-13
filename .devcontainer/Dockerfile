FROM ubuntu/apache2:2.4-22.04_beta

RUN apt update -y && \
    apt install -y mariadb-client software-properties-common git && \
    add-apt-repository -y ppa:ondrej/php

# Install php7.4 and set it as default. Also setting upload_max_filesize to 200M
RUN apt install -y php7.4-xdebug php7.4 php7.4-curl php7.4-gd php7.4-zip php7.4-imap php7.4-mbstring php7.4-intl php7.4-simplexml php7.4-dom php7.4-mysql
RUN update-alternatives --set php /usr/bin/php7.4

# Install compatible composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer
