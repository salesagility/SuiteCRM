# php-webdriver – Selenium WebDriver bindings for PHP

[![Latest Stable Version](https://img.shields.io/packagist/v/facebook/webdriver.svg?style=flat-square)](https://packagist.org/packages/facebook/webdriver)
[![Travis Build](https://img.shields.io/travis/facebook/php-webdriver/community.svg?style=flat-square)](https://travis-ci.org/facebook/php-webdriver)
[![Sauce Test Status](https://saucelabs.com/buildstatus/php-webdriver)](https://saucelabs.com/u/php-webdriver)
[![Total Downloads](https://img.shields.io/packagist/dt/facebook/webdriver.svg?style=flat-square)](https://packagist.org/packages/facebook/webdriver)
[![License](https://img.shields.io/packagist/l/facebook/webdriver.svg?style=flat-square)](https://packagist.org/packages/facebook/webdriver)

## Description
Php-webdriver library is PHP language binding for Selenium WebDriver, which allows you to control web browsers from PHP.

This library is compatible with Selenium server version 2.x and 3.x.
It implements the [JsonWireProtocol](https://github.com/SeleniumHQ/selenium/wiki/JsonWireProtocol), which is currently supported
by the Selenium server and will also implement the [W3C WebDriver](https://w3c.github.io/webdriver/webdriver-spec.html) specification in the future.

The concepts of this library are very similar to the "official" Java, .NET, Python and Ruby bindings from the
[Selenium project](https://github.com/SeleniumHQ/selenium/).

**As of 2013, this PHP client has been rewritten from scratch.**
Using the old version? Check out [Adam Goucher's fork](https://github.com/Element-34/php-webdriver) of it.

Looking for API documentation of php-webdriver? See [https://facebook.github.io/php-webdriver/](https://facebook.github.io/php-webdriver/latest/)

Any complaints, questions, or ideas? Post them in the user group https://www.facebook.com/groups/phpwebdriver/.

## Installation

Installation is possible using [Composer](https://getcomposer.org/).

If you don't already use Composer, you can download the `composer.phar` binary:

    curl -sS https://getcomposer.org/installer | php

Then install the library:

    php composer.phar require facebook/webdriver

## Getting started

### Start Server

The required server is the `selenium-server-standalone-#.jar` file provided here: http://selenium-release.storage.googleapis.com/index.html

Download and run the server by replacing # with the current server version. Keep in mind **you must have Java 8+ installed to run this command**.

    java -jar selenium-server-standalone-#.jar

**NOTE:** If using Firefox, see alternate command below.

### Create a Browser Session

When creating a browser session, be sure to pass the url of your running server.

```php
// This would be the url of the host running the server-standalone.jar
$host = 'http://localhost:4444/wd/hub'; // this is the default
```

##### Launch Chrome

Make sure to have latest Chrome and [Chromedriver](https://sites.google.com/a/chromium.org/chromedriver/downloads) versions installed.

```php
$driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
```

##### Launch Firefox

Make sure to have latest Firefox and [Geckodriver](https://github.com/mozilla/geckodriver/releases) installed.

Because Firefox (and Geckodriver) only support the new W3C WebDriver protocol (which is yet to be implemented by php-webdriver - see [issue #469](https://github.com/facebook/php-webdriver/issues/469)),
the protocols must be translated by Selenium Server - this feature is *partially* available in Selenium Server versions 3.5.0-3.8.1 and you can enable it like this:

    java -jar selenium-server-standalone-3.8.1.jar -enablePassThrough false

Now you can start Firefox from your code:

```php
$driver = RemoteWebDriver::create($host, DesiredCapabilities::firefox());
```

### Customize Desired Capabilities

```php
$desired_capabilities = DesiredCapabilities::firefox();
$desired_capabilities->setCapability('acceptSslCerts', false);
$driver = RemoteWebDriver::create($host, $desired_capabilities);
```

* See https://github.com/SeleniumHQ/selenium/wiki/DesiredCapabilities for more details.

**NOTE:** Above snippets are not intended to be a working example by simply copy-pasting. See [example.php](example.php) for working example.

## Changelog
For latest changes see [CHANGELOG.md](CHANGELOG.md) file.

## More information

Some how-tos are provided right here in [our GitHub wiki](https://github.com/facebook/php-webdriver/wiki).

You may also want to check out the Selenium [docs](http://docs.seleniumhq.org/docs/) and [wiki](https://github.com/SeleniumHQ/selenium/wiki).

## Testing framework integration

To take advantage of automatized testing you may want to integrate php-webdriver to your testing framework.
There are some projects already providing this:

- [Steward](https://github.com/lmc-eu/steward) integrates php-webdriver directly to [PHPUnit](https://phpunit.de/), and provides parallelization
- [Codeception](http://codeception.com) testing framework provides BDD-layer on top of php-webdriver in its [WebDriver module](http://codeception.com/docs/modules/WebDriver)
- You can also check out this [blogpost](http://codeception.com/11-12-2013/working-with-phpunit-and-selenium-webdriver.html) + [demo project](https://github.com/DavertMik/php-webdriver-demo), describing simple [PHPUnit](https://phpunit.de/) integration

## Support

We have a great community willing to help you!

- **Via our Facebook Group** - If you have questions or are an active contributor consider joining our [facebook group](https://www.facebook.com/groups/phpwebdriver/) and contribute to communal discussion and support
- **Via StackOverflow** - You can also [ask a question](https://stackoverflow.com/questions/ask?tags=php+selenium-webdriver) or find many already answered question on StackOverflow
- **Via GitHub** - Another option if you have a question (or bug report) is to [submit it here](https://github.com/facebook/php-webdriver/issues/new) as an new issue

## Contributing

We love to have your help to make php-webdriver better. See [CONTRIBUTING.md](CONTRIBUTING.md) for more information about contributing and developing php-webdriver.
