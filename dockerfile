FROM php:7-apache
LABEL maintainer "Mark N Carpenter Jr <mcarpenter@smtcorp.com>"

RUN apt update && apt upgrade && apt install -y \
    git \
    curl \
    ca-certificates \
    xz-utils \
  --no-install-reccomends && rm -r /var/lib/apt/lists/*

RUN mkdir /SMT && git clone -b master http://dev2/dev/suite-crm.git /SMT/suitecrm

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

EXPOSE 80 443