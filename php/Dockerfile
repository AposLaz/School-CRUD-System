FROM php:7.2-apache

RUN apt-get update && apt-get upgrade -y

RUN docker-php-ext-install mysqli pdo_mysql && docker-php-ext-enable mysqli

RUN docker-php-ext-install pdo_mysql 

