Smart House backend
=========================

Requirements
------------------------
+ php >= 7
+ mongodb
+ nodejs >= 6.5

Docker install
------------------------
* docker-compose build
* docker-compose up

localhost:8000 - Application  
localhost:8001 - Mongodb


If you have issue like:  
> ERROR: client and server don't have same version (client : 1.21, server: 1.18)  
use this command to fix it:  

Use this command to fix it:
> export COMPOSE_API_VERSION=1.18

To use xdebug with docker container please set 
ENV XDEBUG_CONFIG remote_host={HOST_IP} 
to your actual ip address in `docker/php-fpm/Dockerfile`

Manual installation
-------------------------
+ composer install
+ npm install
+ ./node_modules/gulp/bin/gulp.js
+ configure web server to look into `web/` folder
+ setup `app/config/params.php`