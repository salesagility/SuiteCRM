<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class OAuthKeyTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testOAuthKey()
    {
        // Execute the constructor and check for the Object type and  attributes
        $oauthKey = BeanFactory::newBean('OAuthKeys');

        self::assertInstanceOf('OAuthKey', $oauthKey);
        self::assertInstanceOf('Basic', $oauthKey);
        self::assertInstanceOf('SugarBean', $oauthKey);

        self::assertAttributeEquals('OAuthKeys', 'module_dir', $oauthKey);
        self::assertAttributeEquals('OAuthKey', 'object_name', $oauthKey);
        self::assertAttributeEquals('oauth_consumer', 'table_name', $oauthKey);

        self::assertAttributeEquals(true, 'disable_row_level_security', $oauthKey);
    }

    public function testMain()
    {
        // test
        $oauthKey = BeanFactory::newBean('OAuthKeys');

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
        $oauthKey = BeanFactory::newBean('OAuthKeys');

        //test with a invalid id
        $result = $oauthKey->getByKey('');
        self::assertEquals(false, $result);

        //test with a valid id
        $result = $oauthKey->getByKey($key);
        self::assertInstanceOf('OAuthKey', $result);
    }

    public function fetchKey($key)
    {
        //test with a invalid id
        $result = OAuthKey::fetchKey('');
        self::assertEquals(false, $result);

        //test with a valid id
        $result = OAuthKey::fetchKey($key);
        self::assertInstanceOf('OAuthKey', $result);
    }

    public function mark_deleted($id)
    {
        $oauthKey = BeanFactory::newBean('OAuthKeys');

        $oauthKey->mark_deleted($id);

        //verify that record is deleted
        $result = $oauthKey->getByKey($id);
        self::assertEquals(false, $result);
    }
}
