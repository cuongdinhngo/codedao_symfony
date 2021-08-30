FROM ubuntu:20.04

MAINTAINER cuong.ngo

RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

RUN apt-get update && apt-get install -y language-pack-en

RUN locale-gen en_US.UTF-8

ENV LANGUAGE=en_US.UTF-8
ENV LC_ALL=en_US.UTF-8
ENV LC_CTYPE=UTF-8
ENV LANG=en_US.UTF-8
ENV TERM xterm

ARG DEBIAN_FRONTEND=noninteractive

# Install PHP8.0, some PHP extentions and some useful Tools with APT

RUN apt-get update && apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php

RUN apt-get update && apt-get install -y --allow-remove-essential \
        php8.0 \
        php8.0-fpm \
        php8.0-cli \
        php8.0-dev \
        php8.0-phpdbg \
        php8.0-common \
        php8.0-curl \
        php8.0-xml \
        php8.0-mbstring \
        php8.0-mysql \
        php8.0-pgsql \
        php8.0-zip \
        php8.0-imagick \
        php8.0-xdebug \
        php8.0-gd \
        php8.0-redis \
        php8.0-xsl \
        git \
        curl \
        vim \
        nano \
        npm \
        telnetd \
        wget \
        openssl \
    && apt-get clean


# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash


# Install NodeJs 12x
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash
RUN apt-get install -y nodejs

# Install composer
RUN curl -s http://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Configure Nginx
RUN apt-get -yqq update; apt-get -yqq install nginx
ADD default.conf /etc/nginx/conf.d/default.conf
ADD nginx.conf /etc/nginx/nginx.conf

# Laravel Worker supervisor
ADD laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN mkdir -p /var/www/project
WORKDIR /var/www/project

RUN usermod -u 1000 www-data

CMD service php8.0-fpm start && nginx

EXPOSE 80 9000
