FROM php:5-apache
COPY web /var/www/
RUN mv -T /var/www/public_html /var/www/html
RUN ln -s -T /var/www/html /var/www/public_html
WORKDIR /var/www/
RUN apt-get update && apt-get install -y wget libgmp-dev zlib1g-dev
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/a68fc08d2de42237ae80d77e8dd44488d268e13d/web/installer -O - -q | php -- --quiet
RUN ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/
RUN docker-php-ext-install gmp
RUN docker-php-ext-install zip
RUN echo 'date.timezone = Europe/Moscow' > /usr/local/etc/php/php.ini
RUN php composer.phar install
RUN chmod o+w -R /var/www
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /var/www/html/
