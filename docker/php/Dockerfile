FROM php:7.4-fpm

ARG HOST_UID=1000
ARG XDEBUG_IP=0.0.0.0
ARG XDEBUG_PORT=9000

RUN apt-get update && apt-get install -y apt-utils \
    && apt-get install -y \
    zip \
    git \
    libzip-dev
RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN docker-php-ext-install pdo pdo_mysql zip 
RUN set -x && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer 
RUN echo "memory_limit=1G" >> /usr/local/etc/php/conf.d/memory.ini 

RUN usermod -u ${HOST_UID} www-data \
    && groupmod -g ${HOST_UID} www-data \
    && chsh -s /bin/bash www-data \
    && chown -R www-data:www-data /var/www

# install node.js & yarn
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get install -y nodejs
RUN curl -sS http://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb http://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install -y yarn

RUN git clone https://github.com/xdebug/xdebug.git \
    && cd xdebug \
    && git checkout xdebug_2_9 \
    && phpize \
    && ./configure --enable-xdebug \
    && make \
    && make install
RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" \
    > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.profiler_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_host=${XDEBUG_IP}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=${XDEBUG_PORT}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.max_nesting_level=250" >> /usr/local/etc/php/conf.d/xdebug.ini