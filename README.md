# Tamarin

---

## Installation

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `composer update`.


## CakePHP

### Configuration

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

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
DATABASE_URL='mysql://root:password@localhost/local_tamarin'
DATABASE_TEST_URL='mysql://root:password@localhost/test_tamarin'
```

---

## Heroku

### Setup

After receiving Heroku's invitation to join the project, run:

```bash
heroku git:clone -a tamarin
```


### Create a procfile
If you don't have a file named **Procfile** (no extensions), create it with the following content:

```bash
web: bin/cake server -p $PORT
```

Modify it to run as you would run CakePHP. For example, if you use a host different than **localhost**:

```bash
web: bin/cake server -H XXX.XXX.X.X -p $PORT
```

For more information: https://devcenter.heroku.com/articles/procfile

---

## Run locally

```bash
heroku local web -p 5673
```

Go to your browser and access the URL returned (e.g. http://localhost:5673).


## Analyze code using PHP_CodeSniffer

Before each pull request, analyze your code against CakePHP's standards:

### Let code sniffer know where to find your sniffs
```bash
./vendor/bin/phpcs --config-set \
installed_paths ../../cakephp/cakephp-codesniffer
```

* Where `../../cakephp/cakephp-codesniffer` is the path to cakephp-codesniffer installed with composer 

### Analyze the code
To analyze the code: 
```bash
./vendor/bin/phpcs --standard=CakePHP src
```

* Where `src` is the path to code. You can also run it in any other files/paths

To automatically correct coding standard violations:
```bash
./vendor/bin/phpcbf --standard=CakePHP src
```

* Where `src` is the path to code. You can also run it in any other files/paths


### Resources
PHP CodeSniffer Documentation: https://github.com/squizlabs/PHP_CodeSniffer/wiki

CakePHP CodeSniffer: https://github.com/cakephp/cakephp-codesniffer

A good tutorial:
http://andy-carter.com/blog/setting-up-php-codesniffer-in-sublime-text-3-for-cakephp-and-other-standards


## Emails

### Accounts

#### Admin email
lobobot+tamarinAdmin@lordalexworks.com
lordalexworks

### Mailchimp account
lobobot+tamarinAdmin@lordalexworks.com
@Lordalexworks0406

> **Security questions:**
> Name of your first employer?
> LoBo
> What kind of coffee do we serve in the office?
> None
> What brand of coffee maker do you use in the office?
> None

### Email address of imported members

Whenever importing a CSV file with debug mode active (for local and staging environments), all the member emails are switched to **lobobot+tamarin`{id}`@lordalexworks.com**, according to the member's ID. This is a precaution measure so we can test real CSV data without worrying that we'll email real members.

This does not happen for manually added members, even in debug mode. It also does not apply to editing members.

### When emails are sent to the admins

For now, never.

### When emails are sent to the members

Via sendgrid and Heroku Job Scheduler, no connection to mailchimp for now.

1. Membership expired 15 days ago
2. Membership expired today
3. Membership will expire in 15 days

### Mailchimp

Once a list is created in mailchimp, the user can create email campaigns directly there, not needing to change anything in Tamarin.

* **Subscribe**: a member is subscribed in the mailchimp list when their first membership is created.
  * S/he does not receive any automatic emails, and does not need to confirm subscription.
* **Data**:
  * Currently we store in the list: `First name`, `Last name`, `Starts on`, and `Expires on`, besides the email. Only `Starts on` and `Expires on` are updated, the other data (including email) does not change even when the member updates her/his profile.
  * The `Starts on` and `Expires on` fields are updated whenever the membership is updated, for future or past dates.
* **Unsubscribe**: a member is unsubscribed automatically 30 days after their last membership expired.
  * The user and her/his data remains in the list, under a different category ("Unsubscribed").
