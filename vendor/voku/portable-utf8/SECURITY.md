# Security Policy

## Supported Versions

Please use the latest release you can find in the CHANGELOG.md.

## Reporting a Vulnerability

Please disclose any vulnerabilities found responsibly - report any security problems found to the maintainers privately. 
For example you can write me a email: lars@moelleken.org

## Known vulnerabilities

Portable UTF-8 versions prior to 5.4.26 (released 2019-11-05) have an open redirect vulnerability. The `Bootup::filterRequestUri()` method used a unsecure `header('Location ...` implentation. And because it's most secure to not use this method at all, I decided to disable the function by default.
