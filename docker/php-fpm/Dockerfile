FROM php:7.0-fpm

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/xdebug.ini


RUN apt-get update && apt-get install -y git
RUN git clone git://github.com/phalcon/cphalcon.git
RUN cd cphalcon/build && ./install

## RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name phalcon.so)" > /usr/local/etc/php/conf.d/phalcon.ini
RUN docker-php-ext-enable phalcon


RUN apt-get install -y libssl-dev
RUN yes | pecl install mongodb
RUN docker-php-ext-enable mongodb

ENV XDEBUG_CONFIG remote_host=192.168.1.111
