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

===========================
     
## Symfony CMF Setup
     
0. Setup CMF site

    ```
    ./app/setup.sh
    ```
     
     > It will be run next commands:
     
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
    
4. Create admin 

     ```
     php app/console fos:user:create --super-admin
     ```
     
5. For setup styles
    
    ```
    php app/console assetic:dump web/
    ```
       
6. Finally, browse [http://192.168.10.10](http://192.168.10.10), you should see the main page of application.
   Or add to your hosts file 
    
     ```
        192.168.10.10  homestead.app
     ```
   
     and browse [http://homestead.app](http://homestead.app).
     
7. Generate sitemap 

    ```
   php app/console sonata:seo:sitemap <dir_for_sitemap_files> <host>
    ```
    
   > The command will generate all files in a temporary folder to avoid issue will files are indexed. Once the files are generated then the files will be copied to the <_dir_for_sitemap_files_> folder. The <_host_> argument will be used to prefix url with the provided domain.
