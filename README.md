RGK Event messenger
============================

DEMO:
-----

**Authentication:**
_Login:_ `demo`
_Password:_ `demo`

CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=<host>;dbname=<database name>',
    'username' => '<user>',
    'password' => '<password>',
    'charset' => 'utf8',
];
```

Installation and getting started:
---------------------------------

**If you do not have Composer, you may install it by following the instructions at getcomposer.org.**

**If you do not have Composer-Asset-Plugin installed, you may install it by running command:** `php composer.phar global require "fxp/composer-asset-plugin:1.0.0"`

1. Create a new database and adjust it configuration in `common/config/db.php` accordingly.
2. Run command 'composer install'
3. Apply migrations with console commands:
   - `php yii migrate`
   - This will create tables needed for the application to work.