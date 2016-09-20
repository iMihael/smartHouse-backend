FROM php:7.0-cli

WORKDIR /usr/share/nginx/html

RUN apt-get update && apt-get install -y git zlib1g-dev
RUN docker-php-ext-install -j$(nproc) zip

RUN apt-get install -y libcurl3 libcurl3-dev curl
RUN docker-php-ext-install -j$(nproc) curl

RUN php -r "copy('https://getcomposer.org/composer.phar', '/usr/local/bin/composer');"
RUN chmod +x /usr/local/bin/composer
RUN composer global require "fxp/composer-asset-plugin:~1.1.1"

RUN git clone git://github.com/phalcon/cphalcon.git
RUN cd cphalcon/build && ./install
RUN docker-php-ext-enable phalcon

#RUN apt-get install -y libssl-dev
#RUN yes | pecl install mongodb
#RUN docker-php-ext-enable mongodb

CMD composer install

