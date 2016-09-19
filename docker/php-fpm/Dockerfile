FROM php:7.0-fpm

RUN apt-get update && apt-get install -y git
RUN git clone --depth=1 git://github.com/phalcon/cphalcon.git
RUN cphalcon/build/install

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini



ENV XDEBUG_CONFIG remote_host=10.55.26.92