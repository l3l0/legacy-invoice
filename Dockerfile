FROM php:5.6-apache

RUN apt-get update \
    && apt-get install -y git curl bzip2 vim libssl-dev zlib1g-dev libxrender1 libicu-dev g++ libjpeg-dev libjpeg62 libfontconfig-dev \
    && pecl install xdebug \
    && echo zend_extension=xdebug.so > /usr/local/etc/php/conf.d/xdebug.ini \
    && pecl install apcu-beta \
    && echo extension=apcu.so > /usr/local/etc/php/conf.d/apcu.ini \
    && docker-php-ext-install zip mbstring intl pdo_mysql \
    && apt-get -y install mysql-client php5-gd

ADD docker/vhost.conf /etc/apache2/sites-enabled/000-default.conf
ADD docker/php.ini /usr/local/etc/php/php.ini
ADD docker/wkhtmltopdf-0.11.0_rc1-static-amd64.tar.bz2 /root/wkhtmltopdf

RUN a2enmod rewrite

RUN mv /root/wkhtmltopdf/wkhtmltopdf-amd64 /usr/bin/wkhtmltopdf
RUN chmod a+x /usr/bin/wkhtmltopdf

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer

EXPOSE 9000

WORKDIR /var/www/invoice
