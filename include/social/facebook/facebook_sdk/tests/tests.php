<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

class PHPSDKTestCase extends PHPUnit_Framework_TestCase {
  const APP_ID = '117743971608120';
  const SECRET = '9c8ea2071859659bea1246d33a9207cf';

  const MIGRATED_APP_ID = '174236045938435';
  const MIGRATED_SECRET = '0073dce2d95c4a5c2922d1827ea0cca6';

  const TEST_USER   = 499834690;
  const TEST_USER_2 = 499835484;

  private static $kExpiredAccessToken = 'AAABrFmeaJjgBAIshbq5ZBqZBICsmveZCZBi6O4w9HSTkFI73VMtmkL9jLuWsZBZC9QMHvJFtSulZAqonZBRIByzGooCZC8DWr0t1M4BL9FARdQwPWPnIqCiFQ';

  private static function kValidSignedRequest($id = self::TEST_USER, $oauth_token = null) {
    $facebook = new FBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    return $facebook->publicMakeSignedRequest(
      array(
        'user_id' => $id,
        'oauth_token' => $oauth_token
      )
    );
  }

  private static function kNonTosedSignedRequest() {
    $facebook = new FBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    return $facebook->publicMakeSignedRequest(array());
  }

  private static function kSignedRequestWithEmptyValue() {
    return '';
  }

  private static function kSignedRequestWithBogusSignature() {
    $facebook = new FBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => 'bogus',
    ));
    return $facebook->publicMakeSignedRequest(
      array(
        'algorithm' => 'HMAC-SHA256',
      )
    );
  }

  private static function kSignedRequestWithWrongAlgo() {
    $facebook = new FBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $data['algorithm'] = 'foo';
    $json = json_encode($data);
    $b64 = $facebook->publicBase64UrlEncode($json);
    $raw_sig = hash_hmac('sha256', $b64, self::SECRET, $raw = true);
    $sig = $facebook->publicBase64UrlEncode($raw_sig);
    return $sig.'.'.$b64;
  }

  public function testConstructor() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $this->assertEquals($facebook->getAppId(), self::APP_ID,
                        'Expect the App ID to be set.');
    $this->assertEquals($facebook->getAppSecret(), self::SECRET,
                        'Expect the API secret to be set.');
  }

  public function testConstructorWithFileUpload() {
    $facebook = new TransientFacebook(array(
      'appId'      => self::APP_ID,
      'secret'     => self::SECRET,
      'fileUpload' => true,
    ));
    $this->assertEquals($facebook->getAppId(), self::APP_ID,
                        'Expect the App ID to be set.');
    $this->assertEquals($facebook->getAppSecret(), self::SECRET,
                        'Expect the API secret to be set.');
    $this->assertTrue($facebook->getFileUploadSupport(),
                      'Expect file upload support to be on.');
    // alias (depricated) for getFileUploadSupport -- test until removed
    $this->assertTrue($facebook->useFileUploadSupport(),
                      'Expect file upload support to be on.');
  }

  public function testSetAppId() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $facebook->setAppId('dummy');
    $this->assertEquals($facebook->getAppId(), 'dummy',
                        'Expect the App ID to be dummy.');
  }

  public function testSetAPISecret() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $facebook->setApiSecret('dummy');
    $this->assertEquals($facebook->getApiSecret(), 'dummy',
                        'Expect the API secret to be dummy.');
  }

  public function testSetAPPSecret() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $facebook->setAppSecret('dummy');
    $this->assertEquals($facebook->getAppSecret(), 'dummy',
                        'Expect the API secret to be dummy.');
  }

  public function testSetAccessToken() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $facebook->setAccessToken('saltydog');
    $this->assertEquals($facebook->getAccessToken(), 'saltydog',
                        'Expect installed access token to remain \'saltydog\'');
  }

  public function testSetFileUploadSupport() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $this->assertFalse($facebook->getFileUploadSupport(),
                       'Expect file upload support to be off.');
    // alias for getFileUploadSupport (depricated), testing until removed
    $this->assertFalse($facebook->useFileUploadSupport(),
                       'Expect file upload support to be off.');
    $facebook->setFileUploadSupport(true);
    $this->assertTrue($facebook->getFileUploadSupport(),
                      'Expect file upload support to be on.');
    // alias for getFileUploadSupport (depricated), testing until removed
    $this->assertTrue($facebook->useFileUploadSupport(),
                      'Expect file upload support to be on.');
  }

  public function testGetCurrentURL() {
    $facebook = new FBGetCurrentURLFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    // fake the HPHP $_SERVER globals
    $_SERVER['HTTP_HOST'] = 'www.test.com';
    $_SERVER['REQUEST_URI'] = '/unit-tests.php?one=one&two=two&three=three';
    $current_url = $facebook->publicGetCurrentUrl();
    $this->assertEquals(
      'http://www.test.com/unit-tests.php?one=one&two=two&three=three',
      $current_url,
      'getCurrentUrl function is changing the current URL');

    // ensure structure of valueless GET params is retained (sometimes
    // an = sign was present, and sometimes it was not)
    // first test when equal signs are present
    $_SERVER['HTTP_HOST'] = 'www.test.com';
    $_SERVER['REQUEST_URI'] = '/unit-tests.php?one=&two=&three=';
    $current_url = $facebook->publicGetCurrentUrl();
    $this->assertEquals(
      'http://www.test.com/unit-tests.php?one=&two=&three=',
      $current_url,
      'getCurrentUrl function is changing the current URL');

    // now confirm that
    $_SERVER['HTTP_HOST'] = 'www.test.com';
    $_SERVER['REQUEST_URI'] = '/unit-tests.php?one&two&three';
    $current_url = $facebook->publicGetCurrentUrl();
    $this->assertEquals(
      'http://www.test.com/unit-tests.php?one&two&three',
      $current_url,
      'getCurrentUrl function is changing the current URL');
  }

  public function testGetLoginURL() {
    $facebook = new Facebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    // fake the HPHP $_SERVER globals
    $_SERVER['HTTP_HOST'] = 'www.test.com';
    $_SERVER['REQUEST_URI'] = '/unit-tests.php';
    $login_url = parse_url($facebook->getLoginUrl());
    $this->assertEquals($login_url['scheme'], 'https');
    $this->assertEquals($login_url['host'], 'www.facebook.com');
    $this->assertEquals($login_url['path'], '/dialog/oauth');
    $expected_login_params =
      array('client_id' => self::APP_ID,
            'redirect_uri' => 'http://www.test.com/unit-tests.php');

    $query_map = array();
    parse_str($login_url['query'], $query_map);
    $this->assertIsSubset($expected_login_params, $query_map);
    // we don't know what the state is, but we know it's an md5 and should
    // be 32 characters long.
    $this->assertEquals(strlen($query_map['state']), $num_characters = 32);
  }

  public function testGetLoginURLWithExtraParams() {
    $facebook = new Facebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    // fake the HPHP $_SERVER globals
    $_SERVER['HTTP_HOST'] = 'www.test.com';
    $_SERVER['REQUEST_URI'] = '/unit-tests.php';
    $extra_params = array('scope' => 'email, sms',
                          'nonsense' => 'nonsense');
    $login_url = parse_url($facebook->getLoginUrl($extra_params));
    $this->assertEquals($login_url['scheme'], 'https');
    $this->assertEquals($login_url['host'], 'www.facebook.com');
    $this->assertEquals($login_url['path'], '/dialog/oauth');
    $expected_login_params =
      array_merge(
        array('client_id' => self::APP_ID,
              'redirect_uri' => 'http://www.test.com/unit-tests.php'),
        $extra_params);
    $query_map = array();
    parse_str($login_url['query'], $query_map);
    $this->assertIsSubset($expected_login_params, $query_map);
    // we don't know what the state is, but we know it's an md5 and should
    // be 32 characters long.
    $this->assertEquals(strlen($query_map['state']), $num_characters = 32);
  }

  public function testGetLoginURLWithScopeParamsAsArray() {
    $facebook = new Facebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    // fake the HPHP $_SERVER globals
    $_SERVER['HTTP_HOST'] = 'www.test.com';
    $_SERVER['REQUEST_URI'] = '/unit-tests.php';
    $scope_params_as_array = array('email','sms','read_stream');
    $extra_params = array('scope' => $scope_params_as_array,
                          'nonsense' => 'nonsense');
    $login_url = parse_url($facebook->getLoginUrl($extra_params));
    $this->assertEquals($login_url['scheme'], 'https');
    $this->assertEquals($login_url['host'], 'www.facebook.com');
    $this->assertEquals($login_url['path'], '/dialog/oauth');
    // expect api to flatten array params to comma separated list
    // should do the same here before asserting to make sure API is behaving
    // correctly;
    $extra_params['scope'] = implode(',', $scope_params_as_array);
    $expected_login_params =
      array_merge(
        array('client_id' => self::APP_ID,
              'redirect_uri' => 'http://www.test.com/unit-tests.php'),
        $extra_params);
    $query_map = array();
    parse_str($login_url['query'], $query_map);
    $this->assertIsSubset($expected_login_params, $query_map);
    // we don't know what the state is, but we know it's an md5 and should
    // be 32 characters long.
    $this->assertEquals(strlen($query_map['state']), $num_characters = 32);
  }

  public function testGetCodeWithValidCSRFState() {
    $facebook = new FBCode(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $facebook->setCSRFStateToken();
    $code = $_REQUEST['code'] = $this->generateMD5HashOfRandomValue();
    $_REQUEST['state'] = $facebook->getCSRFStateToken();
    $this->assertEquals($code,
                        $facebook->publicGetCode(),
                        'Expect code to be pulled from $_REQUEST[\'code\']');
  }

  public function testGetCodeWithInvalidCSRFState() {
    $facebook = new FBCode(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $facebook->setCSRFStateToken();
    $code = $_REQUEST['code'] = $this->generateMD5HashOfRandomValue();
    $_REQUEST['state'] = $facebook->getCSRFStateToken().'forgery!!!';
    $this->assertFalse($facebook->publicGetCode(),
                       'Expect getCode to fail, CSRF state should not match.');
  }

  public function testGetCodeWithMissingCSRFState() {
    $facebook = new FBCode(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $code = $_REQUEST['code'] = $this->generateMD5HashOfRandomValue();
    // intentionally don't set CSRF token at all
    $this->assertFalse($facebook->publicGetCode(),
                       'Expect getCode to fail, CSRF state not sent back.');
  }

  public function testPersistentCSRFState()
  {
    $facebook = new FBCode(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $facebook->setCSRFStateToken();
    $code = $facebook->getCSRFStateToken();

    $facebook = new FBCode(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $this->assertEquals($code, $facebook->publicGetState(),
            'Persisted CSRF state token not loaded correctly');
  }

  public function testPersistentCSRFStateWithSharedSession()
  {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $facebook = new FBCode(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'sharedSession' => true,
    ));
    $facebook->setCSRFStateToken();
    $code = $facebook->getCSRFStateToken();

    $facebook = new FBCode(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'sharedSession' => true,
    ));

    $this->assertEquals($code, $facebook->publicGetState(),
            'Persisted CSRF state token not loaded correctly with shared session');
  }

  public function testGetUserFromSignedRequest() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $_REQUEST['signed_request'] = self::kValidSignedRequest();
    $this->assertEquals('499834690', $facebook->getUser(),
                        'Failed to get user ID from a valid signed request.');
  }

  public function testDisallowSignedRequest() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'allowSignedRequest' => false
    ));

    $_REQUEST['signed_request'] = self::kValidSignedRequest();
    $this->assertEquals(0, $facebook->getUser(),
        'Should not have received valid user from signed_request.');
  }


    public function testSignedRequestRewrite(){
    $facebook = new FBRewrite(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $_REQUEST['signed_request'] = self::kValidSignedRequest(self::TEST_USER, 'Hello sweetie');

    $this->assertEquals(self::TEST_USER, $facebook->getUser(),
                        'Failed to get user ID from a valid signed request.');

    $this->assertEquals('Hello sweetie', $facebook->getAccessToken(),
                        'Failed to get access token from signed request');

    $facebook->uncache();

    $_REQUEST['signed_request'] = self::kValidSignedRequest(self::TEST_USER_2, 'spoilers');

    $this->assertEquals(self::TEST_USER_2, $facebook->getUser(),
                        'Failed to get user ID from a valid signed request.');

    $_REQUEST['signed_request'] = null;
    $facebook ->uncacheSignedRequest();

    $this->assertNotEquals('Hello sweetie', $facebook->getAccessToken(),
                        'Failed to clear access token');
  }

  public function testGetSignedRequestFromCookie() {
    $facebook = new FBPublicCookie(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $_COOKIE[$facebook->publicGetSignedRequestCookieName()] =
      self::kValidSignedRequest();
    $this->assertNotNull($facebook->publicGetSignedRequest());
    $this->assertEquals('499834690', $facebook->getUser(),
                        'Failed to get user ID from a valid signed request.');
  }

  public function testGetSignedRequestWithIncorrectSignature() {
    $facebook = new FBPublicCookie(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $_COOKIE[$facebook->publicGetSignedRequestCookieName()] =
      self::kSignedRequestWithBogusSignature();
    $this->assertNull($facebook->publicGetSignedRequest());
  }

  public function testNonUserAccessToken() {
    $facebook = new FBAccessToken(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    // no cookies, and no request params, so no user or code,
    // so no user access token (even with cookie support)
    $this->assertEquals($facebook->publicGetApplicationAccessToken(),
                        $facebook->getAccessToken(),
                        'Access token should be that for logged out users.');
  }

  public function testMissingMetadataCookie() {
    $fb = new FBPublicCookie(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $this->assertEmpty($fb->publicGetMetadataCookie());
  }

  public function testEmptyMetadataCookie() {
    $fb = new FBPublicCookie(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $_COOKIE[$fb->publicGetMetadataCookieName()] = '';
    $this->assertEmpty($fb->publicGetMetadataCookie());
  }

  public function testMetadataCookie() {
    $fb = new FBPublicCookie(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $key = 'foo';
    $val = '42';
    $_COOKIE[$fb->publicGetMetadataCookieName()] = "$key=$val";
    $this->assertEquals(array($key => $val), $fb->publicGetMetadataCookie());
  }

  public function testQuotedMetadataCookie() {
    $fb = new FBPublicCookie(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $key = 'foo';
    $val = '42';
    $_COOKIE[$fb->publicGetMetadataCookieName()] = "\"$key=$val\"";
    $this->assertEquals(array($key => $val), $fb->publicGetMetadataCookie());
  }

  public function testAPIForLoggedOutUsers() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $response = $facebook->api(array(
      'method' => 'fql.query',
      'query' => 'SELECT name FROM user WHERE uid=4',
    ));
    $this->assertEquals(count($response), 1,
                        'Expect one row back.');
    $this->assertEquals($response[0]['name'], 'Mark Zuckerberg',
                        'Expect the name back.');
  }

  public function testAPIWithBogusAccessToken() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $facebook->setAccessToken('this-is-not-really-an-access-token');
    // if we don't set an access token and there's no way to
    // get one, then the FQL query below works beautifully, handing
    // over Zuck's public data.  But if you specify a bogus access
    // token as I have right here, then the FQL query should fail.
    // We could return just Zuck's public data, but that wouldn't
    // advertise the issue that the access token is at worst broken
    // and at best expired.
    try {
      $response = $facebook->api(array(
        'method' => 'fql.query',
        'query' => 'SELECT name FROM profile WHERE id=4',
      ));
      $this->fail('Should not get here.');
    } catch(FacebookApiException $e) {
      $result = $e->getResult();
      $this->assertTrue(is_array($result), 'expect a result object');
      $this->assertEquals('190', $result['error_code'], 'expect code');
    }
  }

  public function testAPIGraphPublicData() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $response = $facebook->api('/jerry');
    $this->assertEquals(
      $response['id'], '214707', 'should get expected id.');
  }

  public function testGraphAPIWithBogusAccessToken() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $facebook->setAccessToken('this-is-not-really-an-access-token');
    try {
      $response = $facebook->api('/me');
      $this->fail('Should not get here.');
    } catch(FacebookApiException $e) {
      // means the server got the access token and didn't like it
      $msg = 'OAuthException: Invalid OAuth access token.';
      $this->assertEquals($msg, (string) $e,
                          'Expect the invalid OAuth token message.');
    }
  }

  public function testGraphAPIWithExpiredAccessToken() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $facebook->setAccessToken(self::$kExpiredAccessToken);
    try {
      $response = $facebook->api('/me');
      $this->fail('Should not get here.');
    } catch(FacebookApiException $e) {
      // means the server got the access token and didn't like it
      $error_msg_start = 'OAuthException: Error validating access token:';
      $this->assertTrue(strpos((string) $e, $error_msg_start) === 0,
                        'Expect the token validation error message.');
    }
  }

  public function testGraphAPIOAuthSpecError() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::MIGRATED_APP_ID,
      'secret' => self::MIGRATED_SECRET,
    ));

    try {
      $response = $facebook->api('/me', array(
        'client_id' => self::MIGRATED_APP_ID));

      $this->fail('Should not get here.');
    } catch(FacebookApiException $e) {
      // means the server got the access token
      $msg = 'invalid_request: An active access token must be used '.
             'to query information about the current user.';
      $this->assertEquals($msg, (string) $e,
                          'Expect the invalid session message.');
    }
  }

  public function testGraphAPIMethodOAuthSpecError() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::MIGRATED_APP_ID,
      'secret' => self::MIGRATED_SECRET,
    ));

    try {
      $response = $facebook->api('/daaku.shah', 'DELETE', array(
        'client_id' => self::MIGRATED_APP_ID));
      $this->fail('Should not get here.');
    } catch(FacebookApiException $e) {
      $this->assertEquals(strpos($e, 'invalid_request'), 0);
    }
  }

  public function testCurlFailure() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    if (!defined('CURLOPT_TIMEOUT_MS')) {
      // can't test it if we don't have millisecond timeouts
      return;
    }

    $exception = null;
    try {
      // we dont expect facebook will ever return in 1ms
      Facebook::$CURL_OPTS[CURLOPT_TIMEOUT_MS] = 50;
      $facebook->api('/naitik');
    } catch(FacebookApiException $e) {
      $exception = $e;
    }
    unset(Facebook::$CURL_OPTS[CURLOPT_TIMEOUT_MS]);
    if (!$exception) {
      $this->fail('no exception was thrown on timeout.');
    }

    $code = $exception->getCode();
    if ($code != CURLE_OPERATION_TIMEOUTED && $code != CURLE_COULDNT_CONNECT) {
      $this->fail("Expected curl error code 7 or 28 but got: $code");
    }
    $this->assertEquals('CurlException', $exception->getType(), 'expect type');
  }

  public function testGraphAPIWithOnlyParams() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));

    $response = $facebook->api('/jerry');
    $this->assertTrue(isset($response['id']),
                      'User ID should be public.');
    $this->assertTrue(isset($response['name']),
                      'User\'s name should be public.');
    $this->assertTrue(isset($response['first_name']),
                      'User\'s first name should be public.');
    $this->assertTrue(isset($response['last_name']),
                      'User\'s last name should be public.');
    $this->assertFalse(isset($response['work']),
                       'User\'s work history should only be available with '.
                       'a valid access token.');
    $this->assertFalse(isset($response['education']),
                       'User\'s education history should only be '.
                       'available with a valid access token.');
    $this->assertFalse(isset($response['verified']),
                       'User\'s verification status should only be '.
                       'available with a valid access token.');
  }

  public function testLoginURLDefaults() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $_SERVER['REQUEST_URI'] = '/examples';
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $encodedUrl = rawurlencode('http://fbrell.com/examples');
    $this->assertNotNull(strpos($facebook->getLoginUrl(), $encodedUrl),
                         'Expect the current url to exist.');
  }

  public function testLoginURLDefaultsDropStateQueryParam() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $_SERVER['REQUEST_URI'] = '/examples?state=xx42xx';
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $expectEncodedUrl = rawurlencode('http://fbrell.com/examples');
    $this->assertTrue(strpos($facebook->getLoginUrl(), $expectEncodedUrl) > -1,
                      'Expect the current url to exist.');
    $this->assertFalse(strpos($facebook->getLoginUrl(), 'xx42xx'),
                       'Expect the session param to be dropped.');
  }

  public function testLoginURLDefaultsDropCodeQueryParam() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $_SERVER['REQUEST_URI'] = '/examples?code=xx42xx';
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $expectEncodedUrl = rawurlencode('http://fbrell.com/examples');
    $this->assertTrue(strpos($facebook->getLoginUrl(), $expectEncodedUrl) > -1,
                      'Expect the current url to exist.');
    $this->assertFalse(strpos($facebook->getLoginUrl(), 'xx42xx'),
                       'Expect the session param to be dropped.');
  }

  public function testLoginURLDefaultsDropSignedRequestParamButNotOthers() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $_SERVER['REQUEST_URI'] =
      '/examples?signed_request=xx42xx&do_not_drop=xx43xx';
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $expectEncodedUrl = rawurlencode('http://fbrell.com/examples');
    $this->assertFalse(strpos($facebook->getLoginUrl(), 'xx42xx'),
                       'Expect the session param to be dropped.');
    $this->assertTrue(strpos($facebook->getLoginUrl(), 'xx43xx') > -1,
                      'Expect the do_not_drop param to exist.');
  }

  public function testLoginURLCustomNext() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $_SERVER['REQUEST_URI'] = '/examples';
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $next = 'http://fbrell.com/custom';
    $loginUrl = $facebook->getLoginUrl(array(
      'redirect_uri' => $next,
      'cancel_url' => $next
    ));
    $currentEncodedUrl = rawurlencode('http://fbrell.com/examples');
    $expectedEncodedUrl = rawurlencode($next);
    $this->assertNotNull(strpos($loginUrl, $expectedEncodedUrl),
                         'Expect the custom url to exist.');
    $this->assertFalse(strpos($loginUrl, $currentEncodedUrl),
                      'Expect the current url to not exist.');
  }

  public function testLogoutURLDefaults() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $_SERVER['REQUEST_URI'] = '/examples';
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $encodedUrl = rawurlencode('http://fbrell.com/examples');
    $this->assertNotNull(strpos($facebook->getLogoutUrl(), $encodedUrl),
                         'Expect the current url to exist.');
    $this->assertFalse(strpos($facebook->getLogoutUrl(), self::SECRET));
  }

  public function testLoginStatusURLDefaults() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $_SERVER['REQUEST_URI'] = '/examples';
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $encodedUrl = rawurlencode('http://fbrell.com/examples');
    $this->assertNotNull(strpos($facebook->getLoginStatusUrl(), $encodedUrl),
                         'Expect the current url to exist.');
  }

  public function testLoginStatusURLCustom() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $_SERVER['REQUEST_URI'] = '/examples';
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $encodedUrl1 = rawurlencode('http://fbrell.com/examples');
    $okUrl = 'http://fbrell.com/here1';
    $encodedUrl2 = rawurlencode($okUrl);
    $loginStatusUrl = $facebook->getLoginStatusUrl(array(
      'ok_session' => $okUrl,
    ));
    $this->assertNotNull(strpos($loginStatusUrl, $encodedUrl1),
                         'Expect the current url to exist.');
    $this->assertNotNull(strpos($loginStatusUrl, $encodedUrl2),
                         'Expect the custom url to exist.');
  }

  public function testNonDefaultPort() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com:8080';
    $_SERVER['REQUEST_URI'] = '/examples';
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $encodedUrl = rawurlencode('http://fbrell.com:8080/examples');
    $this->assertNotNull(strpos($facebook->getLoginUrl(), $encodedUrl),
                         'Expect the current url to exist.');
  }

  public function testSecureCurrentUrl() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $_SERVER['REQUEST_URI'] = '/examples';
    $_SERVER['HTTPS'] = 'on';
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $encodedUrl = rawurlencode('https://fbrell.com/examples');
    $this->assertNotNull(strpos($facebook->getLoginUrl(), $encodedUrl),
                         'Expect the current url to exist.');
  }

  public function testSecureCurrentUrlWithNonDefaultPort() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com:8080';
    $_SERVER['REQUEST_URI'] = '/examples';
    $_SERVER['HTTPS'] = 'on';
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $encodedUrl = rawurlencode('https://fbrell.com:8080/examples');
    $this->assertNotNull(strpos($facebook->getLoginUrl(), $encodedUrl),
                         'Expect the current url to exist.');
  }

  public function testBase64UrlEncode() {
    $input = 'Facebook rocks';
    $output = 'RmFjZWJvb2sgcm9ja3M';

    $this->assertEquals(FBPublic::publicBase64UrlDecode($output), $input);
  }

  public function testSignedToken() {
    $facebook = new FBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $sr = self::kValidSignedRequest();
    $payload = $facebook->publicParseSignedRequest($sr);
    $this->assertNotNull($payload, 'Expected token to parse');
    $this->assertEquals($facebook->getSignedRequest(), null);
    $_REQUEST['signed_request'] = $sr;
    $this->assertEquals($facebook->getSignedRequest(), $payload);
  }

  public function testNonTossedSignedtoken() {
    $facebook = new FBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $payload = $facebook->publicParseSignedRequest(
      self::kNonTosedSignedRequest());
    $this->assertNotNull($payload, 'Expected token to parse');
    $this->assertNull($facebook->getSignedRequest());
    $_REQUEST['signed_request'] = self::kNonTosedSignedRequest();
    $sr = $facebook->getSignedRequest();
    $this->assertTrue(isset($sr['algorithm']));
  }

  public function testSignedRequestWithEmptyValue() {
    $fb = new FBPublicCookie(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $_REQUEST['signed_request'] = self::kSignedRequestWithEmptyValue();
    $this->assertNull($fb->getSignedRequest());
    $_COOKIE[$fb->publicGetSignedRequestCookieName()] =
      self::kSignedRequestWithEmptyValue();
    $this->assertNull($fb->getSignedRequest());
  }

  public function testSignedRequestWithWrongAlgo() {
    $fb = new FBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $payload = $fb->publicParseSignedRequest(
      self::kSignedRequestWithWrongAlgo());
    $this->assertNull($payload, 'Expected nothing back.');
  }

  public function testMakeAndParse() {
    $fb = new FBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $data = array('foo' => 42);
    $sr = $fb->publicMakeSignedRequest($data);
    $decoded = $fb->publicParseSignedRequest($sr);
    $this->assertEquals($data['foo'], $decoded['foo']);
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testMakeSignedRequestExpectsArray() {
    $fb = new FBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $sr = $fb->publicMakeSignedRequest('');
  }

  public function testBundledCACert() {
    $facebook = new TransientFacebook(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));

      // use the bundled cert from the start
    Facebook::$CURL_OPTS[CURLOPT_CAINFO] =
      dirname(__FILE__) . '/../src/fb_ca_chain_bundle.crt';
    $response = $facebook->api('/naitik');

    unset(Facebook::$CURL_OPTS[CURLOPT_CAINFO]);
    $this->assertEquals(
      $response['id'], '5526183', 'should get expected id.');
  }

  public function testVideoUpload() {
    $facebook = new FBRecordURL(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));

    $facebook->api(array('method' => 'video.upload'));
    $this->assertContains('//api-video.', $facebook->getRequestedURL(),
                          'video.upload should go against api-video');
  }

  public function testVideoUploadGraph() {
    $facebook = new FBRecordURL(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));

    $facebook->api('/me/videos', 'POST');
    $this->assertContains('//graph-video.', $facebook->getRequestedURL(),
                          '/me/videos should go against graph-video');
  }

  public function testGetUserAndAccessTokenFromSession() {
    $facebook = new PersistentFBPublic(array(
                                         'appId'  => self::APP_ID,
                                         'secret' => self::SECRET
                                       ));

    $facebook->publicSetPersistentData('access_token',
                                       self::$kExpiredAccessToken);
    $facebook->publicSetPersistentData('user_id', 12345);
    $this->assertEquals(self::$kExpiredAccessToken,
                        $facebook->getAccessToken(),
                        'Get access token from persistent store.');
    $this->assertEquals('12345',
                        $facebook->getUser(),
                        'Get user id from persistent store.');
  }

  public function testGetUserAndAccessTokenFromSignedRequestNotSession() {
    $facebook = new PersistentFBPublic(array(
                                         'appId'  => self::APP_ID,
                                         'secret' => self::SECRET
                                       ));

    $_REQUEST['signed_request'] = self::kValidSignedRequest();
    $facebook->publicSetPersistentData('user_id', 41572);
    $facebook->publicSetPersistentData('access_token',
                                       self::$kExpiredAccessToken);
    $this->assertNotEquals('41572', $facebook->getUser(),
                           'Got user from session instead of signed request.');
    $this->assertEquals('499834690', $facebook->getUser(),
                        'Failed to get correct user ID from signed request.');
    $this->assertNotEquals(
      self::$kExpiredAccessToken,
      $facebook->getAccessToken(),
      'Got access token from session instead of signed request.');
    $this->assertNotEmpty(
      $facebook->getAccessToken(),
      'Failed to extract an access token from the signed request.');
  }

  public function testGetUserWithoutCodeOrSignedRequestOrSession() {
    $facebook = new PersistentFBPublic(array(
                                         'appId'  => self::APP_ID,
                                         'secret' => self::SECRET
                                       ));

    // deliberately leave $_REQUEST and _$SESSION empty
    $this->assertEmpty($_REQUEST,
                       'GET, POST, and COOKIE params exist even though '.
                       'they should.  Test cannot succeed unless all of '.
                       '$_REQUEST is empty.');
    $this->assertEmpty($_SESSION,
                       'Session is carrying state and should not be.');
    $this->assertEmpty($facebook->getUser(),
                       'Got a user id, even without a signed request, '.
                       'access token, or session variable.');
    $this->assertEmpty($_SESSION,
                       'Session superglobal incorrectly populated by getUser.');
  }

  public function testGetAccessTokenUsingCodeInJsSdkCookie() {
    $code = 'code1';
    $access_token = 'at1';
    $methods_to_stub = array('getSignedRequest', 'getAccessTokenFromCode');
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $stub = $this->getMock(
      'TransientFacebook', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('getSignedRequest')
      ->will($this->returnValue(array('code' => $code)));
    $stub
      ->expects($this->once())
      ->method('getAccessTokenFromCode')
      ->will($this->returnValueMap(array(array($code, '', $access_token))));
    $this->assertEquals($stub->getAccessToken(), $access_token);
  }

  public function testSignedRequestWithoutAuthClearsData() {
    $methods_to_stub = array('getSignedRequest', 'clearAllPersistentData');
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $stub = $this->getMock(
      'TransientFacebook', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('getSignedRequest')
      ->will($this->returnValue(array('foo' => 1)));
    $stub
      ->expects($this->once())
      ->method('clearAllPersistentData');
    $this->assertEquals(self::APP_ID.'|'.self::SECRET, $stub->getAccessToken());
  }

  public function testInvalidCodeInSignedRequestWillClearData() {
    $code = 'code1';
    $methods_to_stub = array(
      'getSignedRequest',
      'getAccessTokenFromCode',
      'clearAllPersistentData',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $stub = $this->getMock(
      'TransientFacebook', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('getSignedRequest')
      ->will($this->returnValue(array('code' => $code)));
    $stub
      ->expects($this->once())
      ->method('getAccessTokenFromCode')
      ->will($this->returnValue(null));
    $stub
      ->expects($this->once())
      ->method('clearAllPersistentData');
    $this->assertEquals(self::APP_ID.'|'.self::SECRET, $stub->getAccessToken());
  }

  public function testInvalidCodeWillClearData() {
    $code = 'code1';
    $methods_to_stub = array(
      'getCode',
      'getAccessTokenFromCode',
      'clearAllPersistentData',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $stub = $this->getMock(
      'TransientFacebook', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('getCode')
      ->will($this->returnValue($code));
    $stub
      ->expects($this->once())
      ->method('getAccessTokenFromCode')
      ->will($this->returnValue(null));
    $stub
      ->expects($this->once())
      ->method('clearAllPersistentData');
    $this->assertEquals(self::APP_ID.'|'.self::SECRET, $stub->getAccessToken());
  }

  public function testValidCodeToToken() {
    $code = 'code1';
    $access_token = 'at1';
    $methods_to_stub = array(
      'getSignedRequest',
      'getCode',
      'getAccessTokenFromCode',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $stub = $this->getMock(
      'TransientFacebook', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('getCode')
      ->will($this->returnValue($code));
    $stub
      ->expects($this->once())
      ->method('getAccessTokenFromCode')
      ->will($this->returnValueMap(array(array($code, null, $access_token))));
    $this->assertEquals($stub->getAccessToken(), $access_token);
  }

  public function testSignedRequestWithoutAuthClearsDataInAvailData() {
    $methods_to_stub = array('getSignedRequest', 'clearAllPersistentData');
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $stub = $this->getMock(
      'TransientFacebook', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('getSignedRequest')
      ->will($this->returnValue(array('foo' => 1)));
    $stub
      ->expects($this->once())
      ->method('clearAllPersistentData');
    $this->assertEquals(0, $stub->getUser());
  }

  public function testFailedToGetUserFromAccessTokenClearsData() {
    $methods_to_stub = array(
      'getAccessToken',
      'getUserFromAccessToken',
      'clearAllPersistentData',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $stub = $this->getMock(
      'TransientFacebook', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('getAccessToken')
      ->will($this->returnValue('at1'));
    $stub
      ->expects($this->once())
      ->method('getUserFromAccessToken');
    $stub
      ->expects($this->once())
      ->method('clearAllPersistentData');
    $this->assertEquals(0, $stub->getUser());
  }

  public function testUserFromAccessTokenIsStored() {
    $methods_to_stub = array(
      'getAccessToken',
      'getUserFromAccessToken',
      'setPersistentData',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $user = 42;
    $stub = $this->getMock(
      'TransientFacebook', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('getAccessToken')
      ->will($this->returnValue('at1'));
    $stub
      ->expects($this->once())
      ->method('getUserFromAccessToken')
      ->will($this->returnValue($user));
    $stub
      ->expects($this->once())
      ->method('setPersistentData');
    $this->assertEquals($user, $stub->getUser());
  }

  public function testUserFromAccessTokenPullsID() {
    $methods_to_stub = array(
      'getAccessToken',
      'api',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $user = 42;
    $stub = $this->getMock(
      'TransientFacebook', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('getAccessToken')
      ->will($this->returnValue('at1'));
    $stub
      ->expects($this->once())
      ->method('api')
      ->will($this->returnValue(array('id' => $user)));
    $this->assertEquals($user, $stub->getUser());
  }

  public function testUserFromAccessTokenResetsOnApiException() {
    $methods_to_stub = array(
      'getAccessToken',
      'clearAllPersistentData',
      'api',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $stub = $this->getMock(
      'TransientFacebook', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('getAccessToken')
      ->will($this->returnValue('at1'));
    $stub
      ->expects($this->once())
      ->method('api')
      ->will($this->throwException(new FacebookApiException(false)));
    $stub
      ->expects($this->once())
      ->method('clearAllPersistentData');
    $this->assertEquals(0, $stub->getUser());
  }

  public function testEmptyCodeReturnsFalse() {
    $fb = new FBPublicGetAccessTokenFromCode(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $this->assertFalse($fb->publicGetAccessTokenFromCode(''));
    $this->assertFalse($fb->publicGetAccessTokenFromCode(null));
    $this->assertFalse($fb->publicGetAccessTokenFromCode(false));
  }

  public function testNullRedirectURIUsesCurrentURL() {
    $methods_to_stub = array(
      '_oauthRequest',
      'getCurrentUrl',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $access_token = 'at1';
    $stub = $this->getMock(
      'FBPublicGetAccessTokenFromCode', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('_oauthRequest')
      ->will($this->returnValue("access_token=$access_token"));
    $stub
      ->expects($this->once())
      ->method('getCurrentUrl');
    $this->assertEquals(
      $access_token, $stub->publicGetAccessTokenFromCode('c'));
  }

  public function testNullRedirectURIAllowsEmptyStringForCookie() {
    $methods_to_stub = array(
      '_oauthRequest',
      'getCurrentUrl',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $access_token = 'at1';
    $stub = $this->getMock(
      'FBPublicGetAccessTokenFromCode', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('_oauthRequest')
      ->will($this->returnValue("access_token=$access_token"));
    $stub
      ->expects($this->never())
      ->method('getCurrentUrl');
    $this->assertEquals(
      $access_token, $stub->publicGetAccessTokenFromCode('c', ''));
  }

  public function testAPIExceptionDuringCodeExchangeIsIgnored() {
    $methods_to_stub = array(
      '_oauthRequest',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $stub = $this->getMock(
      'FBPublicGetAccessTokenFromCode', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('_oauthRequest')
      ->will($this->throwException(new FacebookApiException(false)));
    $this->assertFalse($stub->publicGetAccessTokenFromCode('c', ''));
  }

  public function testEmptyResponseInCodeExchangeIsIgnored() {
    $methods_to_stub = array(
      '_oauthRequest',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $stub = $this->getMock(
      'FBPublicGetAccessTokenFromCode', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('_oauthRequest')
      ->will($this->returnValue(''));
    $this->assertFalse($stub->publicGetAccessTokenFromCode('c', ''));
  }

  public function testExistingStateRestoredInConstructor() {
    $fb = new FBPublicState(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $this->assertEquals(FBPublicState::STATE, $fb->publicGetState());
  }

  public function testMissingAccessTokenInCodeExchangeIsIgnored() {
    $methods_to_stub = array(
      '_oauthRequest',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $stub = $this->getMock(
      'FBPublicGetAccessTokenFromCode', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('_oauthRequest')
      ->will($this->returnValue('foo=1'));
    $this->assertFalse($stub->publicGetAccessTokenFromCode('c', ''));
  }

  public function testAppsecretProofNoParams() {
    $fb = new FBRecordMakeRequest(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $token = $fb->getAccessToken();
    $proof = $fb->publicGetAppSecretProof($token);
    $params = array();
    $fb->api('/mattynoce', $params);
    $requests = $fb->publicGetRequests();
    $this->assertEquals($proof, $requests[0]['params']['appsecret_proof']);
  }

  public function testAppsecretProofWithParams() {
    $fb = new FBRecordMakeRequest(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $proof = 'foo';
    $params = array('appsecret_proof' => $proof);
    $fb->api('/mattynoce', $params);
    $requests = $fb->publicGetRequests();
    $this->assertEquals($proof, $requests[0]['params']['appsecret_proof']);
  }

  public function testExceptionConstructorWithErrorCode() {
    $code = 404;
    $e = new FacebookApiException(array('error_code' => $code));
    $this->assertEquals($code, $e->getCode());
  }

  public function testExceptionConstructorWithInvalidErrorCode() {
    $e = new FacebookApiException(array('error_code' => 'not an int'));
    $this->assertEquals(0, $e->getCode());
  }

  // this happens often despite the fact that it is useless
  public function testExceptionTypeFalse() {
    $e = new FacebookApiException(false);
    $this->assertEquals('Exception', $e->getType());
  }

  public function testExceptionTypeMixedDraft00() {
    $e = new FacebookApiException(array('error' => array('message' => 'foo')));
    $this->assertEquals('Exception', $e->getType());
  }

  public function testExceptionTypeDraft00() {
    $error = 'foo';
    $e = new FacebookApiException(
      array('error' => array('type' => $error, 'message' => 'hello world')));
    $this->assertEquals($error, $e->getType());
  }

  public function testExceptionTypeDraft10() {
    $error = 'foo';
    $e = new FacebookApiException(array('error' => $error));
    $this->assertEquals($error, $e->getType());
  }

  public function testExceptionTypeDefault() {
    $e = new FacebookApiException(array('error' => false));
    $this->assertEquals('Exception', $e->getType());
  }

  public function testExceptionToString() {
    $e = new FacebookApiException(array(
      'error_code' => 1,
      'error_description' => 'foo',
    ));
    $this->assertEquals('Exception: 1: foo', (string) $e);
  }

  public function testDestroyClearsCookie() {
    $fb = new FBPublicCookie(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $_COOKIE[$fb->publicGetSignedRequestCookieName()] = 'foo';
    $_COOKIE[$fb->publicGetMetadataCookieName()] = 'base_domain=fbrell.com';
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $fb->destroySession();
    $this->assertFalse(
      array_key_exists($fb->publicGetSignedRequestCookieName(), $_COOKIE));
  }

  public function testAuthExpireSessionDestroysSession() {
    $methods_to_stub = array(
      '_oauthRequest',
      'destroySession',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $key = 'foo';
    $val = 42;
    $stub = $this->getMock(
      'TransientFacebook', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('_oauthRequest')
      ->will($this->returnValue("{\"$key\":$val}"));
    $stub
      ->expects($this->once())
      ->method('destroySession');
    $this->assertEquals(
      array($key => $val),
      $stub->api(array('method' => 'auth.expireSession'))
    );
  }

  public function testLowercaseAuthRevokeAuthDestroysSession() {
    $methods_to_stub = array(
      '_oauthRequest',
      'destroySession',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $key = 'foo';
    $val = 42;
    $stub = $this->getMock(
      'TransientFacebook', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('_oauthRequest')
      ->will($this->returnValue("{\"$key\":$val}"));
    $stub
      ->expects($this->once())
      ->method('destroySession');
    $this->assertEquals(
      array($key => $val),
      $stub->api(array('method' => 'auth.revokeauthorization'))
    );
  }

  /**
   * @expectedException FacebookAPIException
   */
  public function testErrorCodeFromRestAPIThrowsException() {
    $methods_to_stub = array(
      '_oauthRequest',
    );
    $constructor_args = array(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET
    ));
    $stub = $this->getMock(
      'TransientFacebook', $methods_to_stub, $constructor_args);
    $stub
      ->expects($this->once())
      ->method('_oauthRequest')
      ->will($this->returnValue('{"error_code": 500}'));
    $stub->api(array('method' => 'foo'));
  }

  public function testJsonEncodeOfNonStringParams() {
    $foo = array(1, 2);
    $params = array(
      'method' => 'get',
      'foo' => $foo,
    );
    $fb = new FBRecordMakeRequest(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $fb->api('/naitik', $params);
    $requests = $fb->publicGetRequests();
    $this->assertEquals(json_encode($foo), $requests[0]['params']['foo']);
  }

  public function testSessionBackedFacebook() {
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $key = 'state';
    $val = 'foo';
    $fb->publicSetPersistentData($key, $val);
    $this->assertEquals(
      $val,
      $_SESSION[sprintf('fb_%s_%s', self::APP_ID, $key)]
    );
    $this->assertEquals(
      $val,
      $fb->publicGetPersistentData($key)
    );
  }

  public function testSessionBackedFacebookIgnoresUnsupportedKey() {
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $key = '--invalid--';
    $val = 'foo';
    $fb->publicSetPersistentData($key, $val);
    $this->assertFalse(
      array_key_exists(
        sprintf('fb_%s_%s', self::APP_ID, $key),
        $_SESSION
      )
    );
    $this->assertFalse($fb->publicGetPersistentData($key));
  }

  public function testClearSessionBackedFacebook() {
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $key = 'state';
    $val = 'foo';
    $fb->publicSetPersistentData($key, $val);
    $this->assertEquals(
      $val,
      $_SESSION[sprintf('fb_%s_%s', self::APP_ID, $key)]
    );
    $this->assertEquals(
      $val,
      $fb->publicGetPersistentData($key)
    );
    $fb->publicClearPersistentData($key);
    $this->assertFalse(
      array_key_exists(
        sprintf('fb_%s_%s', self::APP_ID, $key),
        $_SESSION
      )
    );
    $this->assertFalse($fb->publicGetPersistentData($key));
  }

  public function testSessionBackedFacebookIgnoresUnsupportedKeyInClear() {
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $key = '--invalid--';
    $val = 'foo';
    $session_var_name = sprintf('fb_%s_%s', self::APP_ID, $key);
    $_SESSION[$session_var_name] = $val;
    $fb->publicClearPersistentData($key);
    $this->assertTrue(array_key_exists($session_var_name, $_SESSION));
    $this->assertFalse($fb->publicGetPersistentData($key));
  }

  public function testClearAllSessionBackedFacebook() {
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $key = 'state';
    $val = 'foo';
    $session_var_name = sprintf('fb_%s_%s', self::APP_ID, $key);
    $fb->publicSetPersistentData($key, $val);
    $this->assertEquals($val, $_SESSION[$session_var_name]);
    $this->assertEquals($val, $fb->publicGetPersistentData($key));
    $fb->publicClearAllPersistentData();
    $this->assertFalse(array_key_exists($session_var_name, $_SESSION));
    $this->assertFalse($fb->publicGetPersistentData($key));
  }

  public function testSharedSessionBackedFacebook() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'sharedSession' => true,
    ));
    $key = 'state';
    $val = 'foo';
    $session_var_name = sprintf(
      '%s_fb_%s_%s',
      $fb->publicGetSharedSessionID(),
      self::APP_ID,
      $key
    );
    $fb->publicSetPersistentData($key, $val);
    $this->assertEquals($val, $_SESSION[$session_var_name]);
    $this->assertEquals($val, $fb->publicGetPersistentData($key));
  }

  public function testSharedSessionBackedFacebookIgnoresUnsupportedKey() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'sharedSession' => true,
    ));
    $key = '--invalid--';
    $val = 'foo';
    $session_var_name = sprintf(
      '%s_fb_%s_%s',
      $fb->publicGetSharedSessionID(),
      self::APP_ID,
      $key
    );
    $fb->publicSetPersistentData($key, $val);
    $this->assertFalse(array_key_exists($session_var_name, $_SESSION));
    $this->assertFalse($fb->publicGetPersistentData($key));
  }

  public function testSharedClearSessionBackedFacebook() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'sharedSession' => true,
    ));
    $key = 'state';
    $val = 'foo';
    $session_var_name = sprintf(
      '%s_fb_%s_%s',
      $fb->publicGetSharedSessionID(),
      self::APP_ID,
      $key
    );
    $fb->publicSetPersistentData($key, $val);
    $this->assertEquals($val, $_SESSION[$session_var_name]);
    $this->assertEquals($val, $fb->publicGetPersistentData($key));
    $fb->publicClearPersistentData($key);
    $this->assertFalse(array_key_exists($session_var_name, $_SESSION));
    $this->assertFalse($fb->publicGetPersistentData($key));
  }

  public function testSharedSessionBackedFacebookIgnoresUnsupportedKeyInClear() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'sharedSession' => true,
    ));
    $key = '--invalid--';
    $val = 'foo';
    $session_var_name = sprintf(
      '%s_fb_%s_%s',
      $fb->publicGetSharedSessionID(),
      self::APP_ID,
      $key
    );
    $_SESSION[$session_var_name] = $val;
    $fb->publicClearPersistentData($key);
    $this->assertTrue(array_key_exists($session_var_name, $_SESSION));
    $this->assertFalse($fb->publicGetPersistentData($key));
  }

  public function testSharedClearAllSessionBackedFacebook() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'sharedSession' => true,
    ));
    $key = 'state';
    $val = 'foo';
    $session_var_name = sprintf(
      '%s_fb_%s_%s',
      $fb->publicGetSharedSessionID(),
      self::APP_ID,
      $key
    );
    $fb->publicSetPersistentData($key, $val);
    $this->assertEquals($val, $_SESSION[$session_var_name]);
    $this->assertEquals($val, $fb->publicGetPersistentData($key));
    $fb->publicClearAllPersistentData();
    $this->assertFalse(array_key_exists($session_var_name, $_SESSION));
    $this->assertFalse($fb->publicGetPersistentData($key));
  }

  public function testSharedSessionBackedFacebookIsRestored() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'sharedSession' => true,
    ));
    $key = 'state';
    $val = 'foo';
    $shared_session_id = $fb->publicGetSharedSessionID();
    $session_var_name = sprintf(
      '%s_fb_%s_%s',
      $shared_session_id,
      self::APP_ID,
      $key
    );
    $fb->publicSetPersistentData($key, $val);
    $this->assertEquals($val, $_SESSION[$session_var_name]);
    $this->assertEquals($val, $fb->publicGetPersistentData($key));

    // check the new instance has the same data
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'sharedSession' => true,
    ));
    $this->assertEquals(
      $shared_session_id,
      $fb->publicGetSharedSessionID()
    );
    $this->assertEquals($val, $fb->publicGetPersistentData($key));
  }

  public function testSharedSessionBackedFacebookIsNotRestoredWhenCorrupt() {
    $_SERVER['HTTP_HOST'] = 'fbrell.com';
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'sharedSession' => true,
    ));
    $key = 'state';
    $val = 'foo';
    $shared_session_id = $fb->publicGetSharedSessionID();
    $session_var_name = sprintf(
      '%s_fb_%s_%s',
      $shared_session_id,
      self::APP_ID,
      $key
    );
    $fb->publicSetPersistentData($key, $val);
    $this->assertEquals($val, $_SESSION[$session_var_name]);
    $this->assertEquals($val, $fb->publicGetPersistentData($key));

    // break the cookie
    $cookie_name = $fb->publicGetSharedSessionCookieName();
    $_COOKIE[$cookie_name] = substr($_COOKIE[$cookie_name], 1);

    // check the new instance does not have the data
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'sharedSession' => true,
    ));
    $this->assertFalse($fb->publicGetPersistentData($key));
    $this->assertNotEquals(
      $shared_session_id,
      $fb->publicGetSharedSessionID()
    );
  }

  public function testHttpHost() {
    $real = 'foo.com';
    $_SERVER['HTTP_HOST'] = $real;
    $_SERVER['HTTP_X_FORWARDED_HOST'] = 'evil.com';
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $this->assertEquals($real, $fb->publicGetHttpHost());
  }

  public function testHttpProtocol() {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'http';
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
    ));
    $this->assertEquals('https', $fb->publicGetHttpProtocol());
  }

  public function testHttpHostForwarded() {
    $real = 'foo.com';
    $_SERVER['HTTP_HOST'] = 'localhost';
    $_SERVER['HTTP_X_FORWARDED_HOST'] = $real;
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'trustForwarded' => true,
    ));
    $this->assertEquals($real, $fb->publicGetHttpHost());
  }

  public function testHttpProtocolForwarded() {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'http';
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'trustForwarded' => true,
    ));
    $this->assertEquals('http', $fb->publicGetHttpProtocol());
  }

  public function testHttpProtocolForwardedSecure() {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'https';
    $fb = new PersistentFBPublic(array(
      'appId'  => self::APP_ID,
      'secret' => self::SECRET,
      'trustForwarded' => true,
    ));
    $this->assertEquals('https', $fb->publicGetHttpProtocol());
  }

  /**
   * @dataProvider provideEndsWith
   */
  public function testEndsWith($big, $small, $result) {
    $this->assertEquals(
      $result,
      PersistentFBPublic::publicEndsWith($big, $small)
    );
  }

  public function provideEndsWith() {
    return array(
      array('', '', true),
      array('', 'a', false),
      array('a', '', true),
      array('a', 'b', false),
      array('a', 'a', true),
      array('aa', 'a', true),
      array('ab', 'a', false),
      array('ba', 'a', true),
    );
  }

  /**
   * @dataProvider provideIsAllowedDomain
   */
  public function testIsAllowedDomain($big, $small, $result) {
    $this->assertEquals(
      $result,
      PersistentFBPublic::publicIsAllowedDomain($big, $small)
    );
  }

  public function provideIsAllowedDomain() {
    return array(
      array('fbrell.com', 'fbrell.com', true),
      array('foo.fbrell.com', 'fbrell.com', true),
      array('foofbrell.com', 'fbrell.com', false),
      array('evil.com', 'fbrell.com', false),
      array('foo.fbrell.com', 'bar.fbrell.com', false),
    );
  }

  protected function generateMD5HashOfRandomValue() {
    return md5(uniqid(mt_rand(), true));
  }

  protected function setUp() {
    parent::setUp();
  }

  protected function tearDown() {
    $this->clearSuperGlobals();
    parent::tearDown();
  }

  protected function clearSuperGlobals() {
    unset($_SERVER['HTTPS']);
    unset($_SERVER['HTTP_HOST']);
    unset($_SERVER['REQUEST_URI']);
    $_SESSION = array();
    $_COOKIE = array();
    $_REQUEST = array();
    $_POST = array();
    $_GET = array();
    if (session_id()) {
      session_destroy();
    }
  }

  /**
   * Checks that the correct args are a subset of the returned obj
   * @param  array $correct The correct array values
   * @param  array $actual  The values in practice
   * @param  string $message to be shown on failure
   */
  protected function assertIsSubset($correct, $actual, $msg='') {
    foreach ($correct as $key => $value) {
      $actual_value = $actual[$key];
      $newMsg = (strlen($msg) ? ($msg.' ') : '').'Key: '.$key;
      $this->assertEquals($value, $actual_value, $newMsg);
    }
  }
}

class TransientFacebook extends BaseFacebook {
  protected function setPersistentData($key, $value) {}
  protected function getPersistentData($key, $default = false) {
    return $default;
  }
  protected function clearPersistentData($key) {}
  protected function clearAllPersistentData() {}
}

class FBRecordURL extends TransientFacebook {
  private $url;

  protected function _oauthRequest($url, $params) {
    $this->url = $url;
  }

  public function getRequestedURL() {
    return $this->url;
  }
}

class FBRecordMakeRequest extends TransientFacebook {
  private $requests = array();

  protected function makeRequest($url, $params, $ch=null) {
    $this->requests[] = array(
      'url' => $url,
      'params' => $params,
    );
    return parent::makeRequest($url, $params, $ch);
  }

  public function publicGetRequests() {
    return $this->requests;
  }

  public function publicGetAppSecretProof($access_token) {
    return $this->getAppSecretProof($access_token);
  }
}

class FBPublic extends TransientFacebook {
  public static function publicBase64UrlDecode($input) {
    return self::base64UrlDecode($input);
  }
  public static function publicBase64UrlEncode($input) {
    return self::base64UrlEncode($input);
  }
  public function publicParseSignedRequest($input) {
    return $this->parseSignedRequest($input);
  }
  public function publicMakeSignedRequest($data) {
    return $this->makeSignedRequest($data);
  }
}

class PersistentFBPublic extends Facebook {
  public function publicParseSignedRequest($input) {
    return $this->parseSignedRequest($input);
  }

  public function publicSetPersistentData($key, $value) {
    $this->setPersistentData($key, $value);
  }

  public function publicGetPersistentData($key, $default = false) {
    return $this->getPersistentData($key, $default);
  }

  public function publicClearPersistentData($key) {
    return $this->clearPersistentData($key);
  }

  public function publicClearAllPersistentData() {
    return $this->clearAllPersistentData();
  }

  public function publicGetSharedSessionID() {
    return $this->sharedSessionID;
  }

  public static function publicIsAllowedDomain($big, $small) {
    return self::isAllowedDomain($big, $small);
  }

  public static function publicEndsWith($big, $small) {
    return self::endsWith($big, $small);
  }

  public function publicGetSharedSessionCookieName() {
    return $this->getSharedSessionCookieName();
  }

  public function publicGetHttpHost() {
    return $this->getHttpHost();
  }

  public function publicGetHttpProtocol() {
    return $this->getHttpProtocol();
  }
}

class FBCode extends Facebook {
  public function publicGetCode() {
    return $this->getCode();
  }

  public function publicGetState() {
    return $this->state;
  }

  public function setCSRFStateToken() {
    $this->establishCSRFTokenState();
  }

  public function getCSRFStateToken() {
    return $this->getPersistentData('state');
  }
}

class FBAccessToken extends TransientFacebook {
  public function publicGetApplicationAccessToken() {
    return $this->getApplicationAccessToken();
  }
}

class FBGetCurrentURLFacebook extends TransientFacebook {
  public function publicGetCurrentUrl() {
    return $this->getCurrentUrl();
  }
}

class FBPublicCookie extends TransientFacebook {
  public function publicGetSignedRequest() {
    return $this->getSignedRequest();
  }

  public function publicGetSignedRequestCookieName() {
    return $this->getSignedRequestCookieName();
  }

  public function publicGetMetadataCookie() {
    return $this->getMetadataCookie();
  }

  public function publicGetMetadataCookieName() {
    return $this->getMetadataCookieName();
  }
}

class FBRewrite extends Facebook{

  public function uncacheSignedRequest(){
    $this->signedRequest = null;
  }

  public function uncache()
  {
    $this->user = null;
    $this->signedRequest = null;
    $this->accessToken = null;
  }
}


class FBPublicGetAccessTokenFromCode extends TransientFacebook {
  public function publicGetAccessTokenFromCode($code, $redirect_uri = null) {
    return $this->getAccessTokenFromCode($code, $redirect_uri);
  }
}

class FBPublicState extends TransientFacebook {
  const STATE = 'foo';
  protected function getPersistentData($key, $default = false) {
    if ($key === 'state') {
      return self::STATE;
    }
    return parent::getPersistentData($key, $default);
  }

  public function publicGetState() {
    return $this->state;
  }
}
