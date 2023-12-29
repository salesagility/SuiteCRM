# Consolidation\Log

Improved [PSR-3](http://www.php-fig.org/psr/psr-3/) [Psr\Log](https://github.com/php-fig/log) logger based on Symfony Console components.

[![ci](https://github.com/consolidation/log/workflows/CI/badge.svg)](https://travis-ci.org/consolidation/log)
[![scrutinizer](https://scrutinizer-ci.com/g/consolidation/log/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/consolidation/log/?branch=master)
[![codecov](https://codecov.io/gh/consolidation/log/branch/main/graph/badge.svg?token=CAaB7ofhxx)](https://codecov.io/gh/consolidation/log)
[![license](https://poser.pugx.org/consolidation/log/license)](https://packagist.org/packages/consolidation/log)

## Component Status

In use in [Robo](https://github.com/Codegyre/Robo).

## Motivation

Consolidation\Log provides a PSR-3 compatible logger that provides styled log output to the standard error (stderr) stream. By default, styling is provided by the SymfonyStyle class from the Symfony Console component; however, alternative stylers may be provided if desired.

## Usage
```
$logger = new \Consolidation\Log\Logger($output);
$logger->setLogOutputStyler(new LogOutputStyler()); // optional
$logger->warning('The file {name} does not exist.', ['name' => $filename]);
```
String interpolation -- that is, the substitution of replacements, such as `{name}` in the example above, is not required by PSR-3, and is not implemented by default in the Psr\Log project. However, it is recommended by PRS-3, and is often done, e.g. in the Symfony Console logger.

Consolidation\Log supports string interpolation.

A logger manager can be used to delegate all log messages to one or more loggers.
```
$logger = new \Consolidation\Log\LoggerManager();
$logger->add('default', new \Consolidation\Log\Logger($output));
```
This is useful if, for example, you need to inject a logger into application objects early (e.g. into a dependency injection container), but the output object to log to will not be available until later.

## Comparison to Existing Solutions

Many Symfony Console compoenents use SymfonyStyle to format their output messages. This helper class has methods named things like `success` and `warning`, making it seem like a natural choice for reporting status.

However, in practice it is much more convenient to use an actual Psr-3 logger for logging. Doing this allows a Symfony Console component to call an external library that may not need to depend on Symfony Style.  Having the Psr\Log\LoggerInterface serve as the only shared IO-related interface in common between the console tool and the libraries it depends on promots loose coupling, allowing said libraries to be re-used in other contexts which may wish to log in different ways.

Symfony Console provides the ConsoleLogger to fill this need; however, ConsoleLogger does not provide any facility for styling output, leaving SymfonyStyle as the preferred logging mechanism for style-conscienscious console coders.

Consolidation\Log provides the benefits of both classes, allowing for code that both behaved technically correctly (redirecting to stderr) without sacrificing on style.

Monolog also provides a full-featured Console logger that might be applicable for some use cases.
