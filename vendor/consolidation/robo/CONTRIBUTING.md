# Contributing to Robo

Thank you for your interest in contributing to Robo! Here are some of the guidelines you should follow to make the most of your efforts:

## Code Style Guidelines

Robo adheres to the [PSR-2 Coding Style Guide](https://www.php-fig.org/psr/psr-2/) for PHP code. An `.editorconfig` file is included with the repository to help you get up and running quickly. Most modern editors support this standard, but if yours does not or you would like to configure your editor manually, follow the guidelines in the document linked above.

You can run the PHP Codesniffer on your work using a convenient command built into this project's own `RoboFile.php`:
```
robo sniff src/Foo.php --autofix
```
The above will run the PHP Codesniffer on the `src/Foo.php` file and automatically correct variances from the PSR-2 standard. Please ensure all contributions are compliant _before_ submitting a pull request.

## Tests

Note that in the past, Robo used Codeception / Aspect Mock etc. in its unit tests. These components proved to be difficult to maintain when testing on mutiple PHP versions, so they were removed. The tests formerly in tests/cli were all ported to straight phpunit tests in the tests/integration directory. Some of the unit tests from tests/unit were ported to tests/phpunit; however, a number of tests that still use AspectMock still exist in tests/unit, although these are not currently being used.

Pull requests that touch parts of the code formerly tested by these disabled tests must also convert the AspectMock test to Prophecy or some other mocking system. Alternately, getting AspectMock working again on the master and 1.x branches is another option, if someone wants to stand up to do that work.
