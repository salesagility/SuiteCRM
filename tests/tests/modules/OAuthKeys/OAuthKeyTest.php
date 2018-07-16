<?php


class OAuthKeyTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testOAuthKey()
    {
        $this->markTestIncomplete('Smthing wrong with the oauth_token db table. after this the other tests says: Incorrect state hash (in PHPUnitTest): Hash doesn\'t match at key "database::oauth_tokens".');

        //execute the contructor and check for the Object type and  attributes
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
        $this->markTestIncomplete('Smthing wrong with the oauth_token db table. after this the other tests says: Incorrect state hash (in PHPUnitTest): Hash doesn\'t match at key "database::oauth_tokens".');

        $oauthKey = new OAuthKey();

        //preset required attributes
        $oauthKey->name = 'test';
        $oauthKey->c_key = 'key';
        $oauthKey->c_secret = 'secret';

        $oauthKey->save();

        //test getByKey method
        $this->getByKey($oauthKey->c_key);

        //test fetchKey method
        $this->fetchKey($oauthKey->c_key);

        //test mark_deleted method
        $this->mark_deleted($oauthKey->id);
    }

    public function getByKey($key)
    {
        $this->markTestIncomplete('Smthing wrong with the oauth_token db table. after this the other tests says: Incorrect state hash (in PHPUnitTest): Hash doesn\'t match at key "database::oauth_tokens".');
        
        $oauthKey = new OAuthKey();

        //test with a invalid id
        $result = $oauthKey->getByKey('');
        $this->assertEquals(false, $result);

        //test with a valid id
        $result = $oauthKey->getByKey($key);
        $this->assertInstanceOf('OAuthKey', $result);
    }

    public function fetchKey($key)
    {
        $this->markTestIncomplete('Smthing wrong with the oauth_token db table. after this the other tests says: Incorrect state hash (in PHPUnitTest): Hash doesn\'t match at key "database::oauth_tokens".');
        

        //test with a invalid id
        $result = OAuthKey::fetchKey('');
        $this->assertEquals(false, $result);

        //test with a valid id
        $result = OAuthKey::fetchKey($key);
        $this->assertInstanceOf('OAuthKey', $result);
    }

    public function mark_deleted($id)
    {
        $this->markTestIncomplete('Smthing wrong with the oauth_token db table. after this the other tests says: Incorrect state hash (in PHPUnitTest): Hash doesn\'t match at key "database::oauth_tokens".');
        
        $oauthKey = new OAuthKey();

        $oauthKey->mark_deleted($id);

        //verify that record is deleted
        $result = $oauthKey->getByKey($id);
        $this->assertEquals(false, $result);
    }
}
