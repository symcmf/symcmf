Symfony CMF
========================

## Setup development environment with Homestead 

1. Clone project

    with SSH

    ```
        git clone git@nix.githost.io:php-skillup/symfony-cmf.git
    ```
    
    or with HTTPS
    
    ```
        git clone https://nix.githost.io/php-skillup/symfony-cmf.git
    ```
	
2. Setup homestead/vagrant environment in project folder:
	
    ```
    ./vendor/bin/homestead make
	```

3. Edit Homestead.yaml:
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
    
4. Edit app_dev.php. Comment or remove line as you can see below:
    
    ```
    if (isset($_SERVER['HTTP_CLIENT_IP'])
        || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    //    || !(in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) || php_sapi_name() === 'cli-server')
    ) {
        header('HTTP/1.0 403 Forbidden');
        exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
    }
    ``` 

5. Run vagrant
	
    ```
    vagrant up
    ```
    
6. Run composer

    ```
    composer install
    ```
    
    if there is any errors after composer install try:
    
    ```
    composer update
    ```
    
7. Create all the database tables

    ```
    php bin/console doctrine:schema:update --force
    ```

8. Finally, browse [http://192.168.10.10](http://192.168.10.10), you should see the main page of application.