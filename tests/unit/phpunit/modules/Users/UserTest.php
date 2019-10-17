<?php


class UserTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testgetSignatureButtons()
    {
        self::markTestIncomplete('environment dependency');
        
        global $mod_strings;

        $user = new User();

        //preset required values
        $user->retrieve(1);
        $mod_strings['LBL_BUTTON_EDIT'] = "";
        $mod_strings['LBL_BUTTON_CREATE'] = "";


        //test with defaultDisplay false
        $expected = "<input class='button' onclick='javascript:open_email_signature_form(\"\", \"1\");' value='' type='button'>&nbsp;<span name=\"edit_sig\" id=\"edit_sig\" style=\"visibility:hidden;\"><input class=\"button\" onclick=\"javascript:open_email_signature_form(document.getElementById('signature_id', '').value)\" value=\"\" type=\"button\" tabindex=\"392\">&nbsp;
					</span>";
        $actual = $user->getSignatureButtons('');
        $this->assertSame($expected, $actual);


        //test with defaultDisplay true
        $expected = "<input class='button' onclick='javascript:open_email_signature_form(\"\", \"1\");' value='' type='button'>&nbsp;<span name=\"edit_sig\" id=\"edit_sig\" style=\"visibility:inherit;\"><input class=\"button\" onclick=\"javascript:open_email_signature_form(document.getElementById('signature_id', '').value)\" value=\"\" type=\"button\" tabindex=\"392\">&nbsp;
					</span>";
        $actual = $user->getSignatureButtons('', true);
        $this->assertSame($expected, $actual);
    }

    public function testUser()
    {

        //execute the contructor and check for the Object type and  attributes
        $user = new User();

        $this->assertInstanceOf('User', $user);
        $this->assertInstanceOf('Person', $user);
        $this->assertInstanceOf('SugarBean', $user);

        $this->assertAttributeEquals('Users', 'module_dir', $user);
        $this->assertAttributeEquals('User', 'object_name', $user);
        $this->assertAttributeEquals('users', 'table_name', $user);

        $this->assertAttributeEquals(true, 'new_schema', $user);
        $this->assertAttributeEquals(false, 'authenticated', $user);
        $this->assertAttributeEquals(true, 'importable', $user);
        $this->assertAttributeEquals(false, 'team_exists', $user);
    }


    public function testgetSystemUser()
    {
        self::markTestIncomplete('environment dependency');
        
        $user = new User();

        $result = $user->getSystemUser();

        $this->assertInstanceOf('User', $result);
        $this->assertEquals(1, $result->id);
    }


    public function testgetDefaultSignature()
    {
        // store state
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        // test
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();

        $user = new User();

        $user->retrieve(1);

        $result = $user->getDefaultSignature();
        $this->assertTrue(is_array($result));
        
        // clean up
        $state->popTable('email_addresses');
        $state->popGlobals();
    }


    public function testgetSignature()
    {
        $user = new User();

        $user->retrieve(1);

        $result = $user->getSignature(1);
        $this->assertEquals(false, $result);
    }

    public function testgetSignaturesArray()
    {
        $user = new User();

        $user->retrieve(1);

        $result = $user->getSignaturesArray();
        $this->assertTrue(is_array($result));
    }


    public function testgetSignatures()
    {
        $user = new User();

        $user->retrieve(1);

        $expected = "<select onChange='setSigEditButtonVisibility();' id='signature_id' name='signature_id'>\n<OPTION selected value=''>--None--</OPTION>";
        $actual = $user->getSignatures();
        $this->assertTrue(strpos($actual, $expected) === 0);
        $this->assertEquals(preg_match('/\<\/select\>$/', $actual), 1);
    }

    public function testhasPersonalEmail()
    {
        $user = new User();

        $user->retrieve(2);

        $result = $user->hasPersonalEmail();
        $this->assertEquals(false, $result);
    }


    public function testgetUserPrivGuid()
    {
        self::markTestIncomplete('environment dependency');
                
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();

        $user = new User();

        $user->retrieve(1);

        try {
            $result = $user->getUserPrivGuid();
            $this->fail('This function sould throws an Exception.');
        } catch (Exception $e) {
        }

        $this->assertTrue(isset($result));
        $this->assertEquals(36, strlen($result));
    }

    public function testsetUserPrivGuid()
    {
        self::markTestIncomplete('environment dependency');
                
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();

        $user = new User();

        $user->retrieve(1);

        $user->setUserPrivGuid();

        $result = $user->getPreference('userPrivGuid', 'global', $user);

        $this->assertTrue(isset($result));
        $this->assertEquals(36, strlen($result));
    }

    public function testSetAndGetAndResetPreference()
    {
        self::markTestIncomplete('environment dependency');

        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();

        $user = new User();

        $user->retrieve(1);


        //test setPreference method
        $user->setPreference('userPrivGuid', 'someGuid', 0, 'global', $user);


        //test getPreference method
        $result = $user->getPreference('userPrivGuid', 'global', $user);
        $this->assertTrue(isset($result));
        $this->assertEquals('someGuid', $result);


        //test resetPreferences method and verify that created preference is no longer available
        $user->resetPreferences();
        $result = $user->getPreference('userPrivGuid', 'global', $user);
        $this->assertFalse(isset($result));
    }


    public function testsavePreferencesToDB()
    {
        $user = new User();

        $user->retrieve(1);

        //execute the method and test if it works and does not throws an exception.
        try {
            $user->savePreferencesToDB();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }



    public function testgetUserDateTimePreferences()
    {
        self::markTestIncomplete('environment dependency');
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();

        $user = new User();

        $user->retrieve(1);

        $result = $user->getUserDateTimePreferences();

        $this->assertTrue(is_array($result));
        $this->assertTrue(isset($result['date']));
        $this->assertTrue(isset($result['time']));
        $this->assertTrue(isset($result['userGmt']));
        $this->assertTrue(isset($result['userGmtOffset']));
    }



    public function testGetETagSeedAndIncrementETag()
    {
        self::markTestIncomplete('environment dependency');
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();

        $user = new User();

        $user->retrieve(1);

        //execute getETagSeed method, get Etag value
        $ETagInitial = $user->getETagSeed('test');
        $this->assertGreaterThanOrEqual(0, $ETagInitial);


        //execute incrementETag to increment
        $user->incrementETag('test');


        //execute getETagSeed method again, get Etag final value and  compare final and initial values
        $ETagFinal = $user->getETagSeed('test');
        $this->assertGreaterThan($ETagInitial, $ETagFinal);
    }


    public function testgetLicensedUsersWhere()
    {
        $expected = "deleted=0 AND status='Active' AND user_name IS NOT NULL AND is_group=0 AND portal_only=0  AND LENGTH(user_name)>0";
        $actual = User::getLicensedUsersWhere();
        $this->assertSame($expected, $actual);
    }

    public function testget_summary_text()
    {
        $user = new User();

        //test without setting name
        $this->assertEquals(null, $user->get_summary_text());

        //test with name set
        $user->name = "test";
        $this->assertEquals('test', $user->get_summary_text());
    }

    public function testbean_implements()
    {
        $user = new User();

        $this->assertEquals(false, $user->bean_implements('')); //test with blank value
        $this->assertEquals(false, $user->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $user->bean_implements('ACL')); //test with valid value
    }


    public function testcheck_role_membership()
    {
        self::markTestIncomplete('environment dependency');
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();

        $user = new User();

        $result = $user->check_role_membership("test", '');
        $this->assertEquals(false, $result);


        $result = $user->check_role_membership("test", '1');
        $this->assertEquals(false, $result);
    }


    public function testsaveAndOthers()
    {
        self::markTestIncomplete('environment dependency');
        $state = new SuiteCRM\StateSaver();
        
        
        

        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset($db->database);
        $db->checkConnection();


        $user = new User();

        $user->user_name = "test";

        $user->first_name = "firstn";
        $user->last_name = "lastn";

        $user->email1 = "one@email.com";
        $user->email2 = "two@email.com";

        $result = $user->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($user->id));
        $this->assertEquals(36, strlen($user->id));


        //test retrieve method
        $this->retrieve($user->id);


        //test retrieve_by_email_address method
        $this->retrieve_by_email_address($user->id);


        //test newPassword And findUserPassword methods
        $this->NewPasswordAndFindUserPassword($user->id);

        //test authenticate_user method
        $this->authenticate_user($user->id);


        //test load_user method
        $this->load_user($user->id);


        //test change_password method
        $this->change_password($user->id);

        //test getPreferredEmail method
        $this->getPreferredEmail($user->id);


        //test getUsersNameAndEmail method
        $this->getUsersNameAndEmail($user->id);


        //test getEmailInfo method
        $this->getEmailInfo($user->id);


        //change username and delete the user to avoid picking it up by password in future
        $user->user_name = "test_deleted";
        $user->save();
        $user->mark_deleted($user->id);
        
        // clean up
    }

    public function retrieve($id)
    {
        $user = new User();

        $user->retrieve($id);

        $this->assertEquals("test", $user->user_name);

        $this->assertEquals("firstn", $user->first_name);
        $this->assertEquals("lastn", $user->last_name);

        $this->assertEquals("one@email.com", $user->email1);
        $this->assertEquals("two@email.com", $user->email2);
    }

    public function retrieve_by_email_address($id)
    {
        $user = new User();

        //test with invalid email
        $user->retrieve_by_email_address("wrongone@email.com");
        $this->assertEquals('', $user->id);


        //test with valid email and test for record ID to verify that record is same
        $user = BeanFactory::getBean('Users', $id);
        $rand = mt_rand(1, 10000);
        $email = "one{$rand}@email.com";
        $user->email1 = $email;
        $user->save();
        $user->retrieve_by_email_address($email);
        $this->assertTrue(isset($user->id));
        $this->assertEquals($id, $user->id);
    }

    public function NewPasswordAndFindUserPassword($id)
    {
        $user = new User();

        $user->retrieve($id);

        // preset
        $query = "DELETE FROM users WHERE user_name = '{$user->user_name}' AND id != '$id'";
        DBManagerFactory::getInstance()->query($query);


        //set user password and then retrieve user by created password
        $rand = 1;
        $pwd = 'test' . $rand;
        $user->setNewPassword($pwd);

        $result = User::findUserPassword($user->user_name, md5($pwd), '', true);

        // here is a really unpredictable mysql connection issue why this test is unstable
        // but should works on a correct test environments:
        // $this->assertTrue(isset($result['id']));
        // $this->assertEquals($id, $result['id']);
    }

    // --- OK
 
    public function authenticate_user($id)
    {
        $user = new User();

        $user->retrieve($id);

        //test with invalid password
        $result = $user->authenticate_user(md5("pass"));
        $this->assertEquals(false, $result);

        //test with invalid password

        $result = $user->authenticate_user(md5("test1"));
        $this->assertEquals(true, $result);
    }


    public function load_user($id)
    {
        $user = new User();

        $user->retrieve($id);

        $result = $user->load_user("test1");

        $this->assertEquals(true, $result->authenticated);
    }

    public function change_password($id)
    {
        $user = new User();

        $user->retrieve($id);

        //execute the method and verifh that it returns true
        $result = $user->change_password("test1", "testpass");
        $this->assertEquals(true, $result);


        //find the user by new password
        $result = User::findUserPassword("test", md5("testpass"));

        $this->assertTrue(isset($result['id']));
        $this->assertEquals($id, $result['id']);
    }

    public function getPreferredEmail($id)
    {
        $user = new User();

        $user->retrieve($id);

        $actual = $user->getPreferredEmail();

        self::assertEquals('firstn lastn', $actual['name']);
        $preg = preg_match('/^one\d{0,}\@email\.com$/', $actual['email'], $matches);
        self::assertEquals(1, count($matches));
    }

    public function getUsersNameAndEmail($id)
    {
        $user = new User();

        $user->retrieve($id);

        $actual = $user->getUsersNameAndEmail();

        self::assertEquals('firstn lastn', $actual['name']);
        self::assertEquals(1, preg_match('/^one\d{0,}\@email\.com$/', $actual['email']));
    }


    public function getEmailInfo($id)
    {
        $user = new User();

        $actual = $user->getEmailInfo($id);

        self::assertEquals('firstn lastn', $actual['name']);
        self::assertEquals(1, preg_match('/^one\d{0,}\@email\.com$/', $actual['email']));
    }


    public function testencrypt_password()
    {
        $user = new User();

        $result = $user->encrypt_password("test");
        $this->assertTrue(isset($result));
        $this->assertGreaterThan(0, strlen($result));
    }

    public function testgetPasswordHash()
    {
        $result = User::getPasswordHash("test");

        $this->assertTrue(isset($result));
        $this->assertGreaterThan(0, strlen($result));
    }


    public function testcheckPassword()
    {

        //test with empty password and empty hash
        $result = User::checkPassword("", '');
        $this->assertEquals(false, $result);


        //test with valid hash and empty password
        $result = User::checkPassword("", '$1$Gt0.XI4.$tVVSXgE36sfsVMBNo/9la1');
        $this->assertEquals(false, $result);


        //test with valid password and invalid hash
        $result = User::checkPassword("test", '$1$Gt0.XI4.$tVVSXgE36sfsVMBNo/9la2');
        $this->assertEquals(false, $result);


        //test with valid password and valid hash
        $result = User::checkPassword("test", '$1$Gt0.XI4.$tVVSXgE36sfsVMBNo/9la1');
        $this->assertEquals(true, $result);
    }


    public function testcheckPasswordMD5()
    {

        //test with empty password and empty hash
        $result = User::checkPasswordMD5(md5(""), '');
        $this->assertEquals(false, $result);


        //test with valid hash and empty password
        $result = User::checkPasswordMD5(md5(""), '$1$Gt0.XI4.$tVVSXgE36sfsVMBNo/9la1');
        $this->assertEquals(false, $result);


        //test with valid password and invalid hash
        $result = User::checkPasswordMD5(md5("test"), '$1$Gt0.XI4.$tVVSXgE36sfsVMBNo/9la2');
        $this->assertEquals(false, $result);


        //test with valid password and valid hash
        $result = User::checkPasswordMD5(md5("test"), '$1$Gt0.XI4.$tVVSXgE36sfsVMBNo/9la1');
        $this->assertEquals(true, $result);
    }


    public function testis_authenticated()
    {
        $user = new User();

        //test without setting name
        $this->assertEquals(false, $user->is_authenticated());

        //test with name set
        $user->authenticated = true;
        $this->assertEquals(true, $user->is_authenticated());
    }

    public function testfill_in_additional_list_fields()
    {
        self::markTestIncomplete('environment dependency');
        
        $user = new User();

        $user->retrieve(1);

        $user->fill_in_additional_list_fields();

        $this->assertEquals("Administrator", $user->full_name);
    }

    public function testfill_in_additional_detail_fields()
    {
        self::markTestIncomplete('environment dependency');
        
        $user = new User();

        $user->retrieve(1);

        $user->fill_in_additional_detail_fields();

        $this->assertEquals("Administrator", $user->full_name);
    }

    public function testretrieve_user_id()
    {
        self::markTestIncomplete('environment dependency');
        
        $user = new User();

        $result1 = $user->retrieve_user_id('admin');
        $result2 = $user->retrieve_user_id('automated_tester');
        static::assertFalse($result1 == '1' && $result2 == '1');
        static::assertTrue($result1 == '1' || $result2 == '1');
    }


    public function testverify_data()
    {
        global $mod_strings;
        include __DIR__ . '/../../../../../modules/Users/language/en_us.lang.php';

        $mod_strings['ERR_EMAIL_NO_OPTS'] = "";

        $user = BeanFactory::getBean('Users');

        $user->retrieve(1);

        //test with default/true
        $result = $user->verify_data();
        $this->assertEquals(true, $result);


        //test with false
        $result = $user->verify_data(false);
        $this->assertEquals(false, $result);
    }

    public function testget_list_view_data()
    {
        // store state
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        // test
        global $mod_strings;
        $mod_strings['LBL_CHECKMARK'] = "";

        $user = new User();

        $user->retrieve(1);

        $result = $user->get_list_view_data();
        $this->assertTrue(is_array($result));
        
        // clean up
        $state->popTable('email_addresses');
        $state->popGlobals();
    }

    public function testlist_view_parse_additional_sections()
    {
        $user = new User();

        $list_form = array();
        $result = $user->list_view_parse_additional_sections($list_form);
        $this->assertSame($list_form, $result);
    }

    public function testGetAllUsersAndGetActiveUsers()
    {
        $all_users = User::getAllUsers();
        $this->assertTrue(is_array($all_users));

        $active_users = User::getActiveUsers();
        $this->assertTrue(is_array($active_users));

        $this->assertGreaterThanOrEqual(count($active_users), count($all_users));
    }


    public function testcreate_export_query()
    {
        $user = new User();

        //test with empty string params
        $expected = "SELECT id, user_name, first_name, last_name, description, date_entered, date_modified, modified_user_id, created_by, title, department, is_admin, phone_home, phone_mobile, phone_work, phone_other, phone_fax, address_street, address_city, address_state, address_postalcode, address_country, reports_to_id, portal_only, status, receive_notifications, employee_status, messenger_id, messenger_type, is_group FROM users  WHERE  users.deleted = 0 AND users.is_admin=0 ORDER BY users.user_name";
        $actual = $user->create_export_query('', '');
        $this->assertSame($expected, $actual);


        //test with valid string params
        $expected = "SELECT id, user_name, first_name, last_name, description, date_entered, date_modified, modified_user_id, created_by, title, department, is_admin, phone_home, phone_mobile, phone_work, phone_other, phone_fax, address_street, address_city, address_state, address_postalcode, address_country, reports_to_id, portal_only, status, receive_notifications, employee_status, messenger_id, messenger_type, is_group FROM users  WHERE user_name=\"\" AND  users.deleted = 0 AND users.is_admin=0 ORDER BY id";
        $actual = $user->create_export_query('id', 'user_name=""');
        $this->assertSame($expected, $actual);
    }


    public function testget_meetings()
    {
        $user = new User();

        $result = $user->get_meetings();
        $this->assertTrue(is_array($result));
    }

    public function testget_calls()
    {
        $user = new User();

        //$result = $user->get_calls();
        //$this->assertTrue(is_array($result));

        $this->markTestIncomplete('Error:Only variables should be passed by reference');
    }


    public function testdisplayEmailCounts()
    {
        $user = new User();

        $expected = '<script type="text/javascript" language="Javascript">var welcome = document.getElementById("welcome");var welcomeContent = welcome.innerHTML;welcome.innerHTML = welcomeContent + "&nbsp;&nbsp;&nbsp;&nbsp;<a href=index.php?module=Emails&action=ListViewGroup>Group Inbox: (0 New)</a>";</script>';

        //cpature the screen output and compare with exected values

        ob_start();

        $user->displayEmailCounts();

        $renderedContent = ob_get_contents();
        ob_end_clean();

        $this->assertSame($expected, $renderedContent);
    }


    public function testgetSystemDefaultNameAndEmail()
    {
        $user = new User();

        $expected = array('email', 'name');
        $actual = array_keys($user->getSystemDefaultNameAndEmail());
        $this->assertSame($expected, $actual);
    }


    public function testsetDefaultsInConfig()
    {
        self::markTestIncomplete('Incorrect state hash (in PHPUnitTest): Hash doesn\'t match at key "filesys::/var/www/html/SuiteCRM/config.php".');
        $user = new User();

        $result = $user->setDefaultsInConfig();

        $this->assertTrue(is_array($result));
        $this->assertEquals('sugar', $result['email_default_client']);
        $this->assertEquals('html', $result['email_default_editor']);
    }


    public function testgetEmailLink2()
    {
        // store state
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        // test
        $user = new User();

        $user->retrieve(1);


        //test with accounts module
        $account = new Account();
        $account->name = "test";

        /** @var SugarEmailAddress $emailAddress*/
        $emailAddress =& $account->emailAddress;
        $emailAddress->addAddress('abc@email.com');

        $expected =
            '            <a class="email-link" href="mailto:abc@email.com"
                    onclick="$(document).openComposeViewModal(this);"
                    data-module="Accounts" data-record-id=""
                    data-module-name="test" data-email-address="abc@email.com"
                >abc@email.com</a>';
        $actual = $user->getEmailLink2("abc@email.com", $account);
        $this->assertSame($expected, $actual);


        //test with contacts module
        $contact = new Contact();
        // Contact name auto populate from first name and last name, so we need set value for first name or last name to test insteard set value for name
        $contact->first_name = "test";

        /** @var SugarEmailAddress $emailAddress*/
        $emailAddress =& $contact->emailAddress;
        $emailAddress->addAddress('abc@email.com');

        $expected =
            '            <a class="email-link" href="mailto:abc@email.com"
                    onclick="$(document).openComposeViewModal(this);"
                    data-module="Contacts" data-record-id=""
                    data-module-name="test" data-email-address="abc@email.com"
                >abc@email.com</a>';
        $actual = $user->getEmailLink2("abc@email.com", $contact);
        $this->assertSame($expected, $actual);
        
        // clean up
        
        $state->popTable('email_addresses');
        $state->popGlobals();
    }


    public function testgetEmailLink()
    {
        $this->markTestIncomplete('Need to mock up user');
        $user = new User();

        $user->retrieve(1);


        //test with accounts module
        $account = new Account();
        $account->name = "test";

        $expected =
            '<a class="email-link"'
            . ' onclick=" $(document).openComposeViewModal(this);" data-module="Accounts"'
            . ' data-record-id="" data-module-name="test"  data-email-address=""></a>';
        $actual = $user->getEmailLink("name", $account);
        $this->assertSame($expected, $actual);


        //test with contacts module
        $contact = new Contact();
        // Contact name auto populate from first name and last name, so we need set value for first name or last name to test insteard set value for name
        $contact->first_name = "test";

        $expected =
            '<a href="javascript:void(0);"'
            . ' onclick="$(document).openComposeViewModal(this);" data-module="Contacts"'
            . ' data-record-id="" data-module-name="test" data-email-address=""></a>';
        $actual = $user->getEmailLink("name", $contact);
        $this->assertSame($expected, $actual);
    }

    public function testgetLocaleFormatDesc()
    {
        $user = new User();

        $result = $user->getLocaleFormatDesc();
        $this->assertTrue(isset($result));
        $this->assertGreaterThan(0, strlen($result));
    }

    public function testisAdmin()
    {
        $user = new User();

        //test without setting attribute
        $this->assertEquals(false, $user->isAdmin());

        //test with attribute set
        $user->is_admin = 1;
        $this->assertEquals(true, $user->isAdmin());
    }

    public function testisDeveloperForAnyModule()
    {
        $user = new User();

        //test without setting is_admin
        $this->assertEquals(false, $user->isDeveloperForAnyModule());


        //test with id set
        $user->id = 1;
        $this->assertEquals(false, $user->isDeveloperForAnyModule());


        //test with id and is_admin set
        $user->is_admin = 1;
        $this->assertEquals(true, $user->isDeveloperForAnyModule());
    }

    public function testgetDeveloperModules()
    {
        // store state
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        // test
        $user = new User();

        $user->retrieve(1);

        $result = $user->getDeveloperModules();
        $this->assertTrue(is_array($result));
        
        // clean up
        $state->popTable('email_addresses');
        $state->popGlobals();
    }

    public function testisDeveloperForModule()
    {
        // store state
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        // test
        $user = new User();


        //test without setting is_admin
        $this->assertEquals(false, $user->isDeveloperForModule("Accounts"));


        //test with id set
        $user->id = 1;
        $this->assertEquals(false, $user->isDeveloperForModule("Accounts"));


        //test with id and is_admin set
        $user->is_admin = 1;
        $this->assertEquals(true, $user->isDeveloperForModule("Accounts"));
        
        // clean up
        $state->popTable('email_addresses');
        $state->popGlobals();
    }

    public function testgetAdminModules()
    {
        // store state
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        // test
        $user = new User();

        $user->retrieve(1);

        $result = $user->getAdminModules();
        $this->assertTrue(is_array($result));
        
        // clean up
        $state->popTable('email_addresses');
        $state->popGlobals();
    }

    public function testisAdminForModule()
    {
        // store state
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        // test
        $user = new User();

        //test without setting is_admin
        $this->assertEquals(false, $user->isAdminForModule("Accounts"));

        //test with id set
        $user->id = 1;
        $this->assertEquals(false, $user->isAdminForModule("Accounts"));

        //test with id and is_admin set
        $user->is_admin = 1;
        $this->assertEquals(true, $user->isAdminForModule("Accounts"));
        
        
        // clean up
        $state->popTable('email_addresses');
        $state->popGlobals();
    }

    public function testshowLastNameFirst()
    {
        $user = new User();

        $result = $user->showLastNameFirst();
        $this->assertEquals(false, $result);
    }

    /**
     * @todo: NEEDS FIXING!
     */
    public function testcreate_new_list_query()
    {
        /*
            $user = new User();

            //test with empty string params
            $expected = " SELECT  users.* , '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt2.last_name reports_to_name , jt2.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id  FROM users   LEFT JOIN  users jt2 ON users.reports_to_id=jt2.id AND jt2.deleted=0\n\n AND jt2.deleted=0 where users.deleted=0";
            $actual = $user->create_new_list_query('','');
            $this->assertSame($expected,$actual);



            //test with valid string params
            $expected = " SELECT  users.* , '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt2.last_name reports_to_name , jt2.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id  FROM users   LEFT JOIN  users jt2 ON users.reports_to_id=jt2.id AND jt2.deleted=0\n\n AND jt2.deleted=0 where (user_name=\"\") AND users.deleted=0 ORDER BY users.id";
            $actual = $user->create_new_list_query('id','user_name=""');
            $this->assertSame($expected,$actual);
        */
        $this->assertTrue(true, "NEEDS FIXING!");
    }


    public function testget_first_day_of_week()
    {
        $user = new User();

        $result = $user->get_first_day_of_week();
        $this->assertTrue(is_numeric($result));
    }


    public function testgeneratePassword()
    {
        //generate apsswords and verify they are not same

        $password1 = User::generatePassword();
        $this->assertGreaterThan(0, strlen($password1));

        $password2 = User::generatePassword();
        $this->assertGreaterThan(0, strlen($password2));

        $this->assertNotEquals($password1, $password2);
    }


    public function testsendEmailForPassword()
    {
        $user = new User();

        $result = $user->sendEmailForPassword("1");

        //expected result is a array with template not found message.
        $this->assertTrue(is_array($result));
    }


    public function testafterImportSave()
    {
        $user = new User();

        //execute the method and test if it works and does not throws an exception.
        try {
            $result = $user->afterImportSave();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertStringStartsWith('Cannot modify header information', $e->getMessage());
        }
    }


    public function testisPrimaryEmail()
    {
        $user = new User();

        //test without user email
        $this->assertEquals(false, $user->isPrimaryEmail("abc@abc.com"));


        //test with non matching user email
        $user->email1 = "xyz@abc.com";
        $this->assertEquals(false, $user->isPrimaryEmail("abc@abc.com"));


        //test with matching user email
        $user->email1 = "abc@abc.com";
        $this->assertEquals(true, $user->isPrimaryEmail("abc@abc.com"));
    }
    
    public function testError()
    {
        global $app_strings;
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('email_addresses_audit');

        // setup
        $this->assertTrue(!isset($app_strings['TEST_ERROR_MESSAGE']));
        
        // test if there is no error
        
        ob_start();
        include __DIR__ . '/../../../../../modules/Users/Error.php';
        $contents = ob_get_contents();
        ob_end_clean();
        $expected = '<span class=\'error\'><br><br>' . "\n" . $app_strings['NTC_CLICK_BACK'] . '</span>';
        $this->assertContains($expected, $contents);
        
        // test if there is an error
        
        $app_strings['TEST_ERROR_MESSAGE'] = 'Hello error';
        $request['error_string'] = 'TEST_ERROR_MESSAGE';
        $this->assertEquals($request['error_string'], 'TEST_ERROR_MESSAGE');
        ob_start();
        include __DIR__ . '/../../../../../modules/Users/Error.php';
        $contents = ob_get_contents();
        ob_end_clean();
        $expected = '<span class=\'error\'>Hello error<br><br>' . "\n"  . $app_strings['NTC_CLICK_BACK'] . '</span>';
        $this->assertContains($expected, $contents);
        
        // clean up
        unset($app_strings['TEST_ERROR_MESSAGE']);

        $state->popTable('email_addresses_audit');
    }
}
