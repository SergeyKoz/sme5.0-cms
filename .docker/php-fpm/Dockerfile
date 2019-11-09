FROM php:5.6-fpm

RUN apt-get update && apt-get install -y mysql-client libxslt-dev libpng-dev libfreetype6-dev libjpeg62-turbo-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql xsl \
    && docker-php-ext-enable mysqli \
    && docker-php-ext-configure mysqli --with-mysql-sock=/var/run/mysqld/mysqld.sock \
    && docker-php-ext-configure gd --with-freetype-dir --enable-gd-native-ttf \
    && docker-php-ext-install -j$(nproc) gd

CMD ["php-fpm"]

EXPOSE 9000