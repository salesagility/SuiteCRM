<?php

include_once __DIR__ . '/../../../TestLogger.php';

/** @noinspection PhpUndefinedClassInspection */
class SugarEmailAddressTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var SugarEmailAddress
     */
    protected $ea;


    public function setUp() {
        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();

        $this->ea = new SugarEmailAddress();
    }


    public function testConstruct()
    {
        $ea = new SugarEmailAddress();
        $indexBefore = $ea->index;
        $countBefore = $ea::$count;
        $ea = new SugarEmailAddress();
        $indexAfter = $ea->index;
        $countAfter = $ea::$count;
        self::assertEquals($indexBefore, $indexAfter-1);
        self::assertEquals($indexBefore, $indexAfter-1);
    }


    public function testSugarEmailAddress()
    {
        $ea = new SugarEmailAddress();
        $indexBefore = $ea->index;
        $countBefore = $ea::$count;
        $ea = new SugarEmailAddress();
        $indexAfter = $ea->index;
        $countAfter = $ea::$count;
        self::assertEquals($indexBefore, $indexAfter-1);
        self::assertEquals($indexBefore, $indexAfter-1);
    }


    public function testHandleLegacySave()
    {
        $c = new Contact();

        if (!empty($_REQUEST)) {
            $req = $_REQUEST;
        }

        $c->email1 = 'test3@email.com';
        $c->email2 = 'test4@email.com';
        $_REQUEST['useEmailWidget'] = true;
        $_REQUEST['massupdate'] = true;
        $this->ea->handleLegacySave($c);
        self::assertCount(0, $this->ea->addresses);

        if(!empty($req)) {
            $_REQUEST = $req;
        } else {
            unset($_REQUEST);
        }

        $c->email1 = 'test@email.com';
        $c->email2 = 'test2@email.com';
        $this->ea->handleLegacySave($c);
        self::assertCount(2, $this->ea->addresses);
        self::assertSame('test@email.com', $this->ea->addresses[0]['email_address']);
        self::assertSame('1', $this->ea->addresses[0]['primary_address']);
        self::assertSame('0', $this->ea->addresses[0]['reply_to_address']);
        self::assertSame('0', $this->ea->addresses[0]['invalid_email']);
        self::assertSame('0', $this->ea->addresses[0]['opt_out']);
        self::assertNull($this->ea->addresses[0]['email_address_id']);
        self::assertSame('test2@email.com', $this->ea->addresses[1]['email_address']);
        self::assertSame('0', $this->ea->addresses[1]['primary_address']);
        self::assertSame('0', $this->ea->addresses[1]['reply_to_address']);
        self::assertSame('0', $this->ea->addresses[1]['invalid_email']);
        self::assertSame('0', $this->ea->addresses[1]['opt_out']);
        self::assertNull($this->ea->addresses[1]['email_address_id']);

    }


    public function testHandleLegacyRetrieve()
    {
        $c = new Contact();

        $this->ea->handleLegacyRetrieve($c);
        self::assertFalse($c->fetched_row);

        $c->email1 = 'test5@email.com';
        $this->ea->handleLegacyRetrieve($c);
        self::assertSame(array(
            'email1' => 'test5@email.com',
        ), $c->fetched_row);
    }


    public function testPopulateLegacyFields()
    {
        $c = new Contact();

        $this->ea->populateLegacyFields($c);
        self::assertEquals(null, $c->email1);
        self::assertEquals(null, $c->email_opt_out);
        self::assertEquals(null, $c->invalid_email);
        self::assertEquals(null, $c->email2);

        $this->ea->addAddress('test6@email.com');
        $this->ea->addAddress('test7@email.com');
        $this->ea->populateLegacyFields($c);
        self::assertEquals('test6@email.com', $c->email1);
        self::assertEquals(0, $c->email_opt_out);
        self::assertEquals(0, $c->invalid_email);
        self::assertEquals('test7@email.com', $c->email2);

        $this->ea->addresses[1]['primary_address'] = 1;
        $this->ea->populateLegacyFields($c);
        self::assertEquals('test7@email.com', $c->email1);
        self::assertEquals(0, $c->email_opt_out);
        self::assertEquals(0, $c->invalid_email);
        self::assertEquals('test6@email.com', $c->email2);

    }


    public function testSave()
    {
        $logger = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        $this->ea->save(null, null, null, null, null, null, null, null);
        self::assertCount(1, $GLOBALS['log']->calls['deprecated']);

        $GLOBALS['log'] = $logger;
    }


    public function testSaveEmail()
    {
        $logger = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        if (!empty($_REQUEST)) {
            $req = $_REQUEST;
        }

        $db = DBManagerFactory::getInstance();
        $db->query("delete  from email_addr_bean_rel  WHERE email_addr_bean_rel.bean_id = '' AND email_addr_bean_rel.bean_module = '' and email_addr_bean_rel.deleted=0");

        $q = "select count(*) as cnt from email_addr_bean_rel eabr WHERE eabr.bean_id = '' AND eabr.bean_module = '' and eabr.deleted=0 ";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        self::assertEquals(0, $row['cnt']);

        $this->ea->saveEmail(false, null);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        //

        $this->ea->addAddress('test8@email.com');
        $this->ea->addAddress('test9@email.com');

        $q = "select count(*) as cnt from email_addr_bean_rel eabr WHERE eabr.bean_id = '' AND eabr.bean_module = '' and eabr.deleted=0 ";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        self::assertEquals(0, $row['cnt']);

        $this->ea->saveEmail(false, null);
        self::assertCount(2, $GLOBALS['log']->calls['fatal']);

        $q = "select count(*) as cnt from email_addr_bean_rel eabr WHERE eabr.bean_id = '' AND eabr.bean_module = '' and eabr.deleted=0 ";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        self::assertEquals(2, $row['cnt']);

        //

        $this->ea->addAddress('test10@email.com');
        $this->ea->addAddress('test11@email.com');

        $q = "select count(*) as cnt from email_addr_bean_rel eabr WHERE eabr.bean_id = '' AND eabr.bean_module = '' and eabr.deleted=0 ";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        self::assertEquals(2, $row['cnt']);

        $this->ea->saveEmail(false, null);
        self::assertCount(3, $GLOBALS['log']->calls['fatal']);

        $q = "select count(*) as cnt from email_addr_bean_rel eabr WHERE eabr.bean_id = '' AND eabr.bean_module = '' and eabr.deleted=0 ";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        self::assertEquals(4, $row['cnt']);

        //

        $this->ea->addAddress('test12@email.com');
        $this->ea->addAddress('test13@email.com');
        $this->ea->addresses[1]['primary_address'] = 1;

        $q = "select count(*) as cnt from email_addr_bean_rel eabr WHERE eabr.bean_id = '' AND eabr.bean_module = '' and eabr.deleted=0 ";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        self::assertEquals(4, $row['cnt']);

        $q = "select count(*) as cnt from email_addr_bean_rel eabr WHERE eabr.bean_id = '' AND eabr.bean_module = '' and eabr.deleted=0 AND primary_address = 1";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        self::assertEquals(0, $row['cnt']);

        $this->ea->saveEmail(false, null);
        self::assertCount(4, $GLOBALS['log']->calls['fatal']);

        $q = "select count(*) as cnt from email_addr_bean_rel eabr WHERE eabr.bean_id = '' AND eabr.bean_module = '' and eabr.deleted=0 AND primary_address = 1 ";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        self::assertEquals(1, $row['cnt']);

        $q = "select count(*) as cnt from email_addr_bean_rel eabr WHERE eabr.bean_id = '' AND eabr.bean_module = '' and eabr.deleted=0 ";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        self::assertEquals(6, $row['cnt']);

        //

        $_REQUEST['action'] = 'ConvertLead';

        $this->ea->addAddress('test14@email.com');
        $this->ea->addAddress('test15@email.com');
        $this->ea->addresses[1]['primary_address'] = 1;

        $q = "select count(*) as cnt from email_addr_bean_rel eabr WHERE eabr.bean_id = '' AND eabr.bean_module = '' and eabr.deleted=0 ";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        self::assertEquals(6, $row['cnt']);

        $q = "select count(*) as cnt from email_addr_bean_rel eabr WHERE eabr.bean_id = '' AND eabr.bean_module = '' and eabr.deleted=0 AND primary_address = 1";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        self::assertEquals(1, $row['cnt']);

        $this->ea->saveEmail(false, null);
        self::assertCount(5, $GLOBALS['log']->calls['fatal']);

        $q = "select count(*) as cnt from email_addr_bean_rel eabr WHERE eabr.bean_id = '' AND eabr.bean_module = '' and eabr.deleted=0 AND primary_address = 1 ";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        self::assertEquals(1, $row['cnt']);

        $q = "select count(*) as cnt from email_addr_bean_rel eabr WHERE eabr.bean_id = '' AND eabr.bean_module = '' and eabr.deleted=0 ";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        self::assertEquals(8, $row['cnt']);

        if(!empty($req)) {
            $_REQUEST = $req;
        } else {
            unset($_REQUEST);
        }

        $GLOBALS['log'] = $logger;
    }


    public function testGetCountEmailAddressByBean()
    {
        $c = BeanFactory::getBean('Contacts');
        $result0 = $this->ea->getCountEmailAddressByBean('test12@email.com', $c, 0);
        $result1 = $this->ea->getCountEmailAddressByBean('test13@email.com', $c, 1);
        self::assertEquals(0, $result0);
        self::assertEquals(0, $result1);

        //
        $i = 1;
        $db = DBManagerFactory::getInstance();

        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);

        $q = "
          INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address, deleted) 
          VALUES ('test_email_bean_rel_{$i}', 'test_email_{$i}', 'test_contact_{$i}', 'Contacts', '0', '0')
        ";
        $db->query($q);
        $q = "INSERT INTO email_addresses (id, email_address_caps) VALUES ('test_email_{$i}', 'TEST@EMAIL.COM')";
        $db->query($q);
        $q = "INSERT INTO contacts (id) VALUES ('test_contact_{$i}')";
        $db->query($q);
        $c->id = 'test_contact_1';

        $result0 = $this->ea->getCountEmailAddressByBean('test@email.com', $c, 0);
        $result1 = $this->ea->getCountEmailAddressByBean('test@email.com', $c, 1);
        self::assertEquals(2, $result0);
        self::assertEquals(0, $result1);


        //
        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);
    }


    public function testGetRelatedId()
    {
        $results = $this->ea->getRelatedId('test@email.com', 'Contacts');
        self::assertEquals(false, $results);

        $i = 1;
        $db = DBManagerFactory::getInstance();

        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);

        $q = "
          INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address, deleted) 
          VALUES ('test_email_bean_rel_{$i}', 'test_email_{$i}', 'test_contact_{$i}', 'Contacts', '0', '0')
        ";
        $db->query($q);
        $q = "INSERT INTO email_addresses (id, email_address_caps) VALUES ('test_email_{$i}', 'TEST@EMAIL.COM')";
        $db->query($q);
        $q = "INSERT INTO contacts (id) VALUES ('test_contact_{$i}')";
        $db->query($q);

        $results = $this->ea->getRelatedId('test@email.com', 'Contacts');
        self::assertEquals(array('test_contact_1', 'test_contact_1'), $results);

        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);
    }


    public function testGetBeansByEmailAddress()
    {
        global $locale, $current_user;

        if(empty($locale)) {
            $locale = new Localization();
        }

        if(empty($current_user)) {
            $current_user = BeanFactory::getBean('Users', 1);
        }


        $results = $this->ea->getBeansByEmailAddress('test@email.com');
        self::assertEquals(array(), $results);

        //
        $i = 1;
        $db = DBManagerFactory::getInstance();

        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);

        $q = "
          INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address, deleted) 
          VALUES ('test_email_bean_rel_{$i}', 'test_email_{$i}', 'test_contact_{$i}', 'Contacts', '0', '0')
        ";
        $db->query($q);
        $q = "INSERT INTO email_addresses (id, email_address_caps) VALUES ('test_email_{$i}', 'TEST@EMAIL.COM')";
        $db->query($q);
        $q = "INSERT INTO contacts (id) VALUES ('test_contact_{$i}')";
        $db->query($q);

        $results = $this->ea->getBeansByEmailAddress('test@email.com');
        $expected = BeanFactory::getBean('Contacts', 'test_contact_1');
        self::assertCount(2, $results);
        self::assertSame($expected->id, $results[0]->id);
        self::assertSame($expected->id, $results[1]->id);

        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);

        //

        $results = $this->ea->getBeansByEmailAddress('');
        self::assertEquals(array(), $results);

        //
        $i = 2;
        $q = "
          INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address, deleted) 
          VALUES ('test_email_bean_rel_{$i}', 'test_email_{$i}', 'test_invalid_{$i}', 'InvalidClass', '0', '0')
        ";
        $db->query($q);
        $q = "INSERT INTO email_addresses (id, email_address_caps) VALUES ('test_email_{$i}', 'TESTINVALID@EMAIL.COM')";
        $db->query($q);

        $logger = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        $results = $this->ea->getBeansByEmailAddress('testinvalid@email.com');
        self::assertEquals(array(), $results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        $GLOBALS['log'] = $logger;

        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
    }


    public function testPopulateAddresses()
    {

        if (!empty($_REQUEST)) {
            $req = $_REQUEST;
        }

        $logger = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        $db = DBManagerFactory::getInstance();


        //
        $results = $this->ea->populateAddresses('', '');
        self::assertEquals(null, $results);

        //
        $_REQUEST['emailAddressWidget'] = true;
        $results = $this->ea->populateAddresses('', '');
        self::assertEquals(null, $results);

        //
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(array(), $this->ea->addresses);
        self::assertEquals(false, $results);
        self::assertCount(2, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = array();
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(2, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddressReplyToFlag'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(3, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $_REQUEST['non-exists-or-invalidemailAddressReplyToFlag'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(4, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddressPrimaryFlag'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(5, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $_REQUEST['non-exists-or-invalidemailAddressPrimaryFlag'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(6, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddressOptOutFlag'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(7, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $_REQUEST['non-exists-or-invalidemailAddressOptOutFlag'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(8, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddressInvalidFlag'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(9, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $_REQUEST['non-exists-or-invalidemailAddressInvalidFlag'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(10, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddressDeleteFlag'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(11, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $_REQUEST['non-exists-or-invalidemailAddressDeleteFlag'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(12, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddressId0'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(13, $GLOBALS['log']->calls['fatal']);

        //
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $_REQUEST['non-exists-or-invalidemailAddress'] = true;
        $_REQUEST['emailAddressWidget'] = true;
        $results = $this->ea->populateAddresses('', $module);
        self::assertEquals(false, $results);
        self::assertCount(14, $GLOBALS['log']->calls['fatal']);

        //
        $i = 1;
        $q = "
          INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address, deleted) 
          VALUES ('test_email_bean_rel_{$i}', 'test_email_{$i}', 'test_contact_{$i}', 'Contacts', '0', '0')
        ";
        $db->query($q);
        $q = "INSERT INTO email_addresses (id, email_address_caps) VALUES ('test_email_{$i}', 'TEST@EMAIL.COM')";
        $db->query($q);
        $q = "INSERT INTO contacts (id) VALUES ('test_contact_{$i}')";
        $db->query($q);

        $q = "UPDATE email_addresses SET opt_out = 1, invalid_email = 0 WHERE email_address_caps = 'TEST@EMAIL.COM'";
        $db->query($q);
        unset($_REQUEST);
        $module = 'non-exists-or-invalid';
        $_REQUEST['non-exists-or-invalid_email_widget_id'] = true;
        $_REQUEST['non-exists-or-invalid1emailAddress0'] = true;
        $results = $this->ea->populateAddresses('', $module, array('emailAddress0' => 'test@email.com'));
        self::assertEquals(false, $results);
        self::assertCount(14, $GLOBALS['log']->calls['fatal']);

        $q = "UPDATE email_addresses SET opt_out = 0, invalid_email = 1 WHERE email_address_caps = 'TEST@EMAIL.COM'";
        $db->query($q);
        $results = $this->ea->populateAddresses('', $module, array('emailAddress0' => 'test@email.com'));
        self::assertEquals(false, $results);
        self::assertCount(14, $GLOBALS['log']->calls['fatal']);
        self::assertSame(array(
            1 => array(
                'email_address' => 'test@email.com',
                'primary_address' => '0',
                'reply_to_address' => '0',
                'invalid_email' => '1',
                'opt_out' => '0',
                'email_address_id' => null,
            ),
        ), $this->ea->addresses);

        $q = "UPDATE email_addresses SET opt_out = 1, invalid_email = 1 WHERE email_address_caps = 'TEST@EMAIL.COM'";
        $db->query($q);
        $results = $this->ea->populateAddresses('', $module, array('emailAddress0' => 'test@email.com'));
        self::assertEquals(false, $results);
        self::assertCount(14, $GLOBALS['log']->calls['fatal']);
        self::assertSame(array(
            2 => array(
                'email_address' => 'test@email.com',
                'primary_address' => '0',
                'reply_to_address' => '0',
                'invalid_email' => '1',
                'opt_out' => '1',
                'email_address_id' => null,
            ),
        ), $this->ea->addresses);

        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);


        $GLOBALS['log'] = $logger;

        if(!empty($req)) {
            $_REQUEST = $req;
        } else {
            unset($_REQUEST);
        }

    }


    public function testAddAddress()
    {
        $this->ea->addAddress('test20@email.com', true);
        $this->ea->addAddress('test21@email.com', true);
        self::assertSame(array(
            0 => array (
                'email_address' => 'test20@email.com',
                'primary_address' => '0',
                'reply_to_address' => '0',
                'invalid_email' => '0',
                'opt_out' => '0',
                'email_address_id' => null,
            ),
            1 => array (
                'email_address' => 'test21@email.com',
                'primary_address' => '1',
                'reply_to_address' => '0',
                'invalid_email' => '0',
                'opt_out' => '0',
                'email_address_id' => null,
            ),
        ), $this->ea->addresses);
    }


    public function testUpdateFlags()
    {
        $db = DBManagerFactory::getInstance();

        //
        $i = 1;
        $q = "
          INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address, deleted) 
          VALUES ('test_email_bean_rel_{$i}', 'test_email_{$i}', 'test_contact_{$i}', 'Contacts', '0', '0')
        ";
        $db->query($q);
        $q = "INSERT INTO email_addresses (id, email_address, email_address_caps) VALUES ('test_email_{$i}', 'test@email.com', 'TEST@EMAIL.COM')";
        $db->query($q);
        $q = "INSERT INTO contacts (id) VALUES ('test_contact_{$i}')";
        $db->query($q);

        $this->ea->addAddress('test@email.com', true);

        $q = "UPDATE email_addresses SET opt_out = 0, invalid_email = 1 WHERE email_address_caps = 'TEST@EMAIL.COM'";
        $db->query($q);

        $this->ea->updateFlags();

        $q = "SELECT * FROM email_addresses WHERE email_address_caps = 'TEST@EMAIL.COM'";
        $r = $db->query($q);
        $a = $db->fetchByAssoc($r);

        self::assertSame(array(
            'id' => $a['id'],
            'email_address' => 'test@email.com',
            'email_address_caps' => 'TEST@EMAIL.COM',
            'invalid_email' => '0',
            'opt_out' => '0',
            'date_created' => $a['date_created'],
            'date_modified' => $a['date_modified'],
            'deleted' => '0',
        ), $a);


        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);
    }


    public function testSplitEmailAddress()
    {
        $result = $this->ea->splitEmailAddress(null);
        self::assertSame(array(
            'name' => '',
            'email' => '',
        ), $result);

        $result = $this->ea->splitEmailAddress('invalid');
        self::assertSame(array(
            'name' => 'invalid',
            'email' => '',
        ), $result);

        $result = $this->ea->splitEmailAddress('test@email.com');
        self::assertSame(array(
            'name' => '',
            'email' => 'test@email.com',
        ), $result);

        $result = $this->ea->splitEmailAddress('<Mr. Tester> test@email.com');
        self::assertSame(array(
            'name' => 'Mr. Tester test@email.com',
            'email' => '',
        ), $result);

        $result = $this->ea->splitEmailAddress('<Mr. Tester test@email.com');
        self::assertSame(array(
            'name' => 'Mr. Tester test@email.com',
            'email' => '',
        ), $result);

        $result = $this->ea->splitEmailAddress('Mr. Tester> test@email.com');
        self::assertSame(array(
            'name' => 'Mr. Tester test@email.com',
            'email' => '',
        ), $result);

        $result = $this->ea->splitEmailAddress('te st@email.com');
        self::assertSame(array(
            'name' => 'te st@email.com',
            'email' => '',
        ), $result);

        $result = $this->ea->splitEmailAddress('te st@ema il.com');
        self::assertSame(array(
            'name' => 'te st@ema il.com',
            'email' => '',
        ), $result);

        $result = $this->ea->splitEmailAddress('te st@em>a il.com');
        self::assertSame(array(
            'name' => 'te st@ema il.com',
            'email' => '',
        ), $result);

        $result = $this->ea->splitEmailAddress('te <st@ema il.com');
        self::assertSame(array(
            'name' => 'te st@ema il.com',
            'email' => '',
        ), $result);

        $result = $this->ea->splitEmailAddress('te st@em>a il.com');
        self::assertSame(array(
            'name' => 'te st@ema il.com',
            'email' => '',
        ), $result);

        $result = $this->ea->splitEmailAddress('te <st@em>a il.com');
        self::assertSame(array(
            'name' => 'te st@ema il.com',
            'email' => '',
        ), $result);

    }


    public function testCleanAddress()
    {
        $result = $this->ea->_cleanAddress(null);
        self::assertEquals('', $result);

        $result = $this->ea->_cleanAddress('<test>');
        self::assertEquals('test', $result);

        $result = $this->ea->_cleanAddress('<test@email.com>');
        self::assertEquals('test@email.com', $result);
    }


    public function testGetEmailGUID()
    {
        $db = DBManagerFactory::getInstance();

        //
        $q = "
          DELETE FROM email_addresses 
            WHERE 
              email_address_caps = ''";
        $db->query($q);

        $result = $this->ea->getEmailGUID(null);
        self::assertEquals('', $result);

        //
        $result = $this->ea->getEmailGUID('non-valid');
        self::assertEquals('8a208816-d028-19e3-cb59-5979ce84e8f3', $result);

        //
        $result = $this->ea->getEmailGUID('nonexists@nihil.com');
        self::assertEquals('4bbc4361-3fc1-d146-a840-5979ceb3e5fa', $result);

        //
        $result = $this->ea->getEmailGUID('test@email.com');
        self::assertTrue(isValidId($result));

        //
        $q = "
          DELETE FROM email_addresses 
            WHERE 
              email_address_caps = 'TEST@EMAIL.COM'";
        $db->query($q);

        $result = $this->ea->getEmailGUID('test@email.com');
        self::assertTrue(isValidId($result));
    }


    public function testAddUpdateEmailAddress()
    {
        //
        $db = DBManagerFactory::getInstance();

        //
        $result = $this->ea->AddUpdateEmailAddress(null);
        self::assertEquals('', $result);

        //
        $result = $this->ea->AddUpdateEmailAddress(null, 0, 0, 1);
        self::assertEquals('', $result);


        //
        $i = 1;
        $q = "
          INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address, deleted) 
          VALUES ('test_email_bean_rel_{$i}', 'test_email_{$i}', 'test_contact_{$i}', 'Contacts', '0', '0')
        ";
        $db->query($q);
        $q = "INSERT INTO email_addresses (id, email_address, email_address_caps) VALUES ('test_email_{$i}', 'test@email.com', 'TEST@EMAIL.COM')";
        $db->query($q);
        $q = "INSERT INTO contacts (id) VALUES ('test_contact_{$i}')";
        $db->query($q);

        // TODO: make testStast() first to set a value for $this->ea->stateBeforeWorkflow
        $result = $this->ea->AddUpdateEmailAddress(null, 0, 0, "test_email_{$i}");
        self::assertEquals('', $result);


        //
        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);
    }


    public function testGetPrimaryAddress()
    {
        $db = DBManagerFactory::getInstance();

        $c = new Contact();

        //
        $result = $this->ea->getPrimaryAddress($c);
        self::assertEquals('', $result);


        //
        $i = 1;
        $q = "
          INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address, deleted) 
          VALUES ('test_email_bean_rel_{$i}', 'test_email_{$i}', 'test_contact_{$i}', 'Contacts', '0', '0')
        ";
        $db->query($q);
        $q = "INSERT INTO email_addresses (id, email_address, email_address_caps) VALUES ('test_email_{$i}', 'test@email.com', 'TEST@EMAIL.COM')";
        $db->query($q);
        $q = "INSERT INTO contacts (id) VALUES ('test_contact_{$i}')";
        $db->query($q);

        $c->id = "test_contact_{$i}";
        $c->save();
        $result = $this->ea->getPrimaryAddress($c);
        self::assertEquals('test@email.com', $result);

        //
        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);
    }


    public function testGetReplyToAddress()
    {
        $db = DBManagerFactory::getInstance();

        $c = BeanFactory::getBean('Contacts');


        //
        $i = 1;
        $q = "
          INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address, deleted) 
          VALUES ('test_email_bean_rel_{$i}', 'test_email_{$i}', 'test_contact_{$i}', 'Contacts', '0', '0')
        ";
        $db->query($q);
        $q = "INSERT INTO email_addresses (id, email_address, email_address_caps) VALUES ('test_email_{$i}', 'test@email.com', 'TEST@EMAIL.COM')";
        $db->query($q);
        $q = "INSERT INTO contacts (id) VALUES ('test_contact_{$i}')";
        $db->query($q);

        $c->id = "test_contact_{$i}";
        $c->save();

        $query = "UPDATE email_addr_bean_rel SET deleted = 0 WHERE email_address_id = 'test_email_{$i}'";
        $db->query($query);

        $result = $this->ea->getReplyToAddress($c);
        self::assertEquals('test@email.com', $result);

        $query = "UPDATE email_addr_bean_rel SET reply_to_address = 1 WHERE email_address_id = 'test_email_{$i}'";
        $db->query($query);

        $result = $this->ea->getReplyToAddress($c, true);
        self::assertEquals('test@email.com', $result);

        //
        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);


        //
        $result = $this->ea->getReplyToAddress($c);
        self::assertEquals('', $result);

        //
        $result = $this->ea->getReplyToAddress($c, true);
        self::assertEquals('', $result);

    }


    public function testGetAddressesByGUID()
    {

        $db = DBManagerFactory::getInstance();

        //
        $id = null;
        $module = null;

        $query = "
            SELECT count(*) as cnt
                FROM email_addresses ea 
                LEFT JOIN email_addr_bean_rel ear ON ea.id = ear.email_address_id
                WHERE ear.bean_module = '' AND ear.bean_id = '' AND ear.deleted = 0";
        $r = $db->query($query);
        $row = $db->fetchByAssoc($r);
        $cnt = $row['cnt'];

        $result = $this->ea->getAddressesByGUID($id, $module);
        $count = count($result);
        self::assertEquals($cnt, $count);

        //
        $id = 'non-exists-xyz';
        $module = null;

        $result = $this->ea->getAddressesByGUID($id, $module);
        $count = count($result);
        self::assertEquals(0, $count);

        //
        $c = BeanFactory::getBean('Contacts');
        $c->email1 = 'test30@email.com';
        //$c->save();

        $id = $c->id;
        $module = $c->module_name;

        $result = $this->ea->getAddressesByGUID($id, $module);
        self::assertCount(0, $result);

    }


    public function testGetEmailAddressWidgetEditView()
    {
        $db = DBManagerFactory::getInstance();

        $logger = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        $env = array();
        if(isset($_POST)) {
            $env['$_POST'] = $_POST;
        }
        if(isset($_GET)) {
            $env['$_GET'] = $_GET;
        }
        if(isset($_REQUEST)) {
            $env['$_REQUEST'] = $_REQUEST;
        }

        $i = 1;
        $q = "
          INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address, deleted) 
          VALUES ('test_email_bean_rel_{$i}', 'test_email_{$i}', 'test_contact_{$i}', 'Contacts', '0', '0')
        ";
        $db->query($q);
        $q = "INSERT INTO email_addresses (id, email_address_caps) VALUES ('test_email_{$i}', 'TEST@EMAIL.COM')";
        $db->query($q);
        $q = "INSERT INTO contacts (id) VALUES ('test_contact_{$i}')";
        $db->query($q);


        //
        $result = $this->ea->getEmailAddressWidgetEditView(null, null);
        self::assertEquals(false, $result);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        $result = $this->ea->getEmailAddressWidgetEditView('non-exists', null);
        self::assertEquals(false, $result);
        self::assertCount(2, $GLOBALS['log']->calls['fatal']);

        $result = $this->ea->getEmailAddressWidgetEditView(null, 'non-exists');
        self::assertEquals(false, $result);
        self::assertCount(3, $GLOBALS['log']->calls['fatal']);

        //
        $_REQUEST['full_form'] = true;
        $_REQUEST['emailAddressWidget'] = true;
        $_REQUEST['non-exists-module0emailAddress0'] = true;

        $result = $this->ea->getEmailAddressWidgetEditView('', 'non-exists-module', true);

        self::assertNotFalse(strpos($result['html'], 'non-exists-module'));
        self::assertNotFalse(
            strpos(
                $result['html'],
                '[{"email_address":true,"primary_address":false,"invalid_email":false,"opt_out":false,"reply_to_address":false}]'
            )
        );

        self::assertCount(2, $result);
        self::assertSame(array(
            0 => array (
                'email_address' => true,
                'primary_address' => false,
                'invalid_email' => false,
                'opt_out' => false,
                'reply_to_address' => false,
            ),
        ), $result['prefillData']);
        $expected = !empty($result['html']) && is_string($result['html']);
        self::assertTrue($expected);

        if(isset($env['$_REQUEST'])) {
            $_REQUEST = $env['$_REQUEST'];
        }

        //
        $_REQUEST['full_form'] = true;
        $_REQUEST['emailAddressWidget'] = true;
        $_REQUEST['non-exists-module0emailAddress0'] = true;

        $result = $this->ea->getEmailAddressWidgetEditView('', 'non-exists-module');

        self::assertNotFalse(strpos($result, 'non-exists-module'));
        self::assertNotFalse(
            strpos(
                $result,
                '[{"email_address":true,"primary_address":false,"invalid_email":false,"opt_out":false,"reply_to_address":false}]'
            )
        );

        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);

        if(isset($env['$_REQUEST'])) {
            $_REQUEST = $env['$_REQUEST'];
        }

        //
        $_REQUEST['full_form'] = true;
        $_REQUEST['emailAddressWidget'] = true;

        $result = $this->ea->getEmailAddressWidgetEditView('', 'non-exists-module');

        self::assertNotFalse(strpos($result, 'non-exists-module'));
        self::assertNotFalse(
            strpos(
                $result,
                '[{"email_address":true,"primary_address":false,"invalid_email":false,"opt_out":false,"reply_to_address":false}]'
            )
        );

        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);

        if(isset($env['$_REQUEST'])) {
            $_REQUEST = $env['$_REQUEST'];
        }

        //
        $result = $this->ea->getEmailAddressWidgetEditView('non-exists-id', 'non-exists-module');

        self::assertNotFalse(strpos($result, 'non-exists-module'));
        self::assertNotFalse(strpos($result, 'new Object()'));

        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);

        //
        $_POST['is_converted'] = true;
        $result = $this->ea->getEmailAddressWidgetEditView('non-exists-id', 'non-exists-module');

        self::assertNotFalse(strpos($result, 'non-exists-module'));
        self::assertNotFalse(strpos($result, 'new Object()'));

        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);
        self::assertCount(10, $GLOBALS['log']->calls['fatal']);

        //
        $_POST['is_converted'] = true;
        $_POST['return_id'] = 'any-non-exists-id';
        $result = $this->ea->getEmailAddressWidgetEditView('non-exists-id', 'non-exists-module');

        self::assertNotFalse(strpos($result, 'non-exists-module'));
        self::assertNotFalse(strpos($result, 'new Object()'));

        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);
        self::assertCount(12, $GLOBALS['log']->calls['fatal']);

        //
        $_POST['is_converted'] = true;
        $_POST['return_module'] = 'any-non-exists-module';
        $result = $this->ea->getEmailAddressWidgetEditView('non-exists-id', 'non-exists-module');

        self::assertNotFalse(strpos($result, 'non-exists-module'));
        self::assertNotFalse(strpos($result, 'new Object()'));

        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);
        self::assertCount(13, $GLOBALS['log']->calls['fatal']);

        //
        $result = $this->ea->getEmailAddressWidgetEditView('non-exists-id', 'Contacts');

        self::assertNotFalse(strpos($result, 'Contacts'));
        self::assertNotFalse(strpos($result, 'new Object()'));

        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);

        $noModuleResult = $result;

        //
        $result = $this->ea->getEmailAddressWidgetEditView('non-exists-id', 'Users');

        self::assertNotFalse(strpos($result, 'Users'));
        self::assertNotFalse(strpos($result, 'new Object()'));

        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);
        self::assertNotEquals($noModuleResult, $result);

        //
        $_POST['return_id'] = 'test_contact_1';
        $_POST['return_module'] = 'Contacts';
        $result = $this->ea->getEmailAddressWidgetEditView('test_contact_1', 'Contacts');

        self::assertNotFalse(strpos($result, 'Contacts'));
        self::assertNotFalse(strpos($result, '[{"email_address":null,"email_address_caps":"TEST@EMAIL.COM","invalid_email":"0","opt_out":"0","date_created":null,"date_modified":null,"id":"test_email_bean_rel_1","email_address_id":"test_email_1","bean_id":"test_contact_1","bean_module":"Contacts","primary_address":"0","reply_to_address":"0","deleted":"0"},{"email_address":null,"email_address_caps":"TEST@EMAIL.COM","invalid_email":"0","opt_out":"0","date_created":null,"date_modified":null,"id":"","email_address_id":"test_email_1","bean_id":"test_contact_1","bean_module":"Contacts","primary_address":"0","reply_to_address":"1","deleted":"0"}]'));

        self::assertNotEquals($noModuleResult, $result);
        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);

        //
        $_POST['return_id'] = 'non-exists-id';
        $_POST['return_module'] = 'Contacts';
        $result = $this->ea->getEmailAddressWidgetEditView('test_contact_1', 'Contacts');

        self::assertNotFalse(strpos($result, 'Contacts'));
        self::assertNotFalse(strpos($result, 'new Object()'));

        self::assertEquals($noModuleResult, $result);
        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);

        //
        $_REQUEST['full_form'] = true;
        $_REQUEST['emailAddressWidget'] = true;
        $_REQUEST['non-exists-module0emailAddress0'] = true;
        $this->ea->view = 'QuickCreate';
        $_REQUEST['action'] = true;

        $result = $this->ea->getEmailAddressWidgetEditView('', 'non-exists-module');

        self::assertNotFalse(strpos($result, 'non-exists-module'));
        self::assertNotFalse(strpos($result, 'new Object()'));

        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);

        if(isset($env['$_REQUEST'])) {
            $_REQUEST = $env['$_REQUEST'];
        }

        //
        $_REQUEST['full_form'] = true;
        $_REQUEST['emailAddressWidget'] = true;
        $_REQUEST['non-exists-module0emailAddress0'] = true;
        $this->ea->view = 'QuickCreate';
        $_REQUEST['action'] = true;

        $result = $this->ea->getEmailAddressWidgetEditView('', 'Contacts');

        self::assertNotFalse(strpos($result, 'Contacts'));
        self::assertNotFalse(strpos($result, 'new Object()'));

        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);

        if(isset($env['$_REQUEST'])) {
            $_REQUEST = $env['$_REQUEST'];
        }

        //
        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);

        if(isset($env['$_POST'])) {
            $_POST = $env['$_POST'];
        }
        if(isset($env['$_GET'])) {
            $_GET = $env['$_GET'];
        }
        if(isset($env['$_REQUEST'])) {
            $_REQUEST = $env['$_REQUEST'];
        }

        $GLOBALS['log'] = $logger;
    }


    public function testGetEmailAddressWidgetDetailView()
    {
        $db = DBManagerFactory::getInstance();

        $i = 1;
        $q = "
          INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address, deleted) 
          VALUES ('test_email_bean_rel_{$i}', 'test_email_{$i}', 'test_contact_{$i}', 'Contacts', '0', '0')
        ";
        $db->query($q);
        $q = "INSERT INTO email_addresses (id, email_address_caps) VALUES ('test_email_{$i}', 'TEST@EMAIL.COM')";
        $db->query($q);
        $q = "INSERT INTO contacts (id) VALUES ('test_contact_{$i}')";
        $db->query($q);


        //
        $result = $this->ea->getEmailAddressWidgetDetailView(null);
        self::assertEquals('', $result);

        //
        $c = BeanFactory::getBean('Contacts');
        $result = $this->ea->getEmailAddressWidgetDetailView($c);
        self::assertEquals('', $result);

        //
        $c = BeanFactory::getBean('Contacts');
        $c->id = 'an-non-exists-id';
        $result = $this->ea->getEmailAddressWidgetDetailView($c);
        self::assertNotFalse(strpos($result, '--None--'));

        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);

        //
        $c->id = "test_contact_{$i}";
        $result = $this->ea->getEmailAddressWidgetDetailView($c);
        self::assertFalse(strpos($result, '--None--'));

        $expected = !empty($result) && is_string($result);
        self::assertTrue($expected);


        //
        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);
    }


    public function testGetEmailAddressWidgetDuplicatesView()
    {

        $logger = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        $env = array();
        if(isset($_POST)) {
            $env['$_POST'] = $_POST;
        }
        if(isset($_GET)) {
            $env['$_GET'] = $_GET;
        }
        if(isset($_REQUEST)) {
            $env['$_REQUEST'] = $_REQUEST;
        }


        //
        $result = $this->ea->getEmailAddressWidgetDuplicatesView(null);
        self::assertEquals('', $result);
        self::assertCount(2, $GLOBALS['log']->calls['fatal']);

        //
        $_POST['emailAddressPrimaryFlag'] = '';
        $result = $this->ea->getEmailAddressWidgetDuplicatesView(null);
        self::assertEquals('', $result);
        self::assertCount(4, $GLOBALS['log']->calls['fatal']);

        //
        $_POST['emailAddressPrimaryFlag'] = '';
        $_POST['emailAddress0'] = true;
        $result = $this->ea->getEmailAddressWidgetDuplicatesView(null);
        self::assertEquals('<input type="hidden" name="_email_widget_id" value="">
<input type="hidden" name="emailAddressWidget" value="">

<input type="hidden" name="emailAddress0" value="1">

<input type="hidden" name="emailAddressPrimaryFlag" value="">
<input type="hidden" name="useEmailWidget" value="true">', $result);
        self::assertCount(6, $GLOBALS['log']->calls['fatal']);

        //
        $_POST['emailAddressPrimaryFlag'] = '';
        $_POST['emailAddress0'] = true;
        $_POST['emailAddressOptOutFlag'] = true;
        $result = $this->ea->getEmailAddressWidgetDuplicatesView(null);
        self::assertEquals('<input type="hidden" name="_email_widget_id" value="">
<input type="hidden" name="emailAddressWidget" value="">

<input type="hidden" name="emailAddress0" value="1">

<input type="hidden" name="emailAddressPrimaryFlag" value="">
<input type="hidden" name="emailAddressOptOutFlag[]" value="1">
<input type="hidden" name="useEmailWidget" value="true">', $result);
        self::assertCount(9, $GLOBALS['log']->calls['fatal']);

        //
        $_POST['emailAddressPrimaryFlag'] = '';
        $_POST['emailAddressInvalidFlag'] = '';
        $_POST['emailAddress0'] = true;
        $result = $this->ea->getEmailAddressWidgetDuplicatesView(null);
        self::assertEquals('<input type="hidden" name="_email_widget_id" value="">
<input type="hidden" name="emailAddressWidget" value="">

<input type="hidden" name="emailAddress0" value="1">

<input type="hidden" name="emailAddressVerifiedValue0" value="">
<input type="hidden" name="emailAddressPrimaryFlag" value="">
<input type="hidden" name="emailAddressOptOutFlag[]" value="1">
<input type="hidden" name="emailAddressInvalidFlag[]" value="">
<input type="hidden" name="emailAddressReplyToFlag[]" value="">
<input type="hidden" name="emailAddressDeleteFlag[]" value="">
<input type="hidden" name="useEmailWidget" value="true">', $result);
        self::assertCount(13, $GLOBALS['log']->calls['fatal']);

        //
        $_POST['emailAddressPrimaryFlag'] = '';
        $_POST['emailAddressReplyToFlag'] = '';
        $_POST['emailAddress0'] = true;
        $result = $this->ea->getEmailAddressWidgetDuplicatesView(null);
        self::assertEquals('<input type="hidden" name="_email_widget_id" value="">
<input type="hidden" name="emailAddressWidget" value="">

<input type="hidden" name="emailAddress0" value="1">

<input type="hidden" name="emailAddressVerifiedValue0" value="">
<input type="hidden" name="emailAddressPrimaryFlag" value="">
<input type="hidden" name="emailAddressOptOutFlag[]" value="1">
<input type="hidden" name="emailAddressInvalidFlag[]" value="">
<input type="hidden" name="emailAddressReplyToFlag[]" value="">
<input type="hidden" name="emailAddressDeleteFlag[]" value="">
<input type="hidden" name="useEmailWidget" value="true">', $result);
        self::assertCount(18, $GLOBALS['log']->calls['fatal']);

        //
        $_POST['emailAddressPrimaryFlag'] = '';
        $_POST['emailAddressDeleteFlag'] = '';
        $_POST['emailAddress0'] = true;
        $result = $this->ea->getEmailAddressWidgetDuplicatesView(null);
        self::assertEquals('<input type="hidden" name="_email_widget_id" value="">
<input type="hidden" name="emailAddressWidget" value="">

<input type="hidden" name="emailAddress0" value="1">

<input type="hidden" name="emailAddressVerifiedValue0" value="">
<input type="hidden" name="emailAddressPrimaryFlag" value="">
<input type="hidden" name="emailAddressOptOutFlag[]" value="1">
<input type="hidden" name="emailAddressInvalidFlag[]" value="">
<input type="hidden" name="emailAddressReplyToFlag[]" value="">
<input type="hidden" name="emailAddressDeleteFlag[]" value="">
<input type="hidden" name="useEmailWidget" value="true">', $result);
        self::assertCount(24, $GLOBALS['log']->calls['fatal']);

        //
        $_POST['emailAddressPrimaryFlag'] = '';
        $_POST['emailAddressVerifiedValue1'] = '';
        $_POST['emailAddress0'] = true;
        $result = $this->ea->getEmailAddressWidgetDuplicatesView(null);
        self::assertEquals('<input type="hidden" name="_email_widget_id" value="">
<input type="hidden" name="emailAddressWidget" value="">

<input type="hidden" name="emailAddress0" value="1">

<input type="hidden" name="emailAddressVerifiedValue0" value="">
<input type="hidden" name="emailAddressPrimaryFlag" value="">
<input type="hidden" name="emailAddressOptOutFlag[]" value="1">
<input type="hidden" name="emailAddressInvalidFlag[]" value="">
<input type="hidden" name="emailAddressReplyToFlag[]" value="">
<input type="hidden" name="emailAddressDeleteFlag[]" value="">
<input type="hidden" name="useEmailWidget" value="true">', $result);
        self::assertCount(31, $GLOBALS['log']->calls['fatal']);


        //
        if(isset($env['$_POST'])) {
            $_POST = $env['$_POST'];
        }
        if(isset($env['$_GET'])) {
            $_GET = $env['$_GET'];
        }
        if(isset($env['$_REQUEST'])) {
            $_REQUEST = $env['$_REQUEST'];
        }

        $GLOBALS['log'] = $logger;
    }


    public function testGetFormBaseURL()
    {
        //
        $logger = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        $env = array();
        if(isset($_POST)) {
            $env['$_POST'] = $_POST;
        }
        if(isset($_GET)) {
            $env['$_GET'] = $_GET;
        }
        if(isset($_REQUEST)) {
            $env['$_REQUEST'] = $_REQUEST;
        }

        $focus = new Contact();


        //
        $result = $this->ea->getFormBaseURL(null);
        self::assertEquals(false, $result);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        //
        $result = $this->ea->getFormBaseURL($focus);
        self::assertEquals('&Contacts_email_widget_id=&emailAddressWidget=', $result);
        self::assertCount(3, $GLOBALS['log']->calls['fatal']);

        //
        $_POST['Contacts_email_widget_id'] = 'testid';
        $result = $this->ea->getFormBaseURL($focus);
        self::assertEquals('&Contacts_email_widget_id=testid&emailAddressWidget=', $result);
        self::assertCount(4, $GLOBALS['log']->calls['fatal']);

        //
        $_POST['emailAddressWidget'] = 'testaddress';
        $result = $this->ea->getFormBaseURL($focus);
        self::assertEquals('&Contacts_email_widget_id=testid&emailAddressWidget=testaddress', $result);
        self::assertCount(4, $GLOBALS['log']->calls['fatal']);

        //
        $_REQUEST['ContactstestidemailAddress0'] = 'testadrr0';
        $result = $this->ea->getFormBaseURL($focus);
        self::assertEquals(
            '&Contacts_email_widget_id=testid&emailAddressWidget=testaddress&ContactstestidemailAddress0=testadrr0',
            $result
        );
        self::assertCount(4, $GLOBALS['log']->calls['fatal']);

        //
        $_REQUEST['ContactstestidemailAddressVerifiedValue1'] = 'testverfdv1';
        $result = $this->ea->getFormBaseURL($focus);
        self::assertEquals('&Contacts_email_widget_id=testid&emailAddressWidget=testaddress' .
            '&ContactstestidemailAddress0=testadrr0&ContactstestidemailAddressVerifiedValue1=testverfdv1', $result);
        self::assertCount(4, $GLOBALS['log']->calls['fatal']);

        //
        $_REQUEST['ContactstestidemailAddressPrimaryFlag'] = 'testadentprimflg';
        $result = $this->ea->getFormBaseURL($focus);
        self::assertEquals('&Contacts_email_widget_id=testid&emailAddressWidget=testaddress' .
            '&ContactstestidemailAddress0=testadrr0&ContactstestidemailAddressVerifiedValue1=testverfdv1' .
            '&ContactstestidemailAddressPrimaryFlag=testadentprimflg', $result);
        self::assertCount(4, $GLOBALS['log']->calls['fatal']);

        //
        $_REQUEST['ContactstestidemailAddressPrimaryFlag'] = array('testadentprimflg1', 'testadentprimflg2');
        $result = $this->ea->getFormBaseURL($focus);
        self::assertEquals('&Contacts_email_widget_id=testid&emailAddressWidget=testaddress' .
            '&ContactstestidemailAddress0=testadrr0&ContactstestidemailAddressVerifiedValue1=testverfdv1' .
            '&ContactstestidemailAddressPrimaryFlag[0]=testadentprimflg1' .
            '&ContactstestidemailAddressPrimaryFlag[1]=testadentprimflg2', $result);
        self::assertCount(4, $GLOBALS['log']->calls['fatal']);


        //
        if(isset($env['$_POST'])) {
            $_POST = $env['$_POST'];
        }
        if(isset($env['$_GET'])) {
            $_GET = $env['$_GET'];
        }
        if(isset($env['$_REQUEST'])) {
            $_REQUEST = $env['$_REQUEST'];
        }

        $GLOBALS['log'] = $logger;
    }


    public function testSetView()
    {
        $before = $this->ea->view;
        $this->ea->setView('afterView');
        self::assertEquals('afterView', $this->ea->view);
        $this->ea->setView($before);
        self::assertEquals($before, $this->ea->view);
    }


    public function testGetCorrectedModule()
    {
        //
        $module = null;
        $result = $this->ea->getCorrectedModule($module);
        self::assertSame($module, $result);

        //
        $module = '';
        $result = $this->ea->getCorrectedModule($module);
        self::assertSame('', $result);

        //
        $module = 'Nonexists';
        $result = $this->ea->getCorrectedModule($module);
        self::assertSame('Nonexists', $result);

        //
        $module = 'Contacts';
        $result = $this->ea->getCorrectedModule($module);
        self::assertSame('Contacts', $result);

        //
        $module = 'Employees';
        $result = $this->ea->getCorrectedModule($module);
        self::assertSame('Users', $result);

    }


    public function testStash()
    {
        $db = DBManagerFactory::getInstance();

        $c = new Contact();

        $logger = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        //
        $this->ea->stash(null, null);
        self::assertNotTrue(isset($GLOBALS['log']->calls['fatal']));

        //
        $i = 1;
        $q = "
          INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address, deleted) 
          VALUES ('test_email_bean_rel_{$i}', 'test_email_{$i}', 'test_contact_{$i}', 'Contacts', '0', '0')
        ";
        $db->query($q);
        $q = "INSERT INTO email_addresses (id, email_address, email_address_caps) VALUES ('test_email_{$i}', 'test@email.com', 'TEST@EMAIL.COM')";
        $db->query($q);
        $q = "INSERT INTO contacts (id) VALUES ('test_contact_{$i}')";
        $db->query($q);

        $c->id = "test_contact_{$i}";
        $c->save();

        $this->ea->stash($c->id, 'Contacts');
        self::assertNotTrue(isset($GLOBALS['log']->calls['fatal']));


        //
        $GLOBALS['log'] = $logger;

        $q = "DELETE FROM email_addr_bean_rel WHERE id = 'test_email_bean_rel_{$i}'";
        $db->query($q);
        $q = "DELETE FROM email_addresses WHERE id = 'test_email_{$i}'";
        $db->query($q);
        $q = "DELETE FROM contacts WHERE id = 'test_contact_{$i}'";
        $db->query($q);
    }


    public function testGetEmailAddressWidget()
    {
        //
        $c = new Contact();
        $c->save();

        $a = new Account();
        $a->save();

        $logger = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        //
        $result = getEmailAddressWidget($c, null, null, 'ConvertLead');
        self::assertFalse(strpos($result, '--None--'));
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);


        //
        $result = getEmailAddressWidget($a, null, null, 'ConvertLead');
        self::assertFalse(strpos($result, '--None--'));

        //
        $result = getEmailAddressWidget($c, null, null, 'EditView');
        self::assertFalse(strpos($result, '--None--'));

        //
        $result = getEmailAddressWidget($c, null, null, 'DetailView');
        self::assertEquals('
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
					<td>
						<i>--None--</i>
					</td>
				</tr>
							</table>', $result);

        //
        $result = getEmailAddressWidget(null, null, null, null);
        self::assertEquals('', $result);


        //
        $GLOBALS['log'] = $logger;
    }

}