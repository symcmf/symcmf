#!/usr/bin/env bash

sudo service mysql start
mysql -h localhost --user=root --password=root -e "CREATE DATABASE IF NOT EXISTS homestead CHARACTER SET utf8 COLLATE utf8_general_ci;"
mysql -h localhost --user=root --password=root homestead < tests/_data/dump.sql

echo "Set config file with params"
cp app/config/parameters.gitlab-ci.yml app/config/parameters.yml

echo "Get libraries for project"
composer install

echo "Install DB and seeders for it"
bash app/db-update.sh

echo "Setup Symfony CMF"
bash app/setup.sh

echo "Generate build_bootstrap for testing"
php vendor/sensio/distribution-bundle/Resources/bin/build_bootstrap.php
