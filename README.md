# php-mvc
Simple MVC boilerplate with composer autoload and Symfony routing component.

## Installation

Composer is needed so as to use this MVC. If you do not have it please install it.

By default, I added compatibility with MySQL, PostreSQL and MongoDB. 

If you need MongoDB, please make sure you have it correctly installed along with php extension. Otherswise composer installation will fail.

If you do not need MongoDB just remove `mongodb` entry from composer.json file.

Now you may install the dependencies by doing:

```
$ composer install
```

## Configuration

You will find some config example files that will need to be renamed:

`app/config/config.example.php -> app/config/config.php`

`public/.htaccess.example -> public/.htaccess`

`config.php` needs to be filled properly if you need to have access to any or all of the databases that are allowed.

`.htaccess` config file for Apache should be ok by default if using `public/` dir as the site root. Otherwise simply update `RewriteBase` to your site root.

Make sure `app/cache` is writable by the web server.

## Routes

Symfony routing component is used to handle the MVC routes. YAML config is used in `app/config/routes.yml` and you may check out the docs on how it works https://symfony.com/doc/current/components/routing.html

## Demo

There is some simple and typical `Hello World` demo code already included. In order to make it work you need to provide MySQL and/or MongoDB access data in config files as described above. You will also need the code below and insert it in the proper database:

MySQL demo code:

```
CREATE SCHEMA `test` DEFAULT CHARACTER SET utf8 ;
CREATE TABLE `test`.`messages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `message` VARCHAR(45) NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `test`.`messages` (`message`) VALUES ('Hello World from MySQL');
```

MongoDB demo code from mongo cli:

```
$ mongo
> use test
> db.myCollection.insert({"message": "Hello World from MongoDB"})
```

## Quick Execution

You may run the MVC for testing with built-in server. This assumes you are executing this command from MVC root and set `public/` as the root site.

```
$ php -S 0.0.0.0:8000 -t public/
```
