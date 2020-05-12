FROM php:7.4-cli

ARG USER_ID=1000
ARG USER_GID=1000

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zlib1g-dev \
    libgmp3-dev \
    libxml2-dev

RUN pecl install xdebug
RUN docker-php-ext-install zip
RUN docker-php-ext-install gmp
RUN docker-php-ext-enable xdebug

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/bin/composer

RUN groupadd --gid "${USER_GID}" "default" && \
    useradd \
      --uid ${USER_ID} \
      --gid ${USER_GID} \
      --create-home \
      --shell /bin/bash \
      default

COPY --chown=default:default . /usr/src

WORKDIR /usr/src

USER default