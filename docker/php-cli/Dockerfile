FROM php:7.3-cli

RUN apt-get update
RUN apt-get install -y git unzip

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions mcrypt pdo_mysql gd zip
RUN install-php-extensions @composer-1

RUN composer global require hirak/prestissimo

RUN install-php-extensions xdebug
