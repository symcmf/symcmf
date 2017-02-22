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
	
2. Run composer
   
       ```
       composer install
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
    
5. Run composer update to prevent errors
    
    ```
    composer update
    ```
    
6. Create all the database tables

    ```
    php bin/console doctrine:schema:update --force
    ```

7. Finally, browse [http://192.168.10.10](http://192.168.10.10), you should see the main page of application.
   Or add to your hosts file 
    
     ```
        192.168.10.10  homestead.app
     ```
   
     and browse [http://homestead.app](http://homestead.app).
     
     ========================
     
## Symfony CMF Setup
     
1. Create at least one site      
    
     ```
    php app/console sonata:page:create-site
    ```
    
2. Generate pages

    ```
    php app/console sonata:page:update-core-routes --site=all
    ```
    
3. Published pages for all users 
    
    At this point, no snapshots are available so the end user will get an error. The following command need to be run:
    
    ```
    php app/console sonata:page:create-snapshots --site=all
    ```
    
4. Generate sitemap 

    ```
   php app/console sonata:seo:sitemap <dir_for_sitemap_files> <host>
    ```
    
   Note: 
   
   The command will generate all files in a temporary folder to avoid issue will files are indexed. Once the files are generated then the files will be copied to the web folder. The sonata-project.org argument will be used to prefix url with the provided domain.
   
5. Create admin 

     ```
     php bin/console fos:user:create --super-admin
     ```
     