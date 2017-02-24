#!/usr/bin/env bash

php app/console doctrine:cache:clear-metadata
php app/console doctrine:schema:update --force
