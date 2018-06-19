<?php


class OAuthKeyTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testOAuthKey()
    {

        
        $oauthKey = new OAuthKey();

        $this->assertInstanceOf('OAuthKey', $oauthKey);
        $this->assertInstanceOf('Basic', $oauthKey);
        $this->assertInstanceOf('SugarBean', $oauthKey);

        $this->assertAttributeEquals('OAuthKeys', 'module_dir', $oauthKey);
        $this->assertAttributeEquals('OAuthKey', 'object_name', $oauthKey);
        $this->assertAttributeEquals('oauth_consumer', 'table_name', $oauthKey);

        $this->assertAttributeEquals(true, 'disable_row_level_security', $oauthKey);
    }

    public function testMain()
    {
        $state = new SuiteCRM\StateSaver();
        
        $state->pushTable('tracker');
        
        

        $oauthKey = new OAuthKey();

        
        $oauthKey->name = 'test';
        $oauthKey->c_key = 'key';
        $oauthKey->c_secret = 'secret';

        $oauthKey->save();

        
        $this->getByKey($oauthKey->c_key);

        
        $this->fetchKey($oauthKey->c_key);

        
        $this->mark_deleted($oauthKey->id);
        
        
        
        $state->popTable('tracker');
        
    }

    public function getByKey($key)
    {
        $oauthKey = new OAuthKey();

        
        $result = $oauthKey->getByKey('');
        $this->assertEquals(false, $result);

        
        $result = $oauthKey->getByKey($key);
        $this->assertInstanceOf('OAuthKey', $result);
    }

    public function fetchKey($key)
    {

        
        $result = OAuthKey::fetchKey('');
        $this->assertEquals(false, $result);

        
        $result = OAuthKey::fetchKey($key);
        $this->assertInstanceOf('OAuthKey', $result);
    }

    public function mark_deleted($id)
    {
        $oauthKey = new OAuthKey();

        $oauthKey->mark_deleted($id);

        
        $result = $oauthKey->getByKey($id);
        $this->assertEquals(false, $result);
    }
}
