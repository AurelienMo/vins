ARG PHP_VERSION=""
FROM composer
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm-alpine
ENV WORKPATH "/var/www/app"
RUN apk update; \
    apk upgrade;
RUN apk add --no-cache $PHPIZE_DEPS \
    libzip-dev icu-dev libxml2-dev freetype-dev libpng-dev libjpeg-turbo-dev g++ make autoconf \
	&& pecl install apcu mongodb xdebug \
    && docker-php-ext-install pdo_mysql opcache json mysqli intl zip gd \
	&& docker-php-ext-enable apcu mysqli mongodb.so xdebug
RUN apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ --allow-untrusted gnu-libiconv
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
RUN echo "xdebug.remote_enable = 1" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.remote_connect_back = 1" >> /usr/local/etc/php/php.ini

ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=0 /usr/bin/composer /usr/bin/composer
RUN mkdir -p ${WORKPATH}

RUN rm -rf ${WORKDIR}/vendor \
    && ls -l ${WORKDIR}

RUN mkdir -p \
		${WORKDIR}/var/cache \
		${WORKDIR}/var/logs \
		${WORKDIR}/var/sessions \
	&& chown -R www-data ${WORKDIR}/var \
	&& chown -R www-data /tmp/ \
	&& mkdir /.composer/ \
	&& chown -R www-data /.composer/

RUN chown www-data:www-data -R ${WORKPATH}
RUN chmod 775 ${WORKPATH}

WORKDIR ${WORKPATH}
