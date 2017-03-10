#!/usr/bin/env bash

echo 'Setup site and pages ... '
php app/console sonata:page:create-site --no-confirmation=true --enabled=true --name=SCMF --locale=- --host=localhost --relativePath=/ --enabledFrom=now --enabledTo="+10 years" --default=true
php app/console sonata:page:update-core-routes --site=1
php app/console sonata:page:create-snapshots --site=1
echo ' Done! '

echo 'Add admin user ...'
php app/console fos:user:create root root@domain.com root --super-admin
echo ' Done! '

echo ' Setup styles ... '
php app/console assetic:dump web/
echo ' Done! '

chmod 777 -R app/cache/ app/logs/
chmod 777 -R app/cache/* app/logs/*

mkdir web/uploads web/uploads/media
