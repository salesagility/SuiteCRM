# Architecture

The general pattern of usage is to instantiate the `ReCaptcha` class with your
secret key, specify any additional validation rules, and then call `verify()`
with the reCAPTCHA response and user's IP address. For example:

```php
<?php
$recaptcha = new \ReCaptcha\ReCaptcha($secret);
$resp = $recaptcha->setExpectedHostname('recaptcha-demo.appspot.com')
                  ->verify($gRecaptchaResponse, $remoteIp);
if ($resp->isSuccess()) {
    // Verified!
} else {
    $errors = $resp->getErrorCodes();
}
```

By default, this will use the
[`stream_context_create()`](https://secure.php.net/stream_context_create) and
[`file_get_contents()`](https://secure.php.net/file_get_contents) to make a POST
request to the reCAPTCHA service. This is handled by the
[`RequestMethod\Post`](./src/ReCaptcha/RequestMethod/Post.php) class.

## Alternate request methods

You may need to use other methods for making requests in your environment. The
[`ReCaptcha`](./src/ReCaptcha/ReCaptcha.php) class allows an optional
[`RequestMethod`](./src/ReCaptcha/RequestMethod.php) instance to configure this.
For example, if you want to use [cURL](https://secure.php.net/curl) instead you
can do this:

```php
<?php
$recaptcha = new \ReCaptcha\ReCaptcha($secret, new \ReCaptcha\RequestMethod\CurlPost());
```

Alternatively, you can also use a [socket](https://secure.php.net/fsockopen):

```php
<?php
$recaptcha = new \ReCaptcha\ReCaptcha($secret, new \ReCaptcha\RequestMethod\SocketPost());
```

## Adding new request methods

Create a class that implements the
[`RequestMethod`](./src/ReCaptcha/RequestMethod.php) interface. The convention
is to name this class `RequestMethod\`_MethodType_`Post` and create a separate
`RequestMethod\`_MethodType_ class that wraps just the calls to the network
calls themselves. This means that the `RequestMethod\`_MethodType_`Post` can be
unit tested by passing in a mock. Take a look at
[`RequestMethod\CurlPost`](./src/ReCaptcha/RequestMethod/CurlPost.php) and
[`RequestMethod\Curl`](./src/ReCaptcha/RequestMethod/Curl.php) with the matching
[`RequestMethod/CurlPostTest`](./tests/ReCaptcha/RequestMethod/CurlPostTest.php)
to see this pattern in action.

### Error conventions

The client returns the response as provided by the reCAPTCHA services augmented
with additional error codes based on the client's checks. When adding a new
[`RequestMethod`](./src/ReCaptcha/RequestMethod.php) ensure that it returns the
`ReCaptcha::E_CONNECTION_FAILED` and `ReCaptcha::E_BAD_RESPONSE` where
appropriate.
