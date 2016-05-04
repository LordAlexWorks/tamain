# Tamarin

## Install CakePHP

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app tamarin`.

If Composer is installed globally, run
```bash
composer create-project --prefer-dist cakephp/app tamarin
```

You should now be able to visit the path to where you installed the app.


## Configure CakePHP

Read and edit `config/app.php` and setup the 'Datasources' and any other
configuration relevant for your application.


## Run CakePHP

```bash
bin/cake server -H 192.168.13.37 -p 5673
```

## Setup Heroku

After receiving Heroku's invitation to join the project, run:

```bash
heroku git:clone -a tamarin
```