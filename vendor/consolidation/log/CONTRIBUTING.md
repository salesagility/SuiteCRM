# Contributing to Consolidation

Thank you for your interest in contributing to the Consolidation effort!  Consolidation aims to provide reusable, loosely-coupled components useful for building command-line tools. Consolidation is built on top of Symfony Console, but aims to separate the tool from the implementation details of Symfony.

Here are some of the guidelines you should follow to make the most of your efforts:

## Code Style Guidelines

Consolidation adheres to the [PSR-2 Coding Style Guide](http://www.php-fig.org/psr/psr-2/) for PHP code.

## Pull Request Guidelines

Every pull request is run through:

  - phpcs -n --standard=PSR2 src
  - phpunit
  - [Scrutinizer](https://scrutinizer-ci.com/g/consolidation-org/log/)
  
It is easy to run the unit tests and code sniffer locally; simply ensure that `./vendor/bin` is in your `$PATH`, cd to the root of the project directory, and run `phpcs` and `phpunit` as shown above.  To automatically fix coding standard errors, run:

  - phpcbf --standard=PSR2 src

After submitting a pull request, please examine the Scrutinizer report. It is not required to fix all Scrutinizer issues; you may ignore recommendations that you disagree with. The spacing patches produced by Scrutinizer do not conform to PSR2 standards, and therefore should never be applied. DocBlock patches may be applied at your discression. Things that Scrutinizer identifies as a bug nearly always needs to be addressed.

Pull requests must pass phpcs and phpunit in order to be merged; ideally, new functionality will also include new unit tests.
