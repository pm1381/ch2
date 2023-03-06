FROM php:8.0-apache

RUN a2enmod rewrite
RUN apt-get update -y && apt-get install -y
RUN docker-php-ext-install pdo pdo_mysql

