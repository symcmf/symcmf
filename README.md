Symfony CMF
========================

[![Build Status](https://travis-ci.org/symcmf/symcmf.svg?branch=master)](https://travis-ci.org/symcmf/symcmf)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/symcmf/symcmf/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/symcmf/symcmf/?branch=master)    [![Code Coverage](https://scrutinizer-ci.com/g/symcmf/symcmf/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/symcmf/symcmf/?branch=master)   [![Dependency Status](https://www.versioneye.com/user/projects/58c67f17c920cf0040c4d2e5/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/58c67f17c920cf0040c4d2e5)

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/symcmf/symcmf/blob/master/LICENSE)

## Setup development environment with Homestead 

1. Clone project

    with SSH

    ```
        git clone git@github.com:symcmf/symcmf.git
    ```
    
    or with HTTPS
    
    ```
        git clone https://github.com/symcmf/symcmf.git
    ```
	
2. Run composer
   
       ```
       composer install --no-scripts
       ```
3. Setup homestead/vagrant environment in project folder:
	
    ```
    ./vendor/bin/homestead make
	```

4. Edit Homestead.yaml:
    > Remove the following lines from Homestead.yaml if you don't have this SSH keys on your machine (https://laravel.com/docs/master/homestead#installation-and-setup):
	> Or generate and paste your SSH keys.
    
    ```
    authorize: ~/.ssh/id_rsa.pub
    keys:
        - ~/.ssh/id_rsa
     ```
     
     > Set type option that tells Homestead to use the Symfony nginx configuration.
     
     ```
    sites:
        - map: homestead.app
          to: "/home/vagrant/yourprojectfolder/web"
          type: symfony
    ```

5. Run vagrant
	
    ```
    vagrant up
    ```
    
5. Run composer install for running scripts
    
    ```
    composer install
    ```
    
6. Create all the database tables

    ```
    ./app/db-update.sh
    ```
    
    > If you will get error "Permission denied" you have to change access rules with next command 

    ```
    sudo chmod -R 777 app/
    ```
    
## Symfony CMF Setup
     
1. Setup CMF site

    ```
    ./app/setup.sh
    ```
    
     #### It will execute next commands:
     - php app/console sonata:page:create-site
     - php app/console sonata:page:update-core-routes --site=all
     - php app/console sonata:page:create-snapshots --site=all
     - php app/console fos:user:create --super-admin
     - php app/console assetic:dump web/
        
2. After it, browse [http://192.168.10.10](http://192.168.10.10), you should see the main page of application.
   Or add to your hosts file 
    
     ```
        192.168.10.10  homestead.app
     ```
   
     and browse [http://homestead.app](http://homestead.app).
