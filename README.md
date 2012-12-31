BugtrackerBundle
================

Introduction
------------

BugtrackerBundle is a Symfony2 Bundle created for managing bugs in any web project.

Installation
------------

1. Clone the repository

2. Create the app/config/parameters_dev.yml and app/config/parameters_prod.yml :
    cp app/config/parameters.yml.dist app/config/parameters_dev.yml
    cp app/config/parameters.yml.dist app/config/parameters_prod.yml
Update your database settings in these files

3. Update your dependencies with Composer :
    curl -s http://getcomposer.org/installer | php --
    php composer.phar install