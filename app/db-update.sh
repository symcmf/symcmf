#!/usr/bin/env bash

php console doctrine:cache:clear-metadata
php console doctrine:schema:update --force