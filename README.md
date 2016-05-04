# Tamarin

---

## CakePHP

### Installation

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app tamarin`.

If Composer is installed globally, run
```bash
composer create-project --prefer-dist cakephp/app tamarin
```

You should now be able to visit the path to where you installed the app.


### Configuration

Read and edit `config/app.php` and setup the 'Datasources' and any other
configuration relevant for your application, if needed.

If you're going to use Heroku and follow the steps below, you probably
don't need to change anything in this file, only in file *.env*.


### Running

```bash
bin/cake server -H 192.168.13.37 -p 5673
```

* `192.168.13.37` being your host's name or IP address
* `5673` being the port

---

## Create local database

Create a database to use in your local environment.

For the structure and data, you can either:

- Import file [`tamarin.sql`](https://github.com/LordAlexWorks/tamarin/blob/master/tamarin.sql);

- Or go to Heroku -> Resources -> Add-ons -> ClearDB MySQL :: Database -> Backups & Jobs, and download a fresh backup from the test database.


### Change environment variables

Check CakePHP's section on env variables: http://book.cakephp.org/3.0/en/development/configuration.html#environment-variables

If you don't have an .env file in the project's root folder, create it.

Add the following line with your local database info, for example:

```
DEBUG=1
APP_ENCODING='UTF-8'
APP_DEFAULT_LOCALE='fr_FR'
DATABASE_URL='mysql://root:password@localhost/local_girlzinweb'
DATABASE_TEST_URL='mysql://root:password@localhost/test_girlzinweb'
```

---

## Heroku

### Setup

After receiving Heroku's invitation to join the project, run:

```bash
heroku git:clone -a tamarin
```


## Create a procfile
If you don't have a file named **Procfile** (no extensions), create it with the following content:

```bash
web: bin/cake server -p $PORT
```

Modify it to run as you would run CakePHP. For example, if you use a host different than **localhost**:

```bash
web: bin/cake server -H XXX.XXX.X.X -p $PORT
```

For more information: https://devcenter.heroku.com/articles/procfile


## Run heroku locally
```bash
heroku local web -p 5673
```

### Access locally
Go to your browser and access the URL returned from  (e.g. http://localhost:5673).


