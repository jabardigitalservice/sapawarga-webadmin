FROM ubuntu:18.04

RUN apt-get update

# tools
RUN apt-get install -y git
RUN apt-get install -y unzip
RUN apt-get install -y curl
RUN apt-get install -y nano

# php & extension
ENV TZ=Asia/Jakarta
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apt-get install -y php
RUN apt-get install -y php-curl
RUN apt-get install -y php-xml
RUN apt-get install -y phpunit
RUN apt-get install -y php-imagick
RUN apt-get install -y php-mysql
RUN apt-get install -y php-sqlite3
RUN apt-get install -y php-pgsql
RUN apt-get install -y php-intl
RUN apt-get install -y php-memcache
RUN apt-get install -y php-gd
RUN apt-get install -y php-memcached

# composer
RUN cd ~
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# apache & modules
RUN apt-get install -y apache2
RUN a2enmod rewrite

# copy files
RUN mkdir /var/www/app
COPY . /var/www/app
RUN chmod -R 777 /var/www/app

# install composer
WORKDIR /var/www/app
RUN composer install

# apache2 config
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Expose Apache
EXPOSE 80
 
# Launch Apache
CMD ["/usr/sbin/apache2ctl", "-DFOREGROUND"]