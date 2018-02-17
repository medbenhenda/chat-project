# Tchat project

### Description
Chat application bases on symfony components

### Requirements:
* PHP 5.6
* mod_rewrite must be enabled

### Installation
1. git clone git@github.com:medbenhenda/chat-project.git
2. cd chat-project
3. install dependencies:
    _execute_ `composer install`
4. database settings:

   Edit `config/database/mysql.yml` file 

       mysql:
   
           driver: pdo_mysql
           user: root
           password: ''
           dbname: chat
   
5. Mapping: create tables in the database:

execute `php vendor/doctrine/orm/bin/doctrine orm:schema-tool:update --force
`
6. Generate entities proxies

execute `php vendor/doctrine/orm/bin/doctrine  orm:generate-proxies`

7. go to the url 

### Structure Documentation:
In this project many Symfony component are used: Security, var-dumper, templating, config, YAML, routing, console, http-foundation, validator

Doctrine and Twig 3rd party applications are installed. Doctrine for the mapping between Relationel Database and PHP objects. Twig is used as the templating engine.

the index.php is the front controller that call the kernel to handle the request and send the response.

The config directory contains the configuration of the routes and the config of the database.

The kernel class instantiate the request object, check the route, get the appropriate controller and called its action.

An entityManager is defined in the Kernel directory used along the application. a bootstrap file is defined in the route used by CLI for doctrine commands

App directory contains the application ode. The application is modular there are 2 used modules: CoreModule for the chat and User Module for the handling of user and messages.

The cache directory contains the proxy entities class generate by doctrine (see point 4)

Assets directory contains all front end files (CSS, Js, Images).

cli-config.php file used by doctrine command line it include the bootstrap file