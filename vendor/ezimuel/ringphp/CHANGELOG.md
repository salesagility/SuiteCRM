# Changelog


All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [1.2.1] - 2022-10-25

- Fixed the support of PHP 8.1 with [#7](https://github.com/ezimuel/ringphp/pull/7) and [#8](https://github.com/ezimuel/ringphp/pull/8)
- Fixed the integration with Symfony, adding explicit @return annotations to suppress User Deprecated notices [#5](https://github.com/ezimuel/ringphp/pull/5)

## [1.2.0] - 2021-11-16

### Added

- Add attribute to avoid Deprecated notice for PHP 8.1 [#4](https://github.com/ezimuel/ringphp/pull/4)
- Add replace guzzlehttp/ringphp in composer [#3](https://github.com/ezimuel/ringphp/pull/3)
- Add .gitattributes file [#2](https://github.com/ezimuel/ringphp/pull/2)

### Changed

- Updated to PHPUnit 9 and fixed the unit tests for PHP 8
  [d386b25](https://github.com/ezimuel/ringphp/commit/d386b2597389dafe3b437ab90d115eb092fff109)

## [1.1.2] - 2020-02-15

### Changed

- Required guzzlestreams 3.0.1+ [0b78f89](https://github.com/ezimuel/ringphp/commit/0b78f89d8e0bb9e380046c31adfa40347e9f663b)


## [1.1.1] - 2018-07-31

### Fixed

- `continue` keyword usage on PHP 7.3


## [1.1.0] - 2015-05-19

### Added

- Added `CURL_HTTP_VERSION_2_0`

### Changed

- The PHP stream wrapper handler now sets `allow_self_signed` to `false` to
  match the cURL handler when `verify` is set to `true` or a certificate file.
- Ensuring that a directory exists before using the `save_to` option.
- Response protocol version is now correctly extracted from a response.

### Fixed

- Fixed a bug in which the result of `CurlFactory::retryFailedRewind` did not
  return an array.


## [1.0.7] - 2015-03-29

### Fixed

- PHP 7 fixes.


## [1.0.6] - 2015-02-26

### Changed

- The multi handle of the CurlMultiHandler is now created lazily.

### Fixed

- Bug fix: futures now extend from React's PromiseInterface to ensure that they
  are properly forwarded down the promise chain.


## [1.0.5] - 2014-12-10

### Added

- Adding more error information to PHP stream wrapper exceptions.
- Added digest auth integration test support to test server.


## [1.0.4] - 2014-12-01

### Added

- Added support for older versions of cURL that do not have CURLOPT_TIMEOUT_MS.
- Added a fix to the StreamHandler to return a `FutureArrayInterface` when an

### Changed

- Setting debug to `false` does not enable debug output. error occurs.


## [1.0.3] - 2014-11-03

### Fixed

- Setting the `header` stream option as a string to be compatible with GAE.
- Header parsing now ensures that header order is maintained in the parsed
  message.


## [1.0.2] - 2014-10-28

### Fixed

- Now correctly honoring a `version` option is supplied in a request.
  See https://github.com/guzzle/RingPHP/pull/8


## [1.0.1] - 2014-10-26

### Fixed

- Fixed a header parsing issue with the `CurlHandler` and `CurlMultiHandler`
  that caused cURL requests with multiple responses to merge repsonses together
  (e.g., requests with digest authentication).


## 1.0.0 - 2014-10-12

- Initial release


[Unreleased]: https://github.com/guzzle/RingPHP/compare/1.1.1...HEAD
[1.1.1]: https://github.com/guzzle/RingPHP/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/guzzle/RingPHP/compare/1.0.7...1.1.0
[1.0.7]: https://github.com/guzzle/RingPHP/compare/1.0.6...1.0.7
[1.0.6]: https://github.com/guzzle/RingPHP/compare/1.0.5...1.0.6
[1.0.5]: https://github.com/guzzle/RingPHP/compare/1.0.4...1.0.5
[1.0.4]: https://github.com/guzzle/RingPHP/compare/1.0.3...1.0.4
[1.0.3]: https://github.com/guzzle/RingPHP/compare/1.0.2...1.0.3
[1.0.2]: https://github.com/guzzle/RingPHP/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/guzzle/RingPHP/compare/1.0.0...1.0.1
