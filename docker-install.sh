#!/bin/bash
echo "Update packages and install composer and PHP dependencies."
apt-get update -yqq
apt-get update

echo "Install git and dependencies for it"
apt-get -y install git libcurl4-gnutls-dev libicu-dev libmcrypt-dev libvpx-dev libjpeg-dev libpng-dev libxpm-dev zlib1g-dev libfreetype6-dev libxml2-dev libexpat1-dev libbz2-dev libgmp3-dev libldap2-dev unixodbc-dev libpq-dev libsqlite3-dev libaspell-dev libsnmp-dev libpcre3-dev libtidy-dev phpunit -yqq

echo "Compile PHP, include these extensions."
docker-php-ext-install mbstring mcrypt pdo pdo_mysql curl json intl gd xml zip bz2 opcache

echo "Install composer"
curl -sS https://getcomposer.org/installer | php

echo "Get libraries for project"
php composer.phar install --prefer-source --no-scripts

echo "Set config file with params"
cp app/config/parameters.gitlab-ci.yml app/config/parameters.yml

echo "Install DB and seeders for it"
bash app/db-update.sh

echo "Generate build_bootstrap for testing"
php vendor/sensio/distribution-bundle/Resources/bin/build_bootstrap.php

ping -c 3 mysql