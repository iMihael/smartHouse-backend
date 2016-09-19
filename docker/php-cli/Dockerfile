FROM php:7.0-cli

WORKDIR /usr/share/nginx/html

RUN apt-get update && apt-get install -y git zlib1g-dev
RUN docker-php-ext-install -j$(nproc) zip

RUN apt-get install -y libcurl3 libcurl3-dev curl
RUN docker-php-ext-install -j$(nproc) curl

RUN php -r "copy('https://getcomposer.org/composer.phar', '/usr/local/bin/composer');"
RUN chmod +x /usr/local/bin/composer
RUN composer global require "fxp/composer-asset-plugin:~1.1.1"

CMD composer install

