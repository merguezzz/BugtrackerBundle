BugtrackerBundle
================

Introduction
------------

BugtrackerBundle is a Symfony2 Bundle created for managing bugs in any web project.

Installation
------------

1. Clone the repository

2. Create the app/config/parameters\_dev.yml and app/config/parameters\_prod.yml :

        cp app/config/parameters.yml.dist app/config/parameters_dev.yml
        cp app/config/parameters.yml.dist app/config/parameters_prod.yml

    And then, update your database settings in these files.

3. Update your dependencies with Composer :

        curl -s http://getcomposer.org/installer | php --
        php composer.phar install

Screenshots
-----------

###Dashboard

![Dashboard](https://raw.github.com/lgandelin/BugtrackerBundle/master/screens/dashboard.jpg "Dashboard")

###Database schema

![Database schema](https://raw.github.com/lgandelin/BugtrackerBundle/master/screens/database.jpg "Database schema")
