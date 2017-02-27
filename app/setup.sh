#!/usr/bin/env bash

php app/console  sonata:page:create-site --enabled=true --name=SCMF --locale=- --host=localhost --relativePath=/ --enabledFrom=now --enabledTo="+10 years" --default=true
php app/console sonata:page:update-core-routes --site=1
php app/console sonata:page:create-snapshots --site=1

php app/console fos:user:create --super-admin

php app/console assetic:dump web/
