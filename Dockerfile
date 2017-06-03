FROM php:7.1-apache

RUN apt-get update \
    && apt-get install -y git curl bzip2 vim libssl-dev zlib1g-dev libxrender1 libicu-dev g++ libjpeg-dev libjpeg62 libfontconfig-dev mysql-client \
    && docker-php-ext-install zip mbstring intl pdo_mysql gd

ADD docker/vhost.conf /etc/apache2/sites-enabled/000-default.conf
ADD docker/php.ini /usr/local/etc/php/php.ini
ADD docker/wkhtmltopdf-0.11.0_rc1-static-amd64.tar.bz2 /root/wkhtmltopdf

RUN a2enmod rewrite

RUN mv /root/wkhtmltopdf/wkhtmltopdf-amd64 /usr/bin/wkhtmltopdf
RUN chmod a+x /usr/bin/wkhtmltopdf

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer

WORKDIR /var/www/invoice
