<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class OAuthTokenTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function test__construct()
    {
        // Execute the constructor and check for the Object type and  attributes
        $oauthToken = BeanFactory::newBean('OAuthTokens');

        self::assertInstanceOf('OAuthToken', $oauthToken);
        self::assertInstanceOf('SugarBean', $oauthToken);

        self::assertAttributeEquals('OAuthTokens', 'module_dir', $oauthToken);
        self::assertAttributeEquals('OAuthToken', 'object_name', $oauthToken);
        self::assertAttributeEquals('oauth_tokens', 'table_name', $oauthToken);

        self::assertAttributeEquals(true, 'disable_row_level_security', $oauthToken);
    }

    public function testsetState()
    {
        $oauthToken = BeanFactory::newBean('OAuthTokens');
        $oauthToken->setState($oauthToken::REQUEST);

        self::assertEquals($oauthToken::REQUEST, $oauthToken->tstate);
    }

    public function testsetConsumer()
    {
        $oauthToken = BeanFactory::newBean('OAuthTokens');

        $oauthKey = BeanFactory::newBean('OAuthKeys');
        $oauthKey->id = '1';

        $oauthToken->setConsumer($oauthKey);

        self::assertEquals($oauthKey->id, $oauthToken->consumer);
        self::assertEquals($oauthKey, $oauthToken->consumer_obj);
    }

    public function testsetCallbackURL()
    {
        $oauthToken = BeanFactory::newBean('OAuthTokens');

        $url = 'test url';
        $oauthToken->setCallbackURL($url);

        self::assertEquals($url, $oauthToken->callback_url);
    }

    public function testgenerate()
    {
        $result = OAuthToken::generate();

        self::assertInstanceOf('OAuthToken', $result);
        self::assertGreaterThan(0, strlen($result->token));
        self::assertGreaterThan(0, strlen($result->secret));
    }

    public function testSaveAndOthers()
    {
        $oauthToken = OAuthToken::generate();

        $oauthToken->save();

        //test for record ID to verify that record is saved
        self::assertTrue(isset($oauthToken->id));
        self::assertEquals(12, strlen($oauthToken->id));

        //test load method
        $this->load($oauthToken->id);

        //test invalidate method
        $token = OAuthToken::load($oauthToken->id);
        $this->invalidate($token);

        //test authorize method
        $this->authorize($token);

        //test mark_deleted method
        $this->mark_deleted($oauthToken->id);
    }

    public function load($id)
    {
        $token = OAuthToken::load($id);

        self::assertInstanceOf('OAuthToken', $token);
        self::assertTrue(isset($token->id));
    }

    public function invalidate($token)
    {
        $token->invalidate();

        self::assertEquals($token::INVALID, $token->tstate);
        self::assertEquals(false, $token->verify);
    }

    public function authorize($token)
    {
        $result = $token->authorize('test');
        self::assertEquals(false, $result);

        $token->tstate = $token::REQUEST;
        $result = $token->authorize('test');

        self::assertEquals('test', $token->authdata);
        self::assertGreaterThan(0, strlen($result));
        self::assertEquals($result, $token->verify);
    }

    public function mark_deleted($id)
    {
        $oauthToken = BeanFactory::newBean('OAuthTokens');

        //execute the method
        $oauthToken->mark_deleted($id);

        //verify that record can not be loaded anymore
        $token = OAuthToken::load($id);
        self::assertEquals(null, $token);
    }

    public function testcreateAuthorized()
    {
        $oauthKey = BeanFactory::newBean('OAuthKeys');
        $oauthKey->id = '1';

        $user = BeanFactory::newBean('Users');
        $user->retrieve('1');

        $oauthToken = OAuthToken::createAuthorized($oauthKey, $user);

        self::assertEquals($oauthKey->id, $oauthToken->consumer);
        self::assertEquals($oauthKey, $oauthToken->consumer_obj);
        self::assertEquals($oauthToken::ACCESS, $oauthToken->tstate);
        self::assertEquals($user->id, $oauthToken->assigned_user_id);

        //execute copyAuthData method
        $oauthToken->authdata = 'test';
        $this->copyAuthData($oauthToken);

        //finally mark deleted for cleanup
        $oauthToken->mark_deleted($oauthToken->id);
    }

    public function copyAuthData($token)
    {
        $oauthToken = BeanFactory::newBean('OAuthTokens');

        $oauthToken->copyAuthData($token);
        self::assertEquals($token->authdata, $oauthToken->authdata);
        self::assertEquals($token->assigned_user_id, $oauthToken->assigned_user_id);
    }

    public function testqueryString()
    {
        $oauthToken = BeanFactory::newBean('OAuthTokens');

        $result = $oauthToken->queryString();
        self::assertEquals('oauth_token=&oauth_token_secret=', $result);

        //test with attributes set
        $oauthToken->token = 'toekn';
        $oauthToken->secret = 'secret';
        $result = $oauthToken->queryString();
        self::assertEquals('oauth_token=toekn&oauth_token_secret=secret', $result);
    }

    public function testcleanup()
    {
        // Execute the method and test that it works and doesn't throw an exception.
        try {
            OAuthToken::cleanup();
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testcheckNonce()
    {
//        self::markTestIncomplete('wrong test');
//        $result = OAuthToken::checkNonce('test', 'test', 123);
//        $this->assertEquals(1, $result);
    }

    public function testdeleteByConsumer()
    {
        // Execute the method and test that it works and doesn't throw an exception.
        try {
            OAuthToken::deleteByConsumer('1');
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testdeleteByUser()
    {
        // Execute the method and test that it works and doesn't throw an exception.
        try {
            OAuthToken::deleteByUser('1');
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testdisplayDateFromTs()
    {
        //test with empty array
        $result = displayDateFromTs(array('' => ''), 'timestamp', '');
        self::assertEquals('', $result);

        //test with a valid array
        $result = displayDateFromTs(array('TIMESTAMP' => '1272508903'), 'timestamp', '');
        self::assertEquals('04/29/2010 02:41', $result);
    }
}
