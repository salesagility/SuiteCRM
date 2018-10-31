<?php

class OAuthTokenTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function test__construct()
    {

        //execute the contructor and check for the Object type and  attributes
        $oauthToken = new OAuthToken();

        $this->assertInstanceOf('OAuthToken', $oauthToken);
        $this->assertInstanceOf('SugarBean', $oauthToken);

        $this->assertAttributeEquals('OAuthTokens', 'module_dir', $oauthToken);
        $this->assertAttributeEquals('OAuthToken', 'object_name', $oauthToken);
        $this->assertAttributeEquals('oauth_tokens', 'table_name', $oauthToken);

        $this->assertAttributeEquals(true, 'disable_row_level_security', $oauthToken);
    }

    public function testsetState()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        $oauthToken = new OAuthToken();
        $oauthToken->setState($oauthToken::REQUEST);

        $this->assertEquals($oauthToken::REQUEST, $oauthToken->tstate);
        
        // clean up
    }

    public function testsetConsumer()
    {
        $oauthToken = new OAuthToken();

        $oauthKey = new OAuthKey();
        $oauthKey->id = '1';

        $oauthToken->setConsumer($oauthKey);

        $this->assertEquals($oauthKey->id, $oauthToken->consumer);
        $this->assertEquals($oauthKey, $oauthToken->consumer_obj);
    }

    public function testsetCallbackURL()
    {
        $oauthToken = new OAuthToken();

        $url = 'test url';
        $oauthToken->setCallbackURL($url);

        $this->assertEquals($url, $oauthToken->callback_url);
    }

    public function testgenerate()
    {
        $result = OAuthToken::generate();

        $this->assertInstanceOf('OAuthToken', $result);
        $this->assertGreaterThan(0, strlen($result->token));
        $this->assertGreaterThan(0, strlen($result->secret));
    }

    public function testSaveAndOthers()
    {

    // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('tracker');
        $state->pushTable('aod_index');

        // test
        
        $oauthToken = OAuthToken::generate();

        $oauthToken->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($oauthToken->id));
        $this->assertEquals(12, strlen($oauthToken->id));

        //test load method
        $this->load($oauthToken->id);

        //test invalidate method
        $token = OAuthToken::load($oauthToken->id);
        $this->invalidate($token);

        //test authorize method
        $this->authorize($token);

        //test mark_deleted method
        $this->mark_deleted($oauthToken->id);
        
        // clean up
        
        $state->popTable('aod_index');
        $state->popTable('tracker');
    }

    public function load($id)
    {
        $token = OAuthToken::load($id);

        $this->assertInstanceOf('OAuthToken', $token);
        $this->assertTrue(isset($token->id));
    }

    public function invalidate($token)
    {
        $token->invalidate();

        $this->assertEquals($token::INVALID, $token->tstate);
        $this->assertEquals(false, $token->verify);
    }

    public function authorize($token)
    {
        $result = $token->authorize('test');
        $this->assertEquals(false, $result);

        $token->tstate = $token::REQUEST;
        $result = $token->authorize('test');

        $this->assertEquals('test', $token->authdata);
        $this->assertGreaterThan(0, strlen($result));
        $this->assertEquals($result, $token->verify);
    }

    public function mark_deleted($id)
    {
        $oauthToken = new OAuthToken();

        //execute the method
        $oauthToken->mark_deleted($id);

        //verify that record can not be loaded anymore
        $token = OAuthToken::load($id);
        $this->assertEquals(null, $token);
    }

    public function testcreateAuthorized()
    {
        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('tracker');

        // test
        
        $oauthKey = new OAuthKey();
        $oauthKey->id = '1';

        $user = new User();
        $user->retrieve('1');

        $oauthToken = OAuthToken::createAuthorized($oauthKey, $user);

        $this->assertEquals($oauthKey->id, $oauthToken->consumer);
        $this->assertEquals($oauthKey, $oauthToken->consumer_obj);
        $this->assertEquals($oauthToken::ACCESS, $oauthToken->tstate);
        $this->assertEquals($user->id, $oauthToken->assigned_user_id);

        //execute copyAuthData method
        $oauthToken->authdata = 'test';
        $this->copyAuthData($oauthToken);

        //finally mark deleted for cleanup
        $oauthToken->mark_deleted($oauthToken->id);
        
        // clean up
        
        $state->popTable('tracker');
    }

    public function copyAuthData($token)
    {
        $oauthToken = new OAuthToken();

        $oauthToken->copyAuthData($token);
        $this->assertEquals($token->authdata, $oauthToken->authdata);
        $this->assertEquals($token->assigned_user_id, $oauthToken->assigned_user_id);
    }

    public function testqueryString()
    {
        $oauthToken = new OAuthToken();

        $result = $oauthToken->queryString();
        $this->assertEquals('oauth_token=&oauth_token_secret=', $result);

        //test with attributes set
        $oauthToken->token = 'toekn';
        $oauthToken->secret = 'secret';
        $result = $oauthToken->queryString();
        $this->assertEquals('oauth_token=toekn&oauth_token_secret=secret', $result);
    }

    public function testcleanup()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        //execute the method and test if it works and does not throws an exception.
        try {
            OAuthToken::cleanup();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
    }

    public function testcheckNonce()
    {
        self::markTestIncomplete('wrong test');
        $result = OAuthToken::checkNonce('test', 'test', 123);
        $this->assertEquals(1, $result);
    }

    public function testdeleteByConsumer()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        //execute the method and test if it works and does not throws an exception.
        try {
            OAuthToken::deleteByConsumer('1');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
    }

    public function testdeleteByUser()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        //execute the method and test if it works and does not throws an exception.
        try {
            OAuthToken::deleteByUser('1');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
    }

    public function testdisplayDateFromTs()
    {
        //test with empty array
        $result = displayDateFromTs(array('' => ''), 'timestamp', '');
        $this->assertEquals('', $result);

        //test with a valid array
        $result = displayDateFromTs(array('TIMESTAMP' => '1272508903'), 'timestamp', '');
        $this->assertEquals('04/29/2010 02:41', $result);
    }
}
