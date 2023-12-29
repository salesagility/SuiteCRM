# Changelog
This project versioning adheres to [Semantic Versioning](http://semver.org/).

## Unreleased

## 1.7.1 - 2019-06-13
### Fixed
- Error `Call to a member function toArray()` if capabilities were already converted to an array.
- Temporarily do not send capabilities to disable W3C WebDriver protocol when BrowserStack hub is used.

## 1.7.0 - 2019-06-10
### Added
- `WebDriverCheckboxes` and `WebDriverRadios` helper classes to simplify interaction with checkboxes and radio buttons.

### Fixed
- Stop sending null values in Cookie object, which is against the protocol and may cause request to remote ends to fail.

### Changed
- Force Chrome to not use W3C WebDriver protocol.
- Add workaround for Chromedriver bug [2943](https://bugs.chromium.org/p/chromedriver/issues/detail?id=2943) which breaks the protocol in Chromedriver 75.

## 1.6.0 - 2018-05-16
### Added
- Connection and request timeouts could be specified also when creating RemoteWebDriver from existing session ID.
- Update PHPDoc for functions that return static instances of a class.

### Changed
- Disable sending 'Expect: 100-Continue' header with POST requests, as they may more easily fail when sending via eg. squid proxy.

## 1.5.0 - 2017-11-15
### Changed
- Drop PHP 5.5 support, the minimal required version of PHP is now PHP 5.6.
- Allow installation of Symfony 4 components.

### Added
- Add a `visibilityOfAnyElementsLocated()` method to `WebDriverExpectedCondition`.

## 1.4.1 - 2017-04-28
### Fixed
- Do not throw notice `Constant CURLOPT_CONNECTTIMEOUT_MS already defined`.

## 1.4.0 - 2017-03-22
### Changed
- Cookies should now be set using `Cookie` value object instead of an array when passed to to `addCookie()` method of `WebDriverOptions`.
- Cookies retrieved using `getCookieNamed()` and `getCookies()` methods of `WebDriverOptions` are now encapsulated in `Cookie` object instead of an plain array. The object implements `ArrayAccess` interface to provide backward compatibility.
- `ext-zip` is now specified as required dependency in composer.json (but the extension was already required by the code, though).
- Deprecate `WebDriverCapabilities::isJavascriptEnabled()` method.
- Deprecate `textToBePresentInElementValue` expected condition in favor of `elementValueContains`.

### Fixed
- Do not throw fatal error when `null` is passed to `sendKeys()`.

## 1.3.0 - 2017-01-13
### Added
- Added `getCapabilities()` method of `RemoteWebDriver`, to retrieve actual capabilities acknowledged by the remote driver on startup.
- Added option to pass required capabilities when creating `RemoteWebDriver`. (So far only desired capabilities were supported.)
- Added new expected conditions:
    - `urlIs` - current URL exactly equals given value
    - `urlContains` - current URL contains given text
    - `urlMatches` - current URL matches regular expression
    - `titleMatches` - current page title matches regular expression
    - `elementTextIs` - text in element exactly equals given text
    - `elementTextContains` (as an alias for `textToBePresentInElement`) - text in element contains given text
    - `elementTextMatches` - text in element matches regular expression
    - `numberOfWindowsToBe` - number of opened windows equals given number
- Possibility to select option of `<select>` by its partial text (using `selectByVisiblePartialText()`).
- `XPathEscaper` helper class to quote XPaths containing both single and double quotes.
- `WebDriverSelectInterface`, to allow implementation of custom select-like components, eg. those not built around and actual select tag.

### Changed
- `Symfony\Process` is used to start local WebDriver processes (when browsers are run directly, without Selenium server) to workaround some PHP bugs and improve portability.
- Clarified meaning of selenium server URL variable in methods of `RemoteWebDriver` class.
- Deprecated `setSessionID()` and `setCommandExecutor()` methods of `RemoteWebDriver` class; these values should be immutable and thus passed only via constructor.
- Deprecated `WebDriverExpectedCondition::textToBePresentInElement()` in favor of `elementTextContains()`.
- Throw an exception when attempting to deselect options of non-multiselect (it already didn't have any effect, but was silently ignored).
- Optimize performance of `(de)selectByIndex()` and `getAllSelectedOptions()` methods of `WebDriverSelect` when used with non-multiple select element.

### Fixed
- XPath escaping in `select*()` and `deselect*()` methods of `WebDriverSelect`.

## 1.2.0 - 2016-10-14
- Added initial support of remote Microsoft Edge browser (but starting local EdgeDriver is still not supported).
- Utilize late static binding to make eg. `WebDriverBy` and `DesiredCapabilities` classes easily extensible.
- PHP version at least 5.5 is required.
- Fixed incompatibility with Appium, caused by redundant params present in requests to Selenium server.

## 1.1.3 - 2016-08-10
- Fixed FirefoxProfile to support installation of extensions with custom namespace prefix in their manifest file.
- Comply codestyle with [PSR-2](http://www.php-fig.org/psr/psr-2/).

## 1.1.2 - 2016-06-04
- Added ext-curl to composer.json.
- Added CHANGELOG.md.
- Added CONTRIBUTING.md with information and rules for contributors.

## 1.1.1 - 2015-12-31
- Fixed strict standards error in `ChromeDriver`.
- Added unit tests for `WebDriverCommand` and `DesiredCapabilities`.
- Fixed retrieving temporary path name in `FirefoxDriver` when `open_basedir` restriction is in effect.

## 1.1.0 - 2015-12-08
- FirefoxProfile improved - added possibility to set RDF file and to add datas for extensions.
- Fixed setting 0 second timeout of `WebDriverWait`.
