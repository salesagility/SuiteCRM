Zend Framework 1 for Composer
=============================

This package is a part of the Zend Framework 1. Each component was separated and put into its own composer package. Some modifications were made for improved [Composer](http://getcomposer.org/) integration. This package can also be found at [Packagist](http://packagist.org/packages/zf1).

## Why?

**Size!** Zend Framework is very large and contains a huge amount of files (over 72000 files in the main repository!). If you're only using a part of the framework, using the separated packages will greatly reduce the amount of files. This will make setup faster and easier on your disks.

**Autoloading!** Explicit `require_once` calls in the source code has been commented out to rely on composer autoloading, this reduces the number of included files to a minimum.

**Migration!** Zend Framework 2 has been around for a while now, and migrating all your projects takes a lot of time. Using these packages makes it easier to migrate each component separately. Also, some packages doesn't exist in zf2 (such as the zend-search-lucene), now you can continue using that package without requiring the entire framework.

If you're using major parts of the framework, I would recommend checking out the [zendframework1 package](https://github.com/bombayworks/zendframework1), which contains the entire framework optimized for composer usage.

## How to use

Add `"zf1/zend-search-lucene": "~1.12"` to the require section of your composer.json, include the composer autoloader and you're good to go.

## Broken dependencies?

Dependencies have been set automatically based on the [requirements from the zend framework manual](http://framework.zend.com/manual/1.12/en/requirements.introduction.html), if you find any broken dependencies please submit an issue.