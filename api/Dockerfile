# PHP Docker image for Yii 2.0 Framework runtime
# ==============================================

FROM registry.gitlab.com/jdsteam/sapa-warga/sapawarga-app/sapawarga-api:base

# Configure version constraints
ENV VERSION_COMPOSER_ASSET_PLUGIN=^1.4.2 \
    VERSION_PRESTISSIMO_PLUGIN=^0.3.7 \
    PATH=/app:/app/vendor/bin:/root/.composer/vendor/bin:$PATH \
    TERM=linux \
    COMPOSER_ALLOW_SUPERUSER=1

# Add configuration files
COPY image-files/ /

# Add GITHUB_API_TOKEN support for composer

RUN chmod 700 \
        /usr/local/bin/docker-entrypoint.sh \
        /usr/local/bin/composer

# Install composer
RUN cd ~
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN composer global require --optimize-autoloader \
        "fxp/composer-asset-plugin:${VERSION_COMPOSER_ASSET_PLUGIN}" \
        "hirak/prestissimo:${VERSION_PRESTISSIMO_PLUGIN}"
RUN composer global dumpautoload --optimize
RUN composer clear-cache

# Install nginx
RUN apk --update add nginx

WORKDIR /srv

COPY . /srv/
RUN chown -R www-data:www-data /srv/ \
    && chmod 777 -R /srv/runtime

RUN /usr/local/bin/composer install --prefer-dist

EXPOSE 80

CMD ["docker-entrypoint.sh"]