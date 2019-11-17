# lensvision

## Setup guide
1. clone git repository
2. go to environment folder
3. install docker and docker-compose
4. run docker-compose up -d
5. add to you hosts file
    172.19.0.100 db.lv.local
    172.19.0.2 api.lv.local
6. open web container *docker exec -it web bash* and got to */var/www/html*
7. install composer (@todo need to add container)
    https://getcomposer.org/download/
    https://getcomposer.org/doc/00-intro.md#globally
8. go to /var/www/html/api and run composer install
9. got to /etc/apache2/sites-available and run a2ensite api.pm.local.conf, service apache2 reload (@todo should be run automatically)

10. create database commands:
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create
    php bin/console doctrine:migrations:migrate
    
11. api endpoint 
    http://api.lv.local/api/v2
    http://api.lv.local/api/v2
    
    available parameters
    parameter1 and/or parameter2